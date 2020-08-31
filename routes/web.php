<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'index',
    'uses' => 'MasterController@getTrangChu'
]);

Route::get('dang-ky', [
    'as' => 'register',
    'uses' => 'UserController@getDangKy'
]);

Route::post('dang-ky', [
    'as' => 'register',
    'uses' => 'UserController@postDangKy'
]);

Route::get('dang-nhap', [
    'as' => 'login',
    'uses' => 'UserController@getDangNhap'
]);

Route::post('dang-nhap', [
    'as' => 'login',
    'uses' => 'UserController@postDangNhap'
]);

Route::get('dang-xuat', [
    'as' => 'logout',
    'uses' => 'UserController@getLogout'
]);

Route::get('get-captcha', [
    'as' => 'getcaptcha',
    'uses' => 'MasterController@getCaptcha'
]);

Route::get('san-pham/{id}-{name}', [
    'as' => 'chi.tiet.san.pham',
    'uses' => 'ProductController@getChiTiet'
]);

Route::get('loai-san-pham/{id}', [
    'as' => 'loai.san.pham',
    'uses' => 'ProductController@getLoaiSanPham'
]);

Route::get('san-pham/get', [
    'as' => 'get.san.pham',
    'uses' => 'ProductController@getProduct'
]);

// dat hang
Route::get('dat-hang', [
    'as' => 'checkout',
    'uses' => 'CartController@getCheckout'
]);
Route::post('dat-hang', [
    'as' => 'checkout',
    'uses' => 'CartController@postCheckout'
]);

Route::get('dat-hang-thanh-cong', [
    'as' => 'checkout.success',
    'uses' => 'CartController@getCheckoutSuccess'
]);

// tim kiem

Route::get('tim-kiem', [
    'as' => 'search',
    'uses' => 'ProductController@getTimKiem'
]);

// group cart
Route::group(['prefix' => 'gio-hang'], function () {
    
    Route::get('/', [
        'as' => 'cart.list',
        'uses' => 'CartController@getList'
    ]);
    
    Route::get('get', [
        'as' => 'cart.get',
        'uses' => 'CartController@getCart'
    ]);
    
    Route::post('add', [
        'as' => 'cart.add',
        'uses' => 'CartController@addToCart'
    ]);
    
    Route::get('change', [
        'as' => 'cart.change',
        'uses' => 'CartController@changeQuantity'
    ]);
    
    Route::get('remove', [
        'as' => 'cart.remove',
        'uses' => 'CartController@removeInCart'
    ]);
});

