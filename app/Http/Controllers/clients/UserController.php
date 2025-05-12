<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(string $id){
        $user=User::findOrFail($id);
        return response()->json([
            'user'=>$user->expert(['password'])
        ]);
    }
    public function register(Request $request)
    {
        // Kiểm tra validation
        $validator = Validator::make($request->all(), [
            'userName' => 'required|string|max:255|unique:tbl_users,userName',
            'email' => 'required|email|unique:tbl_users,email',
            'passWord' => 'required|string|min:6|confirmed',
            'phoneNumber' => 'nullable|string|max:20|unique:tbl_users,phoneNumber',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Xử lý avatar
        $filename = null;
        $file = $request->file('avatar');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
        }

        // Tạo người dùng mới
        $user = User::create([
            'userName' => $request->userName,
            'email' => $request->email,
            'passWord' => Hash::make($request->passWord),
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address,
            'avatar' => $filename,
        ]);

        // Tạo token
        $token = $user->createToken('UserToken')->accessToken;

        // Trả về thông tin
        if ($user) {
            return response()->json([
                'message' => 'User created successfully',
                'token' => $token,
                'user' => $user->only(['userId', 'userName', 'email', 'phoneNumber', 'address', 'avatar']),
                'avatar_url' => asset('uploads/avatars/' . $filename)
            ], 200);
        } else {
            return response()->json(['message' => 'Cập nhật thất bại. Vui lòng thử lại.'], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'passWord' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->passWord, $user->passWord)) {
            return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 404);
        }

        // Tạo token
        $token = $user->createToken('UserToken')->accessToken;
        
        return response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => $user->only(['userId', 'userName', 'email']),
        ]);
    }

    public function update(Request $request, string $id)
{
    $user = User::where('userId', $id)->first();

    if (!$user) {
        return response()->json(['message' => 'Người dùng không tồn tại'], 404);
    }

    // Validation: không check unique nếu không thay đổi
    $validator = Validator::make($request->all(), [
        'userName' => 'required|string|max:255|unique:tbl_users,userName,' . $id . ',userId',
        'email' => 'required|email|unique:tbl_users,email,' . $id . ',userId',
        'phoneNumber' => 'nullable|string|max:20|unique:tbl_users,phoneNumber,' . $id . ',userId',
        'address' => 'nullable|string|max:500',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Xử lý avatar
    $file = $request->file('avatar');
    if ($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/avatars'), $fileName);
        $user->avatar = $fileName;
    }

    // Cập nhật các thông tin khác
    $user->userName = $request->userName;
    $user->email = $request->email;
    $user->phoneNumber = $request->phoneNumber;
    $user->address = $request->address;

    if ($user->save()) {
        return response()->json([
            'message' => 'Cập nhật thành công',
            'user' => $user->only(['userId', 'userName', 'avatar', 'email', 'phoneNumber', 'address']),
            'avatar_url' => asset('uploads/avatars/' . $user->avatar),
        ]);
    }

    return response()->json(['message' => 'Cập nhật thất bại'], 400);
}
   public function logout(Request $request)
{
    Auth::guard('api')->user()->tokens->each(function($token){
        $token->delete();
    });
    return response()->json(['message'=>'User logout successfull']);
}

}
