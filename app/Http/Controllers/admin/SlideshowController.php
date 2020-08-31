<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config\Slideshow;
use App\Extension\Extension;
use Storage;

class SlideshowController extends Controller
{
    public function getIndex() {
        $slideshows = Slideshow::paginate(10);

        return view("admin.pages.slideshow.index", compact('slideshows'));
    }

    public function getJsonData(Request $request) {
        if($request->has('id')) {
            $slide = Slideshow::find($request->id);

            return response()->json($slide);
        }
        return response()->json(new class{});
    }

    public function postAction(Request $request) {
        $this->validate($request, [
            'action'=>'required',
            'id'=>'required',
            'url'=>'required',
            'index'=>'bail|required|min:0|max:10',
            'image'=>'bail|image'
        ], [
            'action.required'=>'Thiếu hành động',

            'id.required'=>'Thiếu id',

            'url.required'=>'Vui lòng nhập liên kết',

            'index.required'=>'Vui lòng chọn vị trí sắp xếp',
            'index.min'=>'Vị trí sắp xếp nhỏ nhất là 0',
            'index.max'=>'Vị trí sắp xếp lớn nhất là 10',

            'image.image'=>'Vui lòng sử dụng ảnh để upload',
        ]);

        if($request->hasFile("image")) {
            $file = $request->image;
    
            $file_name = $file->getClientOriginalName();
            $file_extension = $file->getClientOriginalExtension();
    
            $file_name = Extension::generate_file_name($file_extension);
    
            $path = Storage::disk('storage')->putFileAs(
                'slideshow',
                $file,
                $file_name
            );
        } elseif($request->action == 'add') {
            return redirect()->back()->with('error', 'Vui lòng chọn một ảnh');
        }

        if($request->action == 'add') {
            // add slideshow
            $slide = new Slideshow();
    
            $slide->image = $file_name;
            $slide->url = $request->url;
            $slide->index = $request->index;
            $slide->show = $request->show;
            $slide->timestamps = false;
    
            $slide->save();
            return redirect()->back()->with('success', 'Đã thêm slideshow thành công.');
        } else {
            // edit slideshow
            $slide = Slideshow::find($request->id);

            if($slide != null) {
                if(isset($file_name)) {
                    $slide->image = $file_name;
                }
                $slide->url = $request->url;
                $slide->index = $request->index;
                $slide->show = $request->show;
                $slide->timestamps = false;
    
                $slide->save();
                return redirect()->back()->with('success', 'Đã sửa slideshow thành công.');
            } else {
                return redirect()->back()->with('error', 'Thao tác không thể thực hiện.');
            }
        }
    }

    public function getXoa(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        Slideshow::destroy($request->id);

        return redirect()->back()->with('success', 'Đã xoá slideshow thành công');
    }
}
