<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Extension\Extension;
use App\Extension\SimpleImage;
use Storage;

class ProductController extends Controller
{
    public function getIndex($id = -1) {
        $types = ProductType::all();
        return view("admin.pages.san-pham.index", compact('id', 'types'));
    }
    
    public function anyData(Request $request)
    {
        if($request->has("id") && $request->id != -1) {
            $products = Product::where("type_id", $request->id)->get();
        } else {
            $products = Product::all();
        }

        return Datatables::of($products)
        ->editColumn('quantity', '{{ number_format($quantity) }}')
        ->editColumn('price', '{{ number_format($price) }}đ')
        ->editColumn('created_at', function($product) {
            return $product->created_at->format("d/m/Y");
        })
        ->addColumn('type', function ($product) {
            return $product->product_type->name;
        })
        ->addColumn('action', function ($product) {
            $action = '<button onclick="viewProduct('.$product->id.')" class="btn btn-icon rounded-circle btn-outline-info mr-1 mb-1 waves-effect waves-light"><i class="fa fa-eye"></i></button>';
            $action .= '<a href="'.route('products.sua', ['id' => $product->id]).'" class="btn btn-icon rounded-circle btn-outline-warning mr-1 mb-1 waves-effect waves-light"><i class="fa fa-edit"></i></a>';
            $action .= '<button type="button" data-role="remove" onclick="remove(\''.route('products.xoa', ['id' => $product->id]).'\')" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light"><i class="fa fa-trash"></i></button>';

            return $action;
        })
        ->addColumn('image', function ($product) {
            $img = '';
            foreach ($product->product_image as $value) {
                $img .= '<span class="avatar avatar-sm rounded-circle">
                    <img src="'.$product->getLinkImage().$value->image.'" alt="...">
                </span>';
            }
            return "<div class=\"avatar-group\">$img</div>";
        })
        ->make(true);
    }
    
    public function viewData(Request $request)
    {
        if($request->has("id")) {
            $id = $request->id;

            $product = Product::find($id);

            if($product != null) {
                return view("admin.pages.san-pham.view", compact('product'));
            }
        }
        return 'Không thể lấy dữ liệu';
    }

    public function getThem() {
        $types = ProductType::select(['id', 'name'])->get();
        return view("admin.pages.san-pham.them", compact('types'));
    }

    public function postThem(Request $request) {
        // dd($request->all());
        $this->validate($request, [
            'name'=>'required',
            'type_id'=>'required',
            'description'=>'required',
            'quantity'=>'required|numeric',
            'price'=>'required|numeric',
            'image.*'=>'required|image',
        ], [
            'name.required'=>'Vui lòng nhập tên sản phẩm',

            'type_id.required'=>'Vui lòng chọn loại sản phẩm',

            'description.required'=>'Vui lòng nhập mô tả cho sản phẩm',

            'quantity.required'=>'Vui lòng nhập số lượng',
            'quantity.numeric'=>'Số lượng nhập không hợp lệ',

            'price.required'=>'Vui lòng nhập giá',
            'price.numeric'=>'Giá nhập không hợp lệ',

            'image.*.required'=>'Vui lòng chọn ít nhất một ảnh cho sản phẩm',
            'image.*.image'=>'Vui lòng sử dụng ảnh để tải lên',
        ]);
        
        if (!$request->hasFile('image')) {
            return redirect()->back();
        }

        $color = '[]';

        if($request->checkColor && $request->has("color") && $request->has("color_name")) {
            // có sử dụng màu sắc
            $result = [];
            foreach ($request->color as $key => $color) {
                $result[] = [
                    'name' => $request->color_name[$key],
                    'value' => $color,
                ];
            }
            $color = json_encode($result);
        }

        $size = '[]';

        if($request->checkSize && $request->has("size")) {
            // có sử dụng kích cỡ
            $size = json_encode($request->size);
        }
        
        $product = new Product();

        $product->name = $request->name;
        $product->type_id = $request->type_id;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->colors = $color;
        $product->sizes = $size;

        $product->save();

        $files = $request->image;

        foreach ($files as $file) {
            $file_name = $file->getClientOriginalName();
            $file_extension = $file->getClientOriginalExtension();
    
            $file_name = Extension::generate_file_name($file_extension);
    
            $path = Storage::disk('storage')->putFileAs(
                $product->getSortLinkImage(),
                $file,
                $file_name
            );

            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->image = $file_name;
            $image->timestamps = false;
            $image->save();
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm thành công');
    }

    public function getSua(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $product = Product::find($id);

        if($product == null) {
            return redirect()->back();
        }
        
        $types = ProductType::select(['id', 'name'])->get();

        $colors = json_decode($product->colors);
        $sizes = json_decode($product->sizes);

        return view("admin.pages.san-pham.sua", compact('product', 'types', 'colors', 'sizes'));
    }

    public function postSua(Request $request) {
        $this->validate($request, [
            'name'=>'required',
            'type_id'=>'required',
            'description'=>'required',
            'quantity'=>'required|numeric',
            'price'=>'required|numeric'
        ], [
            'name.required'=>'Vui lòng nhập tên sản phẩm',

            'type_id.required'=>'Vui lòng chọn loại sản phẩm',

            'description.required'=>'Vui lòng nhập mô tả cho sản phẩm',

            'quantity.required'=>'Vui lòng nhập số lượng',
            'quantity.numeric'=>'Số lượng nhập không hợp lệ',

            'price.required'=>'Vui lòng nhập giá',
            'price.numeric'=>'Giá nhập không hợp lệ'
        ]);

        $color = '[]';

        if($request->checkColor && $request->has("color") && $request->has("color_name")) {
            // có sử dụng màu sắc
            $result = [];
            foreach ($request->color as $key => $color) {
                $result[] = [
                    'name' => $request->color_name[$key],
                    'value' => $color,
                ];
            }
            $color = json_encode($result);
        }

        $size = '[]';

        if($request->checkSize && $request->has("size")) {
            // có sử dụng màu sắc
            $size = json_encode($request->size);
        }
        
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $product = Product::find($id);

        if($product == null) {
            return redirect()->back();
        }

        // remove image
        if($request->has("remove")) {
            foreach ($request->remove as $value) {
                $image = ProductImage::find($value);

                $image->delete();
            }
        }

        // insert image
        if($request->hasFile("image")) {
            $files = $request->image;

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
        
                $file_name = Extension::generate_file_name($file_extension);
        
                $path = Storage::disk('storage')->putFileAs(
                    $product->getSortLinkImage(),
                    $file,
                    $file_name
                );

                $image = new ProductImage();
                $image->product_id = $product->id;
                $image->image = $file_name;
                $image->timestamps = false;
                $image->save();
            }
        }

        $product->name = $request->name;
        $product->type_id = $request->type_id;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->colors = $color;
        $product->sizes = $size;

        $product->save();

        return redirect()->back()->with('success', 'Đã sửa sản phẩm thành công');
    }

