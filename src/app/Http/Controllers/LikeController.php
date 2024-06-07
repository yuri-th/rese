<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
     public function create(Request $request)
    {
        $shop_id = request('shop_id');
        
        $user = Auth::id();
        $like = Like::where('user_id', $user)->where('shop_id',$shop_id)->select('shop_id')->get();
        
        if($like->count() === 0){
            Like::create([
                'shop_id' => $shop_id,
                'user_id' => $user,
            ]);
            return redirect("/");
            
        } else{
            Like::where('user_id', $user)->where('shop_id',$shop_id)->delete();
            return redirect("/");
        }
    } 
}
