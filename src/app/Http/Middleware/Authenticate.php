<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('manage/manager_manage') || $request->is('manage/manager_manage/*')) {
                return route('admin.login');
            }

            if ($request->is('manage/shop_manage')|| $request->is('manage/shop_manage/*')) {
                return route('shop.login');
            }

            return route('login');
        }
    }

}
