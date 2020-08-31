<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProduct(Request $request) {
        $product = Product::find($request->has("id") ? $request->id : -1);

        if($product != null) {
            $prod = new class {};
            
            $prod->id = $product->id;
            $prod->name = $product->name;
            $prod->price = $product->price;
            $prod->description = $product->description;
            $prod->image = $product->getLinkImage().$product->product_image[0]->image;
            $prod->colors = json_decode($product->colors);
            $prod->sizes = json_decode($product->sizes);
            $prod->quantity = $product->quantity;
            $prod->link = route("chi.tiet.san.pham", [$product->id, $product->getLink()]);

            return response()->json($prod);
        }

        return response()->json(['status' => 'error']);
    }

    public function getChiTiet($id, $name) {

        $product = Product::find($id);

        if($product == null) {
            return redirect()->back();
        }

        $products_similar = Product::where([
            ["type_id", "=", $product->type_id],
            ["id", "!=", $id],
        ])->take(8)->get();

        $qrCode = QrCode::size(150)->generate(route("chi.tiet.san.pham", [$product->id, $product->getLink()]));

        return view("pages.chitiet", compact('product', 'products_similar', 'qrCode'));
    }

    public function getLoaiSanPham($id) {
        $products_type = ProductType::find($id);

        if($products_type == null) {
            return redirect()->back();
        }

        $count = $products = Product::where('type_id', $id)->count();

        if($count > 0) {
            $products = Product::where('type_id', $id)->paginate(9);
        } else {
            $products = [];
        }

        return view("pages.loaisanpham", compact('products_type', 'products', 'count'));
    }

    public function getTimKiem(Request $request)
    {
        if(!$request->has("find")) {
            return redirect()->back();
        }
        
        $list = Product::all();
        $result = [];

        $find = '/.*'.str_replace(' ', '.*', $request->find).'.*/mui';

        foreach ($list as $prod) {
            $s = $prod->id.$prod->name.$prod->product_type->name;
            if(preg_match($find, $s)) {
                $result[] = $prod;
            }
        }

        return view("pages.timkiem")->with(['find'=>$request->find, 'result'=>$result]);
    }
}