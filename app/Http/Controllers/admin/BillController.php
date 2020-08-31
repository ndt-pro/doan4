<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillDetail;
use DB;

class BillController extends Controller
{
    public function getIndex() {
        return view("admin.pages.bill.index");
    }
    
    public function anyData(Request $request, $new = 0)
    {
        if($new) {
            $bills = Bill::where('status', '0')->get();
        } else {
            $bills = Bill::all();
        }

        return Datatables::of($bills)
        ->editColumn('id', function($bill) {
            return "#$bill->id";
        })
        ->editColumn('created_at', function($bill) {
            return $bill->created_at->format("d/m/Y H:i:s");
        })
        ->editColumn('status', function($bill) {
            return $bill->getValueStatus(true);
        })
        ->addColumn('full_name', function ($bill) {
            return $bill->customer->full_name;
        })
        ->addColumn('email', function ($bill) {
            return $bill->customer->email;
        })
        ->addColumn('c_product', function ($bill) {
            $count = 0;

            foreach ($bill->bill_detail as $value) {
                $count += $value->quantity;
            }

            return $count;
        })
        ->addColumn('total_price', function ($bill) {
            $total = 0;

            foreach ($bill->bill_detail as $value) {
                $total += $value->quantity * $value->price;
            }

            return number_format($total).'đ';
        })
        ->addColumn('action', function ($bill) {
            $action = '<a href="'.route('bill.sua', ['id' => $bill->id]).'" class="btn btn-icon rounded-circle btn-outline-primary mr-1 mb-1 waves-effect waves-light"><i class="fa fa-edit"></i></a>';
            $action .= '<button type="button" data-role="remove" onclick="remove(\''.route('bill.xoa', ['id' => $bill->id]).'\')" class="btn btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light"><i class="fa fa-trash"></i></button>';
            return $action;
        })
        ->make(true);
    }

    public function getNew() {
        return view("admin.pages.bill.new");
    }

    public function getThem() {
        $list_thanh_pho = DB::table('data_thanh_pho')->orderBy('name', 'asc')->get();
        return view("admin.pages.bill.them", compact('list_thanh_pho'));
    }

