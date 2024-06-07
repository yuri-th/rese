<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Illuminate\Support\Facades\Auth;




class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
        public function toResponse($request)
        {
            return view('auth.verify-email');
        }
        });

        $this->app->instance(VerifyEmailResponse::class, new class implements VerifyEmailResponse {
        public function toResponse($request)
        {
            return redirect('/thanks');
        }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
         return view('auth.register');
     });

        Fortify::loginView(function () {
         return view('auth.login');
     });

        RateLimiter::for('login', function (Request $request) {
         $email = (string) $request->email;
         return Limit::perMinute(10)->by($email . $request->ip());
     });

     Fortify::VerifyEmailView(function () {       
        Auth::guard()->logout();
        return view('auth.verify-email');
     });  
    }
}
