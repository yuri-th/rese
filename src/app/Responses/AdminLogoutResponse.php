<?php

namespace App\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class AdminLogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('admin.login');
    }
}