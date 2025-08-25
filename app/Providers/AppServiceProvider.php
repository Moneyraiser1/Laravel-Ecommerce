<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{

public function boot(): void
{
    View::composer('*', function ($view) {
        $cartCount = 0;

        if (Auth::check()) {
            $cartCount = DB::table('carts')
                ->where('user_id', Auth::id())
                ->sum('quantity'); // or ->count() if you only want distinct items
        }

        $view->with('cartCount', $cartCount);
    });
}

}
