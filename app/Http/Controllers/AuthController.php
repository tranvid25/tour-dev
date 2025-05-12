<?php

namespace App\Http\Controllers;

use App\Models\clients\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index_login(){
        return view('clients.login');
    }
    public function index_register(){
        return view('clients.register');
    }
    public function register(Request $request){
        $request->validate([
            'userName'=>'required|string',
            'email'=>'required|string|unique:tbl_users,',
            'passWord'=>'required|min:6|confirmed',
        ]);
        $user=User::create([
            'userName'=>$request->userName,
            'emal'=>$request->email,
            'passWord'=>Hash::make($request->passWord)
        ]);
        return redirect()->route('login')->with('success','Đăng ký thành công');
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required|string|unique:tbl_users,',
            'passWord'=>'required|string',
        ]);

        $user=User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->passWord,$user->passWord)){
            return redirect()->back()->with('error','Email hoặc mật khẩu không đúng');
        }
        else{
            return redirect()->route('login')->with('success','Đăng nhập thành công');
        }



    }
}
