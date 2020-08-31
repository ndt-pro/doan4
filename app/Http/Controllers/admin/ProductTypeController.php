<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\ProductType;
use App\Extension\Extension;
use Storage;

class ProductTypeController extends Controller
{
    public function getIndex() {
        return view("admin.pages.loai-san-pham.index");
    }
    
    public function anyData()
    {
        $products_type = ProductType::select(['id', 'name', 'description', 'logo', 'created_at']);

        return Datatables::of($products_type)
        ->editColumn('logo', function($product_type) {
            return '<div class="avatar-group">
                <span class="avatar avatar-lg rounded-circle">
                    <img src="storage/products-type/'.$product_type->logo.'" alt="">
                </span>
            </div>';
        })
        ->editColumn('description', function($product_type) {
            return $product_type->shortDescription();
        })
        ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
        ->addColumn('action', function ($product_type) {
            $action = '<a href="'.route('products-type.sua', ['id' => $product_type->id]).'" class="btn btn-icon rounded-circle btn-outline-warning mr-1 mb-1 waves-effect waves-light"><i class="fa fa-edit"></i></a>';
            $action .= '<button type="button" data-role="remove" onclick="remove(\''.route('products.list', ['id' => $product_type->id]).'\')" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light"><i class="fa fa-trash"></i></button>';

            return $action;
        })
        ->make(true);
    }

    public function getThem() {
        return view("admin.pages.loai-san-pham.them");
    }

    public function postThem(Request $request) {
        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'logo'=>'required|image',
        ], [
            'name.required'=>'Vui lòng nhập tên loại sản phẩm',

            'description.required'=>'Vui lòng nhập mô tả cho loại sản phẩm',

            'logo.required'=>'Vui lòng chọn một ảnh cho loại sản phẩm',
            'logo.image'=>'Vui lòng sử dụng ảnh để upload',
        ]);
        
        if (!$request->hasFile('logo')) {
            return redirect()->back()->with('error', '1');
        }

        $file = $request->logo;

        $file_name = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();

        $file_name = Extension::generate_file_name($file_extension);

        $path = Storage::disk('storage')->putFileAs(
            'products-type',
            $file,
            $file_name
        );

        $type = new ProductType();

        $type->name = $request->name;
        $type->description = $request->description;
        $type->logo = $file_name;

        $type->save();

        return redirect()->back()->with('success', 'Đã thêm loại sản phẩm thành công');
    }

    public function getSua(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $type = ProductType::find($id);

        if($type == null) {
            return redirect()->back();
        }

        return view("admin.pages.loai-san-pham.sua", compact('type'));
    }

    public function postSua(Request $request) {
        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
        ], [
            'name.required'=>'Vui lòng nhập tên loại sản phẩm',

            'description.required'=>'Vui lòng nhập mô tả cho loại sản phẩm',
        ]);
        
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $type = ProductType::find($id);

        if($type == null) {
            return redirect()->back();
        }
        
        if ($request->hasFile('logo')) {
            $file = $request->logo;

            $file_name = $file->getClientOriginalName();
            $file_extension = $file->getClientOriginalExtension();

            $file_name = Extension::generate_file_name($file_extension);

            $path = Storage::disk('storage')->putFileAs(
                'products-type',
                $file,
                $file_name
            );
        }

        $type->name = $request->name;
        $type->description = $request->description;

        if(isset($file_name))
            $type->logo = $file_name;

        $type->save();

        return redirect()->back()->with('success', 'Đã sửa loại sản phẩm thành công');
    }

    public function getXoa(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $type = ProductType::find($request->id);

        if($type != null) {
            Storage::disk('storage')->delete("products-type/$type->logo");
            Storage::disk('storage')->deleteDirectory("products/$type->id/");
            $type->delete();
        }

        return redirect()->back()->with('success', 'Đã xoá loại sản phẩm thành công');
    }
}
