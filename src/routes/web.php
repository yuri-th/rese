<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ShopLoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('verified')->group(function () {
    Route::get('/thanks', [AuthController::class, 'thanks']);
    // Route::post('/review', [ShopController::class, 'upload'])->name('upload');
    Route::post('/review/post', [ShopController::class, 'review_post']);
    Route::post('/review/update', [ShopController::class, 'review_update']);
    Route::post('/review/delete', [ShopController::class, 'review_delete']);
    Route::post('/like', [LikeController::class, 'create']);
    Route::post('/reserve', [ReservationController::class, 'create']);
    Route::patch('/reserve/update', [ReservationController::class, 'update']);
    Route::post('/reserve/delete', [ReservationController::class, 'delete']);
    Route::get('/done', [ReservationController::class, 'create']);
    Route::get('/mypage', [UserController::class, 'mypage']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// 一般公開ページ
Route::get('/', [ShopController::class, 'index']);
Route::get('/sort', [ShopController::class, 'search_sort']);
Route::get('/area', [ShopController::class, 'search_area']);
Route::get('/genre', [ShopController::class, 'search_genre']);
Route::get('/shopname', [ShopController::class, 'search_name']);
Route::get('/detail/{shop}', [ShopController::class, 'detail']);
Route::get('/review', [ShopController::class, 'review']);

// 管理システム
// 店舗代表者用ルート
Route::prefix('manage')->group(function () {
    Route::get('login', [ShopLoginController::class, 'create'])->name('shop.login');
    Route::post('login', [ShopLoginController::class, 'store']);

    Route::prefix('shop_manage')->group(function () {
        Route::middleware('auth:shop_manager')->group(function () {
            Route::get('/', [ShopController::class, 'shopmanage']);
            Route::post('/', [ShopController::class, 'create'])->name('shopmanage');
            Route::patch('/update', [ShopController::class, 'update']);
            Route::get('/update', [ShopController::class, 'update']);
            Route::get('/search', [ShopController::class, 'search_shop']);
            // Route::post('logout', [ShopLoginController::class, 'destroy'])->name('shop.logout');
            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('shop.logout');
        });
    });
    Route::middleware('auth:shop_manager')->group(function () {
        Route::get('/reserve_manage', [ReservationController::class, 'reserveManage']);
        Route::get('/reserve_manage/search', [ReservationController::class, 'search_reserve']);
        Route::post('/reserve_manage/mail', [ReservationController::class, 'mail']);
        // Route::post('logout', [ShopLoginController::class, 'destroy'])->name('shop.logout');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('shop.logout');
    });
});

// 管理者用ルート
Route::prefix('manage/manager_manage')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [ManagerController::class, 'manager']);
        Route::post('/', [ManagerController::class, 'create']);
        Route::get('/search', [ManagerController::class, 'manager_search']);
        // Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('admin.logout');
    });
});

// Shop画像のアップロード
Route::prefix('upload')->group(function () {
    Route::post('/review', [ShopController::class, 'upload']);
});

// stripe決済
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/stripe', [PaymentController::class, 'create'])->name('create');
    Route::post('/store', [PaymentController::class, 'store'])->name('');
});