    public function postThem(Request $request) {
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
            'prod_id.*'=>'required|exists:products,id',
            'prod_price.*'=>'required|numeric|min:1',
            'prod_quantity.*'=>'required|numeric|min:1|max:99',
        ], [
            'gender.in'=>'Giới tính không phù hợp',

            'email.email'=>'Email không hợp lệ',

            'phone_number.regex'=>'Số điện thoại không hợp lệ',

            'thanh_pho.exists'=>'Tỉnh/Thành phố không được phép sử dụng',

            'quan_huyen.exists'=>'Quận/Huyện không được phép sử dụng',

            'xa_phuong.exists'=>'Xã/Phường không được phép sử dụng',

            'prod_id.*.exists'=>'Sản phẩm không tồn tại',
        ]);

        // get address in db
        $tp = DB::table('data_thanh_pho')->where('matp', $request->thanh_pho)->first();
        $qh = DB::table('data_quan_huyen')->where('maqh', $request->quan_huyen)->first();
        $xp = DB::table('data_xa_phuong')->where('xaid', $request->xa_phuong)->first();

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
        foreach ($request->prod_id as $key => $id) {
            $product = Product::find($id);

            if($product != null) {
                $bill_detail = new BillDetail();

                if($request->prod_quantity[$key] > $product->quantity) {
                    $request->prod_quantity[$key] = $product->quantity;
                }
    
                $bill_detail->bill_id = $bill->id;
                $bill_detail->product_id = $id;
                $bill_detail->quantity = $request->prod_quantity[$key];
                $bill_detail->price = $request->prod_price[$key];

                $arr_colors = json_decode($product->colors);

                $scolor = [];
                foreach ($arr_colors as $color) {
                    if($color->value == $request->prod_color[$key]) {
                        $scolor = $color;
                        break;
                    }
                }
    
                $bill_detail->color = json_encode($scolor);
                $bill_detail->size = $request->prod_size[$key];
    
                $bill_detail->save();
            }
        }

        return redirect()->back()->with('success', 'Đã thêm đơn hàng thành công');
    }

    public function findCustomer(Request $request) {
        $list = User::all();
        $result = [];

        $find = '/.*'.str_replace(' ', '.*', $request->find).'.*/mui';

        foreach ($list as $cus) {
            $s = $cus->id.$cus->full_name.$cus->email.$cus->phone_number;
            if(preg_match($find, $s)) {
                $result[] = $cus;
            }
        }
        return response()->json([
            'total' => count($result),
            'result' => $result,
        ]);
    }

    public function findProduct(Request $request) {
        $list = Product::all();
        $result = [];

        $find = '/.*'.str_replace(' ', '.*', $request->find).'.*/mui';

        foreach ($list as $prod) {
            $s = $prod->id.$prod->name.$prod->product_type->name;
            if(preg_match($find, $s)) {
                $result[] = [
                    'id' => $prod->id,
                    'name' => $prod->name,
                    'image' => $prod->getLinkImage().$prod->product_image[0]->image,
                    'price' => number_format($prod->price).'đ',
                ];
                if(count($result) > 20)
                    break;
            }
        }
        return response()->json($result);
    }

    public function getProduct(Request $request) {
        if($request->has('id')) {
            $prod = Product::select(['id', 'name', 'price', 'colors', 'sizes', 'quantity'])->where('id', $request->id)->first();
            return response()->json($prod);
        }
    }

    public function getSua(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }
        $id = $request->id;

        $bill = Bill::find($id);

        if($bill == null) {
            return redirect()->back();
        }

        return view("admin.pages.bill.sua", compact('bill'));
    }

    public function postSua(Request $request) {
        // var_dump($request->all());
        $result = ['status'=>'success'];

        if($request->pk['db'] == 'customer' || $request->pk['db'] == 'bills' || $request->pk['db'] == 'bill_detail') {
            $bill = Bill::find($request->bill_id);

            if($bill->status > 0 && ($request->name != 'status' || $request->name == 'status' && $request->value <= $bill->status)) {
                return response()->json(['status'=>'error', 'text'=>'Không thể sửa đổi khi đã duyệt đơn hàng!']);
            }

            if($request->name == 'gender') {
                if($request->value == 1)
                    $request->value = 'Nam';
                else
                    $request->value = 'Nữ';
            }

            if($request->name == 'payment') {
                if($request->value == 1)
                    $request->value = 'COD';
                else
                    $request->value = 'ATM';
            }

            if($request->name == 'color') {
                $product = BillDetail::find($request->pk['id'])->product;
                $scolor = [];
                foreach (json_decode($product->colors) as $color) {
                    if($color->value == $request->value) {
                        $scolor = $color;
                        break;
                    }
                }
                $request->value = json_encode($scolor);
            }

            if($request->name == 'quantity') {
                // check quantity
                $product = BillDetail::find($request->pk['id'])->product;

                if($request->value > $product->quantity) {
                    return response()->json(['status'=>'error', 'text'=>"Số lượng sản phẩm này không được vượt quá $product->quantity."]);
                }
            }

            if($bill->status == 0 && $request->name == 'status' && $request->value > 0) {

                // check quantity in warehouse
                foreach ($bill->bill_detail as $detail) {
                    $product = $detail->product;
                    if($product->quantity < $detail->quantity) {
                        return response()->json(['status'=>'error', 'text'=>"Số lượng của sản phẩm $product->name vượt quá trong kho."]);
                    }
                }

                // reduce quantity
                foreach ($bill->bill_detail as $detail) {
                    $product = $detail->product;
                    if($product->quantity >= $detail->quantity) {
                        $product->quantity -= $detail->quantity;
                        $product->save();
                    }
                }
            }

            DB::table($request->pk['db'])->where('id', $request->pk['id'])->update([$request->name => $request->value]);

            if($request->name == 'price' || $request->name == 'quantity') {
                $total = 0;
                $total_bill = 0;

                $detail = BillDetail::find($request->pk['id']);

                $total = $detail->quantity * $detail->price;

                foreach ($detail->bill->bill_detail as $item) {
                    $total_bill += $item->quantity * $item->price;
                }

                $result['id'] = $request->pk['id'];
                $result['total'] = number_format($total);
                $result['total_bill'] = number_format($total_bill);
            }
        }
        return response()->json($result);
    }

    public function getXoa(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }

        $bill = Bill::find($request->id);

        if($bill != null) {
            $bill->delete();
        }
        return redirect()->back()->with('success', 'Đã xoá đơn hàng thành công');
    }

    public function getXoaDetail(Request $request) {
        if(!$request->has('id')) {
            return redirect()->back();
        }

        $detail = BillDetail::find($request->id);

        if($detail != null) {
            if($detail->bill->status == 0 && count($detail->bill->bill_detail) > 1) {
                $detail->delete();
                return redirect()->back()->with('success', 'Đã xoá sản phẩm thành công');
            }
        }
        return redirect()->back()->with('error', 'Xóa sản phẩm không thành công');
    }

    public function postThemDetail(Request $request) {
        // dd($request->all());

        $bill = Bill::find($request->bill_id);
        if($bill->status > 0) {
            return redirect()->back();
        }

        // insert products into bill
        foreach ($request->prod_id as $key => $id) {
            $product = Product::find($id);

            if($product != null) {
                if($request->prod_quantity[$key] > $product->quantity) {
                    $request->prod_quantity[$key] = $product->quantity;
                }
                $bill_detail = new BillDetail();
    
                $bill_detail->bill_id = $request->bill_id;
                $bill_detail->product_id = $id;
                $bill_detail->quantity = $request->prod_quantity[$key];
                $bill_detail->price = $request->prod_price[$key];

                $arr_colors = json_decode($product->colors);

                $scolor = [];
                foreach ($arr_colors as $color) {
                    if($color->value == $request->prod_color[$key]) {
                        $scolor = $color;
                        break;
                    }
                }
    
                $bill_detail->color = json_encode($scolor);
                $bill_detail->size = $request->prod_size[$key];
    
                $bill_detail->save();
            }
        }
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào đơn hàng');
    }
}
