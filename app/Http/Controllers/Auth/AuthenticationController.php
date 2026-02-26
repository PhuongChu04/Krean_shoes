<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;
use Carbon\Exceptions\EndLessPeriodException;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticationController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function postLogin(Request $req){
        $dataUserLogin = [
            'email' => $req->email,
            'password' => $req->password
        ];
        $remember = $req->has('remember');
        if(Auth::attempt($dataUserLogin,  $remember)){
            //logout all account
        Session::where('user_id',Auth::id())->delete();
        // tạo đăng nhập mới
        session()->put('user_id',Auth::id());
            if(Auth::user()->role == '1'){
                 return redirect()->route('admin.homeAdmin')->with([
                'message' => 'Đăng nhập thành công'
            ]);
            }else{
                return redirect()->route('client.homeClient')->with([
                'message' => 'Đăng nhập thành công'
                ]);
            }
           
        }else{
            return redirect()->back()->with([
                'message' => 'Email hoặc password không đúng'
            ]);
        }
    }
    public function register(){
        return view('auth.register');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('auth.login')->with([
            'message' => 'Đăng xuất thành công'
        ]);
    }
    public function postRegister(Request $req){
        $check = User::where('email', $req->email)->exists();
        if($check){
            return redirect()->back()->with([
                'massage' => 'Tài khoản email đã tồn tại'
            ]);
        }else{
            $data = [
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password)
            ];
            $newUser = User::create($data);
            // Auth::login($newUser);  //tự động đăng nhập user
            // return redirect()->route('client.homeClient');
            return redirect()->route('auth.login')->with([
                'message' => 'Đăng kí thành công'
            ]);
        }
    }
}
