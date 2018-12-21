<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TradeMark;
use App\Category;
use Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		URL::forceScheme('https');
        //
        view()->composer('header',function($view){
            $trademark = TradeMark::all();
            $category = Category::all();
            $total_item = Cart::count();
            $total_price = Cart::subtotal(0,',','.');
            $view->with('total_item', $total_item);
            $view->with('total_price', $total_price);
            $view->with('trademark', $trademark);
            $view->with('category', $category);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
