<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MasterController extends Controller
{
    public function getIndex() {
        return view("admin.pages.index");
    }

    public function getThanhPho() {
        $list = DB::table('data_thanh_pho')->get();
        return response()->json($list);
    }

    public function getQuanHuyen(Request $request) {
        if($request->has('matp')) {
            $list = DB::table('data_quan_huyen')->where('matp', $request->matp)->get();
            return response()->json($list);
        }
    }

    public function getXaPhuong(Request $request) {
        if($request->has('maqh')) {
            $list = DB::table('data_xa_phuong')->where('maqh', $request->maqh)->get();
            return response()->json($list);
        }
    }
}