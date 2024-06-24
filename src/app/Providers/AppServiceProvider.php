<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use App\Responses\AdminLogoutResponse;
use App\Responses\ShopManagerLogoutResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(LogoutResponseContract::class, AdminLogoutResponse::class);
        // $this->app->singleton(LogoutResponseContract::class, ShopManagerLogoutResponse::class);
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
