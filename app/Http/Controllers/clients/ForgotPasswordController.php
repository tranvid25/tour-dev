<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request){
        $request->validate([
            'email'=>'required|email',
        ]);
        $status =   Password::sendResetLink(
            $request->only('email')
        );

        // Trả về response theo dạng API
        return $status == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Mã đặt lại mật khẩu đã được gửi đến email của bạn.'], 200)
            : response()->json(['error' => 'Không thể gửi mã đặt lại mật khẩu.'], 400);
    }
    public function reset(Request $request)
    {
        // Validate input
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Đặt lại mật khẩu
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->passWord = Hash::make($password);
                $user->save();
            }
        );

        // Trả về response theo dạng API
        return $status == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Mật khẩu của bạn đã được đặt lại thành công.'], 200)
            : response()->json(['error' => 'Có lỗi xảy ra trong quá trình đặt lại mật khẩu.'], 400);
    }
}