    public function getXoa(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $product = Product::find($request->id);

        if($product != null) {
            Storage::disk('storage')->deleteDirectory($product->getSortLinkImage());
            $product->delete();
        }
        return redirect()->back()->with('success', 'Đã xoá sản phẩm thành công');
    }

    public $colorz = [
        [ 'name' => 'Đỏ', 'value' => '#ff0000' ],
        [ 'name' => 'Hồng phấn', 'value' => '#eaadad' ],
        [ 'name' => 'Đen', 'value' => '#000000' ],
        [ 'name' => 'Hồng', 'value' => '#e9a8ea' ],
        [ 'name' => 'Tím', 'value' => '#a844ff' ],
        [ 'name' => 'Xanh ngọc', 'value' => '#83c3ea' ],
        [ 'name' => 'Nâu vàng', 'value' => '#afaa6e' ],
        [ 'name' => 'Nâu', 'value' => '#565335' ],
        [ 'name' => 'Trắng', 'value' => '#ffffff' ],
        [ 'name' => 'Cam nhạt', 'value' => '#f4cba8' ],
        [ 'name' => 'Xanh mạ', 'value' => '#b3dbb6' ]
    ];
    
    public function createSizes() {
        $arr = [];
        for($i = 35; $i <= 42; $i += 0.5) {
            $arr[] = $i;
        }
        return $arr;
    }

    public function randColors() {
        $l = rand(2, count($this->colorz));
        $index = array_rand($this->colorz, $l);

        $arr = [];
        for($i = 0; $i < $l; $i++) {
            $arr[] = $this->colorz[$index[$i]];
        }
        return $arr;
    }

    public function randSizes() {
        $sizez = $this->createSizes();
        $l = rand(7, count($sizez));
        $index = array_rand($sizez, $l);

        $arr = [];
        for($i = 0; $i < $l; $i++) {
            $arr[] = $sizez[$index[$i]];
        }
        return $arr;
    }

    public function crawlerImport(Request $request) {
        
        $product = new Product();

        $product->name = trim(str_replace("Nữ", "", $request->name));
        $product->type_id = $request->type_id;
        $product->description = trim($request->description);
        $product->quantity = rand(10, 100);
        $product->price = trim($request->price);
        $product->colors = json_encode($this->randColors());
        $product->sizes = json_encode($this->randSizes());

        $product->save();

        $imgs = $request->imgs;

        foreach ($imgs as $value) {
            $contents = file_get_contents($value);
            $file_name = Extension::generate_file_name("jpg");

            $file = $product->getLinkImage().$file_name;
    
            if(!is_dir($product->getLinkImage())) {
                Storage::disk('storage')->makeDirectory($product->getSortLinkImage());
            }
            file_put_contents($file, $contents);

            $simple_image = new SimpleImage();
            $simple_image->load($file);
            $simple_image->resizeToWidth(400);
            $simple_image->save($file);
            
            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->image = $file_name;
            $image->timestamps = false;
            $image->save();
        }

        return response()->json(['success' => true]);
    }
}