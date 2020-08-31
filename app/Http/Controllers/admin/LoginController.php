<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/admin';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest:admin')->except('getLogout');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function getLogin()
    {
        $username = '';
        $password = '';
        $remember = '';

        if(Cookie::has('username') && Cookie::has('password')) {
            $username = Cookie::get('username');
            $password = Cookie::get('password');
            $remember = Cookie::get('remember');
        }

        return view('admin.pages.login', compact('username', 'password', 'remember'));
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username'=>'required',
            'password'=>'required',
        ], [
            'username.required'=>'Vui lòng nhập tên đăng nhập',

            'password.required'=>'Vui lòng nhập mật khẩu',
        ]);

        if($request->has('remember')) {
            // save cookie
            Cookie::queue(cookie()->forever('username', $request->username));
            Cookie::queue(cookie()->forever('password', $request->password));
            Cookie::queue(cookie()->forever('remember', '1'));
        } else {
            // remove cookie
            Cookie::queue('username', '', -1);
            Cookie::queue('password', '', -1);
            Cookie::queue('remember', '', -1);
        }

        $credentials = [
            'username'=>$request->username,
            'password'=>$request->password
        ];

        if ($this->guard()->attempt($credentials)) {
            // login successfully, return index
            return redirect()->route("admin.index");
        } else {
            // login failed
            return redirect()->back()->with('danger', '1');
        }
    }

    public function getLogout() {
        $this->guard()->logout();
        return redirect()->route('admin.login');
    }
}
