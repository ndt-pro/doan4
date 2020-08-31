<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extension\Captcha;
use App\Models\User;
use Hash;
use Session;
use Auth;

class UserController extends Controller
{
    public function getDangKy() {
        $captcha = Captcha::putCaptcha();
        Session::put('captcha_code', $captcha['code']);
        return view("pages.dangky", compact('captcha'));
    }

    public function postDangKy(Request $request) {
        $captcha_code = Session::get("captcha_code");
        $this->validate($request, [
            'full_name'=>'bail|required|max:50',
            'phone_number'=>'bail|required|regex:/^(0)[0-9]{9}$/',
            'email'=>'bail|required|email|unique:users,email',
            'address'=>'required',
            'password'=>'bail|required|min:4|confirmed',
            'password_confirmation'=>'required',
            'captcha_code'=>'bail|required|regex:/^('.$captcha_code.')$/'
        ], [
            'full_name.required'=>'Vui lòng nhập họ tên',
            'full_name.max'=>'Họ tên tối đa 50 kí tự',

            'phone_number.required'=>'Vui lòng nhập số điện thoại',
            'phone_number.regex'=>'Số điện thoại không chính xác',

            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Email không đúng định dạng',
            'email.unique'=>'Email này đã có người sử dụng',

            'address.required'=>'Vui lòng nhập địa chỉ',

            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 4 kí tự',
            'password.confirmed'=>'Mật khẩu xác nhận không khớp',

            'password_confirmation.required'=>'Vui lòng nhập mật khẩu xác nhận',

            'captcha_code.required'=>'Vui lòng nhập mã xác nhận',
            'captcha_code.regex'=>'Mã xác nhận không chính xác'
        ]);

        $user = new User();
        
        $user->full_name = $request->full_name;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->address = $request->address;

        $user->save();

        $credentials = [
            'email'=>$user->email,
            'password'=>$request->password
        ];

        if (Auth::attempt($credentials)) {
            // login successfully, return index
            return redirect()->route("index");
        } else {
            // login failed
            return redirect()->back()->with('danger', '1');
        }
    }

    public function getDangNhap() {
        return view("pages.dangnhap");
    }

    public function postDangNhap(Request $request) {
        $this->validate($request, [
            'email'=>'bail|required|email',
            'password'=>'required',
        ], [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Email không đúng định dạng',

            'password.required'=>'Vui lòng nhập mật khẩu',
        ]);

        $credentials = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if (Auth::attempt($credentials)) {
            // login successfully, return index
            return redirect()->route("index");
        } else {
            // login failed
            return redirect()->back()->with('danger', '1');
        }
    }

    public function getLogout() {
        Auth::logout();
        return redirect()->route("index");
    }
}