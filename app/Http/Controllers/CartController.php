<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Customer;
use Session;
use DB;
use Auth;

class CartController extends Controller
{
    public function getList() {
        return view("pages.giohang");
    }

    public function getCheckout() {
        $total = 0;
        $cart = [];
        if(Session::has("cart")) {
            $cart = Session::get("cart");
            foreach ($cart as $value) {
                $total += $value->price;
            }
        }
        $list_thanh_pho = DB::table('data_thanh_pho')->orderBy('name', 'asc')->get();

        $customer = [
            'full_name' => '',
            'email' => '',
            'phone_number' => '',
            'address' => ''
        ];

        if(Auth::check()) {
            $user = Auth::user();
            $customer['full_name'] = $user->full_name;
            $customer['email'] = $user->email;
            $customer['phone_number'] = $user->phone_number;
            $customer['address'] = $user->address;
        }

        return view("pages.dathang", compact('list_thanh_pho', 'cart', 'total', 'customer'));
    }

    public function postCheckout(Request $request) {
        $this->validate($request, [
            'full_name'=>'required',
            'gender'=>'bail|required|in:1,2',
            'email'=>'bail|required|email',
            'phone_number'=>'bail|required|regex:/^(0)[0-9]{9}$/',
            'address'=>'required',
            'payment'=>'bail|required|in:COD,ATM',
            'thanh_pho'=>'required|exists:data_thanh_pho,matp',
            'quan_huyen'=>'required|exists:data_quan_huyen,maqh',
            'xa_phuong'=>'required|exists:data_xa_phuong,xaid',
        ], [
            'gender.in'=>'Giới tính không phù hợp',

            'email.email'=>'Email không hợp lệ',

            'phone_number.regex'=>'Số điện thoại không hợp lệ',

            'thanh_pho.exists'=>'Tỉnh/Thành phố không được phép sử dụng',

            'quan_huyen.exists'=>'Quận/Huyện không được phép sử dụng',

            'xa_phuong.exists'=>'Xã/Phường không được phép sử dụng',
        ]);

        // get address in db
        $tp = DB::table('data_thanh_pho')->where('matp', $request->thanh_pho)->first();
        $qh = DB::table('data_quan_huyen')->where('maqh', $request->quan_huyen)->first();
        $xp = DB::table('data_xa_phuong')->where('xaid', $request->xa_phuong)->first();

        $cart = [];
        if(Session::has("cart")) {
            $cart = Session::get("cart");
        }

        if(count($cart) <= 0) {
            return redirect()->route('index');
        }

        // insert customer
        $customer = new Customer();
        
        $customer->full_name = $request->full_name;
        $customer->gender = $request->gender == 1 ? 'Nam' : 'Nữ';
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address.', '.$xp->name.', '.$qh->name.', '.$tp->name;

        $customer->save();

        // insert bill
        $bill = new Bill();

        $bill->customer_id = $customer->id;
        $bill->payment = $request->payment;
        $bill->note = $request->note;
        $bill->status = 0;

        $bill->save();

        // insert products into bill
        foreach ($cart as $id => $product) {
            $bill_detail = new BillDetail();

            $bill_detail->bill_id = $bill->id;
            $bill_detail->product_id = $id;
            $bill_detail->quantity = $product->quantity;
            $bill_detail->price = $product->price;

            $bill_detail->color = json_encode($product->color);
            $bill_detail->size = $product->size;

            $bill_detail->save();
        }

        Session::forget("cart");

        return redirect()->route('checkout.success')->with('bill_id', $bill->id);
    }

    public function getCheckoutSuccess() {
        if(Session::has('bill_id')) {
            $bill = Bill::find(Session::get('bill_id'));
            if($bill != null) {
                return view("pages.dathang-thanhcong", compact('bill'));
            }
        }
        return redirect()->route('index');
    }

    public function getCart() {
        $total = 0;
        $count = 0;
        $cart = [];
        if(Session::has("cart")) {
            $cart = Session::get("cart");

            foreach ($cart as $id => $item) {
                $product = Product::find($id);

                $item->name = $product->name;
                $item->price = $product->price * $item->quantity;
                $item->image = $product->getLinkImage().$product->product_image[0]->image;
                $item->link = route("chi.tiet.san.pham", [$product->id, $product->getLink()]);

                $total += $item->price * $item->quantity;
                $count += $item->quantity;
            }
        }

        return response()->json([
            'cart' => $cart,
            'total' => $total,
            'count' => $count
        ]);
    }

    public function addToCart(Request $request) {
        $cart = [];
        if(Session::has("cart")) {
            $cart = Session::get("cart");
        }

        $quantity = 1;
        if($request->has('quantity')) {
            $quantity = $request->quantity;
        }

        $product = Product::find($request->has("id") ? $request->id : -1);

        if($product != null) {
            if(isset($cart[$request->id])) {
                $cur_cart = $cart[$request->id];
                $cur_cart->quantity += $quantity;
            } else {
                $new_cart = new Cart();
    
                $new_cart->quantity = $quantity;

                $arr_color = json_decode($product->colors);
                $arr_size = json_decode($product->sizes);

                $new_cart->color = $arr_color[0];

                if($request->has('color')) {
                    foreach ($arr_color as $color) {
                        if($color->value == $request->color) {
                            $new_cart->color = $color;
                            break;
                        }
                    }
                }

                $new_cart->size = $arr_size[0];

                if($request->has('size') && in_array($request->size, $arr_size)) {
                    $new_cart->size = $request->size;
                }
    
                $cart[$product->id] = $new_cart;
            }

            Session::put(['cart' => $cart]);
        } else {
            return response()->json(['status'=>'error']);
        }

        return $this->getCart();
    }

    public function changeQuantity(Request $request) {
        $cart = [];
        if(Session::has("cart")) {
            $cart = Session::get("cart");
        }

        if(isset($cart[$request->id])) {
            $cur_cart = $cart[$request->id];
            if($request->quantity == 0) {
                unset($cart[$request->id]);
            } else {
                $cur_cart->quantity = $request->quantity;
            }
            Session::put(['cart' => $cart]);
        } else {
            return response()->json(['status'=>'error']);
        }

        return $this->getCart();
    }

    public function removeInCart(Request $request) {
        $cart = [];
        if(Session::has("cart")) {
            $cart = Session::get("cart");
        }

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            Session::put(['cart' => $cart]);
        } else {
            return response()->json(['status'=>'error']);
        }

        return $this->getCart();
    }
}