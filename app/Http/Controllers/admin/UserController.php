<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\User;
use Hash;
use Auth;

class UserController extends Controller
{
    public function getIndex() {
        return view("admin.pages.nguoi-dung.index");
    }
    
    public function anyData()
    {
        $users = User::select(['id', 'full_name', 'email', 'phone_number', 'created_at']);

        return Datatables::of($users)
        ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
        ->addColumn('action', function ($user) {

            $action = '<a href="'.route('users.sua', ['id' => $user->id]).'" class="btn btn-icon rounded-circle btn-outline-warning mr-1 mb-1 waves-effect waves-light"><i class="fa fa-edit"></i></a>';
            $action .= '<button type="button" data-role="remove" onclick="remove(\''.route('users.xoa', ['id' => $user->id]).'\')" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light"><i class="fa fa-trash"></i></button>';
            $action .= '<a href="'.route('users.login', ['id' => $user->id]).'" class="btn btn-icon rounded-circle btn-outline-primary mr-1 mb-1 waves-effect waves-light" target="_blank"><i class="fa fa-user-secret"></i></a>';

            return $action;
        })
        ->make(true);
    }

    public function getThem() {
        return view("admin.pages.nguoi-dung.them");
    }

    public function postThem(Request $request) {
        $this->validate($request, [
            'full_name'=>'bail|required|max:50',
            'phone_number'=>'bail|required|regex:/^(0)[0-9]{9}$/',
            'email'=>'bail|required|email|unique:users,email',
            'address'=>'required',
            'password'=>'bail|required|min:4',
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
            'password.min'=>'Mật khẩu ít nhất 4 kí tự'
        ]);

        $user = new User();
        
        $user->full_name = $request->full_name;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->address = $request->address;

        $user->save();

        return redirect()->back()->with('success', 'Đã thêm người dùng thành công');
    }

    public function getSua(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $user = User::find($id);

        if($user == null) {
            return redirect()->back();
        }

        return view("admin.pages.nguoi-dung.sua", compact('user'));
    }

    public function postSua(Request $request) {
        $this->validate($request, [
            'full_name'=>'bail|required|max:50',
            'phone_number'=>'bail|required|regex:/^(0)[0-9]{9}$/',
            'address'=>'required',
        ], [
            'full_name.required'=>'Vui lòng nhập họ tên',
            'full_name.max'=>'Họ tên tối đa 50 kí tự',

            'phone_number.required'=>'Vui lòng nhập số điện thoại',
            'phone_number.regex'=>'Số điện thoại không chính xác',

            'address.required'=>'Vui lòng nhập địa chỉ'
        ]);
        
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $user = User::find($id);
        
        if($user == null) {
            return redirect()->back();
        }
        
        $user->full_name = $request->full_name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;

        $user->save();

        return redirect()->back()->with('success', 'Đã sửa người dùng thành công');
    }

    public function getXoa(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        User::destroy($request->id);
        return redirect()->back()->with('success', 'Đã xoá người dùng thành công');
    }

    public function getLogin(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        if(Auth::guard('web')->loginUsingId($id)) {
            return redirect()->route('index');
        }
        return redirect()->back();
    }
}