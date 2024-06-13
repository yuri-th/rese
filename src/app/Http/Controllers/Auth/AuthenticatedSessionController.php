<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return app()->make(\App\Responses\AdminLogoutResponse::class)->toResponse($request);
        } elseif (Auth::guard('shop_manager')->check()) {
            Auth::guard('shop_manager')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return app()->make(\App\Responses\ShopManagerLogoutResponse::class)->toResponse($request);
        } else {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return app()->make(LogoutResponse::class)->toResponse($request);
        }
    }
}