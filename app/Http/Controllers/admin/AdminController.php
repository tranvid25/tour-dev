<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Admin;
use App\Models\clients\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(string $id){
        $admin=Admin::findOrFail($id);
        return response()->json([
            'admin'=>$admin
        ]);
    }
    public function show(string $id){
        $user=User::findOrFail($id);
        return response()->json([
            'user'=>$user
        ]);
    }
    public function create(Request $request){
        $validator=Validator::make($request->all(),[
            'userName' => 'required|string|max:255|unique:tbl_admin,userName',
            'email' => 'required|email|unique:tbl_admin,email',
            'passWord' => 'required|string|min:6|confirmed', // dùng input passWord_confirmation
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $admin=Admin::create([
            'userName'=>$request->userName,
            'email'=>$request->email,
            'passWord'=>Hash::make($request->passWord)
        ]);
        $token=$admin->createToken('AdminToken')->accessToken;
        return response()->json([
            'message'=>'Admin created successfully',
            'token'=>$token,
            'admin'=>$admin
        ]);
    }
    public function loginPost(Request $request){
       $validator=Validator::make($request->all(),[
        'email'=>'required|email',
        'passWord'=>'required|string',
       ]);
       if($validator->fails()){
          return response()->json($validator->errors(),422);
       }
        $admin=Admin::where('email',$request->email)->first();
        if(!$admin || !Hash::check($request->passWord,$admin->passWord)){
            return response()->json([
                'message'=>'Email hoặc mật khẩu nhập không đúng'
            ],404);
        }
        $token=$admin->createToken('AdminToken')->accessToken;
        return response()->json([
            'message'=>'Đăng nhập thành công',
            'token'=>$token,
            'admin'=>$admin
        ]);
    }
    public function update(Request $request, string $id)
{
    // Validate dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'userName' => 'required|string|max:255|unique:tbl_admin,userName,' . $id,
        'email' => 'required|email|unique:tbl_admin,email,' . $id,
        'passWord' => 'nullable|string|min:6|confirmed', // PassWord là optional
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Kiểm tra avatar (nếu có)
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Tìm admin cần cập nhật theo ID
    $admin = Admin::findOrFail($id);

    // Lấy dữ liệu từ request (ngoại trừ avatar)
    $data = $request->except('avatar');

    // Kiểm tra và xử lý avatar
    if ($request->hasFile('avatar')) {
        // Lấy thông tin avatar mới
        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Lưu file avatar mới vào thư mục uploads/avatars/admin
        $file->move(public_path('uploads/avatars/admin'), $filename);

        // Cập nhật trường avatar trong dữ liệu
        $data['avatar'] = $filename;

        // Xóa avatar cũ nếu có
        if ($admin->avatar && file_exists(public_path('uploads/avatars/admin/' . $admin->avatar))) {
            unlink(public_path('uploads/avatars/admin/' . $admin->avatar));
        }
    } else {
        // Nếu không có avatar mới, giữ avatar cũ
        $data['avatar'] = $admin->avatar;
    }

    // Cập nhật thông tin admin
    if ($admin->update($data)) {
        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin
        ], 200);
    }

    return response()->json([
        'message' => 'Cập nhật thất bại. Vui lòng thử lại.'
    ], 500);
}



public function logoutAdmin(Request $request)
{
    Auth::guard('admin-api')->user()->tokens->each(function ($token) {
        $token->delete();
    });

    return response()->json(['message' => 'Admin logout successful']);
}
}
