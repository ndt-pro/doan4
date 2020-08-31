<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config\Brand;
use App\Extension\Extension;
use Storage;

class BrandController extends Controller
{
    public function getIndex() {
        $brands = Brand::paginate(10);

        return view("admin.pages.brand.index", compact('brands'));
    }

    public function getJsonData(Request $request) {
        if($request->has('id')) {
            $brand = Brand::find($request->id);

            return response()->json($brand);
        }
        return response()->json(new class{});
    }

    public function postAction(Request $request) {
        $this->validate($request, [
            'action'=>'required',
            'id'=>'required',
            'image'=>'bail|image'
        ], [
            'action.required'=>'Thiếu hành động',

            'id.required'=>'Thiếu id',

            'image.image'=>'Vui lòng sử dụng ảnh để upload',
        ]);

        if($request->hasFile("image")) {
            $file = $request->image;
    
            $file_name = $file->getClientOriginalName();
            $file_extension = $file->getClientOriginalExtension();
    
            $file_name = Extension::generate_file_name($file_extension);
    
            $path = Storage::disk('storage')->putFileAs(
                'brand',
                $file,
                $file_name
            );
        } elseif($request->action == 'add') {
            return redirect()->back()->with('error', 'Vui lòng chọn một ảnh');
        }

        if($request->action == 'add') {
            // add brand
            $brand = new Brand();
    
            $brand->image = $file_name;
            $brand->show = $request->show;
            $brand->timestamps = false;
    
            $brand->save();
            return redirect()->back()->with('success', 'Đã thêm nhãn hiệu thành công.');
        } else {
            // edit brand
            $brand = Brand::find($request->id);

            if($brand != null) {
                if(isset($file_name)) {
                    $brand->image = $file_name;
                }
                $brand->show = $request->show;
                $brand->timestamps = false;
    
                $brand->save();
                return redirect()->back()->with('success', 'Đã sửa nhãn hiệu thành công.');
            } else {
                return redirect()->back()->with('error', 'Thao tác không thể thực hiện.');
            }
        }
    }

    public function getXoa(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        Brand::destroy($request->id);

        return redirect()->back()->with('success', 'Đã xoá nhãn hiệu thành công');
    }
}
