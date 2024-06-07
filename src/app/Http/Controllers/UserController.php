<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
        // 予約状況
        $user = Auth::id();       
        $reserves = Reservation::where('user_id', $user)->get();
                
        // お気に入り
        $likes = Like::where('user_id', $user)->pluck('shop_id');
        $shops = Shop::whereIn('id', $likes)->get();
        
        return view('/mypage',[
            'reserves' => $reserves,
            'shops' => $shops,
            'likes'=>$likes,
        ]);
    
    }
}
