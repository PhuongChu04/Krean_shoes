<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Paginator::useBootstrap();

         View::composer('*', function ($view) {
             $cartCount = 0;
             if (Auth::check()) {
                 $cart = Auth::user()->cart;
                 if ($cart) {
                     // Show number of distinct cart items (rows) instead of total quantity
                     $cartCount = $cart->item_count;
                 }
             }
             $view->with('cartCount', $cartCount);
         });
    }
}