// group administrator
Route::group(['prefix' => 'admin'], function () {
    
    Route::get('dang-nhap', [
        'as' => 'admin.login',
        'uses' => 'admin\LoginController@getLogin'
    ]);

    Route::post('dang-nhap', [
        'as' => 'admin.login',
        'uses' => 'admin\LoginController@postLogin'
    ]);

    Route::get('dang-xuat', [
        'as' => 'admin.logout',
        'uses' => 'admin\LoginController@getLogout'
    ]);

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', [
            'as' => 'admin.index',
            'uses' => 'admin\MasterController@getIndex'
        ]);

        // quan ly nguoi dung
        Route::group(['prefix' => 'nguoi-dung'], function () {

            Route::get('/', [
                'as' => 'users.index',
                'uses' => 'admin\UserController@getIndex'
            ]);

            Route::get('data', [
                'as' => 'users.data',
                'uses' => 'admin\UserController@anyData'
            ]);

            Route::get('them', [
                'as' => 'users.them',
                'uses' => 'admin\UserController@getThem'
            ]);

            Route::post('them', [
                'as' => 'users.them',
                'uses' => 'admin\UserController@postThem'
            ]);

            Route::get('sua', [
                'as' => 'users.sua',
                'uses' => 'admin\UserController@getSua'
            ]);

            Route::post('sua', [
                'as' => 'users.sua',
                'uses' => 'admin\UserController@postSua'
            ]);

            Route::get('xoa', [
                'as' => 'users.xoa',
                'uses' => 'admin\UserController@getXoa'
            ]);

            Route::get('login', [
                'as' => 'users.login',
                'uses' => 'admin\UserController@getLogin'
            ]);

        });

        // quan ly loai san pham
        Route::group(['prefix' => 'loai-san-pham'], function () {

            Route::get('/', [
                'as' => 'products-type.index',
                'uses' => 'admin\ProductTypeController@getIndex'
            ]);

            Route::get('data', [
                'as' => 'products-type.data',
                'uses' => 'admin\ProductTypeController@anyData'
            ]);

            Route::get('them', [
                'as' => 'products-type.them',
                'uses' => 'admin\ProductTypeController@getThem'
            ]);

            Route::post('them', [
                'as' => 'products-type.them',
                'uses' => 'admin\ProductTypeController@postThem'
            ]);

            Route::get('sua', [
                'as' => 'products-type.sua',
                'uses' => 'admin\ProductTypeController@getSua'
            ]);

            Route::post('sua', [
                'as' => 'products-type.sua',
                'uses' => 'admin\ProductTypeController@postSua'
            ]);

            Route::get('xoa', [
                'as' => 'products-type.xoa',
                'uses' => 'admin\ProductTypeController@getXoa'
            ]);

        });

        // quan ly san pham
        Route::group(['prefix' => 'san-pham'], function () {

            Route::get('/', [
                'as' => 'products.index',
                'uses' => 'admin\ProductController@getIndex'
            ]);

            Route::get('/danh-sach/{id?}', [
                'as' => 'products.list',
                'uses' => 'admin\ProductController@getIndex'
            ]);

            Route::get('data', [
                'as' => 'products.data',
                'uses' => 'admin\ProductController@anyData'
            ]);

            Route::get('view', [
                'as' => 'products.view',
                'uses' => 'admin\ProductController@viewData'
            ]);

            Route::get('them', [
                'as' => 'products.them',
                'uses' => 'admin\ProductController@getThem'
            ]);

            Route::post('them', [
                'as' => 'products.them',
                'uses' => 'admin\ProductController@postThem'
            ]);

            Route::get('sua', [
                'as' => 'products.sua',
                'uses' => 'admin\ProductController@getSua'
            ]);

            Route::post('sua', [
                'as' => 'products.sua',
                'uses' => 'admin\ProductController@postSua'
            ]);

            Route::get('xoa', [
                'as' => 'products.xoa',
                'uses' => 'admin\ProductController@getXoa'
            ]);

        });

        // quan ly don hang
        Route::group(['prefix' => 'don-hang'], function () {

            Route::get('/', [
                'as' => 'bill.index',
                'uses' => 'admin\BillController@getIndex'
            ]);

            Route::get('new', [
                'as' => 'bill.new',
                'uses' => 'admin\BillController@getNew'
            ]);

            Route::get('data/{new?}', [
                'as' => 'bill.data',
                'uses' => 'admin\BillController@anyData'
            ]);

            Route::get('them', [
                'as' => 'bill.them',
                'uses' => 'admin\BillController@getThem'
            ]);

            Route::post('them', [
                'as' => 'bill.them',
                'uses' => 'admin\BillController@postThem'
            ]);

            Route::get('sua', [
                'as' => 'bill.sua',
                'uses' => 'admin\BillController@getSua'
            ]);

            Route::post('sua', [
                'as' => 'bill.sua',
                'uses' => 'admin\BillController@postSua'
            ]);

            Route::get('xoa', [
                'as' => 'bill.xoa',
                'uses' => 'admin\BillController@getXoa'
            ]);

            Route::get('xoa-detail', [
                'as' => 'bill.xoa-detail',
                'uses' => 'admin\BillController@getXoaDetail'
            ]);

            Route::post('them-detail', [
                'as' => 'bill.them-detail',
                'uses' => 'admin\BillController@postThemDetail'
            ]);

            Route::get('find-customer', [
                'as' => 'bill.find-customer',
                'uses' => 'admin\BillController@findCustomer'
            ]);

            Route::get('customer', [
                'as' => 'bill.customer',
                'uses' => 'admin\BillController@getCustomer'
            ]);

            Route::get('find-product', [
                'as' => 'bill.find-product',
                'uses' => 'admin\BillController@findProduct'
            ]);

            Route::get('product', [
                'as' => 'bill.product',
                'uses' => 'admin\BillController@getProduct'
            ]);

        });

        // cau hinh slideshow
        Route::group(['prefix' => 'slideshow'], function () {

            Route::get('/', [
                'as' => 'slideshow.index',
                'uses' => 'admin\SlideshowController@getIndex'
            ]);

            Route::get('get-json-data', [
                'as' => 'slideshow.getjson',
                'uses' => 'admin\SlideshowController@getJsonData'
            ]);

            Route::post('action', [
                'as' => 'slideshow.action',
                'uses' => 'admin\SlideshowController@postAction'
            ]);

            Route::get('xoa', [
                'as' => 'slideshow.xoa',
                'uses' => 'admin\SlideshowController@getXoa'
            ]);

        });

        // cau hinh brand
        Route::group(['prefix' => 'brand'], function () {

            Route::get('/', [
                'as' => 'brand.index',
                'uses' => 'admin\BrandController@getIndex'
            ]);

            Route::get('get-json-data', [
                'as' => 'brand.getjson',
                'uses' => 'admin\BrandController@getJsonData'
            ]);

            Route::post('action', [
                'as' => 'brand.action',
                'uses' => 'admin\BrandController@postAction'
            ]);

            Route::get('xoa', [
                'as' => 'brand.xoa',
                'uses' => 'admin\BrandController@getXoa'
            ]);

        });

    });

});

// get global data

Route::group(['prefix' => 'data'], function () {
    Route::get('thanh-pho', 'admin\MasterController@getThanhPho')->name('data.get-thanh-pho');

    Route::get('quan-huyen', 'admin\MasterController@getQuanHuyen')->name('data.get-quan-huyen');

    Route::get('xa-phuong', 'admin\MasterController@getXaPhuong')->name('data.get-xa-phuong');
});

// crawler

Route::post('crawler/import', [
    'as' => 'crawler.import',
    'uses' => 'admin\ProductController@crawlerImport'
]);