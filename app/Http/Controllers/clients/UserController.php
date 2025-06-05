<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Models\clients\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'user' => $user->expert(['password'])
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
        Auth::guard('api')->user()->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json(['message' => 'User logout successfull']);
    }
    public function loginGoogle(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $client = new Client();

        // Verify token Google bằng gọi API Google
        $response = $client->get('https://oauth2.googleapis.com/tokeninfo', [
            'query' => ['id_token' => $request->id_token],
        ]);

        $googleUser = json_decode($response->getBody(), true);

        if (!isset($googleUser['email_verified']) || $googleUser['email_verified'] !== 'true') {
            return response()->json(['message' => 'Email chưa được xác thực bởi Google.'], 403);
        }

        // Lấy email, name, avatar
        $email = $googleUser['email'];
        $name = $googleUser['name'] ?? explode('@', $email)[0];
        $avatar = $googleUser['picture'] ?? null;

        // Tìm hoặc tạo user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'userName' => $name,
                'avatar' => $avatar,
                'passWord' => bcrypt(Str::random(16)), // pass ngẫu nhiên
                'google_logged_in' => true,
            ]
        );

        if ($user->tinh_trang != 1) {
            return response()->json(['message' => 'Tài khoản đã bị khóa.'], 403);
        }

        // Tạo token passport
        $token = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => $user,
        ]);
    }
    public function loginGoogleC2(Request $request)
    { {
            // Validate id_token
            $request->validate([
                'id_token' => 'required|string'
            ]);

            // Xác thực token với Google và lấy thông tin người dùng
            $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->id_token
            ]);

            // Nếu Google trả về lỗi hoặc không hợp lệ
            if ($response->failed()) {
                return response()->json([
                    'message' => 'Token không hợp lệ hoặc không thể truy cập Google'
                ], 401);
            }

            // Xác thực token thành công, lấy thông tin người dùng từ Google
            $googleUser = $response->json();

            // Kiểm tra xem token có hợp lệ và có email không
            if (!isset($googleUser['email'])) {
                return response()->json([
                    'message' => 'Token không chứa thông tin người dùng'
                ], 400);
            }

            // Gọi API để lấy thông tin chi tiết người dùng
            $userInfoResponse = Http::withToken($request->id_token)->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if ($userInfoResponse->failed()) {
                return response()->json([
                    'message' => 'Không thể lấy thông tin người dùng từ Google'
                ], 400);
            }

            $userInfo = $userInfoResponse->json();

            // Lấy thông tin email, name, avatar từ thông tin người dùng
            $email = $userInfo['email'];
            $name = $userInfo['name'] ?? 'Google User';
            $avatar = $userInfo['picture'] ?? null;

            // Tìm hoặc tạo người dùng mới trong cơ sở dữ liệu
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'userName' => $name,
                    'passWord' => bcrypt(uniqid()), // Tạo password ngẫu nhiên nếu user mới
                    'avatar' => $avatar,
                    'google_logged_in' => true
                ]
            );

            // Tạo token Passport cho người dùng
            $token = $user->createToken('GoogleToken')->accessToken;

            // Trả về thông tin người dùng và token
            return response()->json([
                'message' => 'Đăng nhập thành công',
                'token' => $token,
                'user' => $user
            ]);
        }
    }
}
