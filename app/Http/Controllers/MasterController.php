<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extension\Captcha;
use App\Models\Product;
use App\Models\Config\Slideshow;
use App\Models\Config\Brand;

class MasterController extends Controller
{
    public function getTrangChu() {
        $products = Product::all()->take(8);
        $new_products = Product::orderBy('id', 'desc')->get()->take(8);
        $slideshows = Slideshow::where('show', '1')->orderBy('index', 'desc')->get();
        $brands = Brand::where('show', '1')->get();

        return view("pages.trangchu", compact('products', 'new_products', 'slideshows', 'brands'));
    }

    public function getCaptcha() {
        Captcha::getCaptcha();
    }
}