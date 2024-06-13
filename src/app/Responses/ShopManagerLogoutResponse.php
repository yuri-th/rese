<?php

namespace App\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class ShopManagerLogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('shop.login');
    }
}