<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Bill;
use App\Models\Product;
use App\Models\ProductType;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.blocks.statistic', function ($view) {
            $bills = Bill::count();
            $new_bills = Bill::newCount();
            $users = User::count();
            $products = Product::count();

            $view->with(compact('bills', 'new_bills', 'users', 'products'));
        });

        view()->composer('admin.blocks.main_menu', function ($view) {
            $new_bills = Bill::newCount();

            $view->with(compact('new_bills'));
        });

        view()->composer(['blocks.navmenu', 'blocks.category'], function ($view) {
            $types = ProductType::select(['id', 'name'])->get();

            $view->with(compact('types'));
        });
    }
}
