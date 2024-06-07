<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Mail; 
use App\Mail\ReserveMail;




class ReservationController extends Controller
{
    public function create(ReservationRequest $request)
    {
        $shop = request('shop_id');  
        $user = Auth::id();
        $number = intval($request->input('number'));
        $date = new Carbon(request('reservation_date'));
        $start_at = new Carbon(request('time'));

            Reservation::create([
                'shop_id' => $shop,
                'user_id' => $user,
                'num_of_users' => $number,
                'date'=>$date,
                'start_at' =>$start_at,               
            ]);

            return view('/done',compact('shop'));
    }
    
    // 予約の取り消し
    public function delete(Request $request)
    {   
        $today = Carbon::now()->toDateString();
        $reservation_date = Reservation::where('id', $request->id)->value('date');
        
        if ($today < $reservation_date) {
            Reservation::where('id', $request->id)->delete();
            return redirect('/mypage')->with('message', 'ご予約をキャンセルしました');
        }else if($today >= $reservation_date) {
            return redirect('/mypage')->with('message', 'キャンセルは当日の前日まで受付しております');
        }
    }

    // 予約の更新
    public function update(Request $request)
    {
        $today = Carbon::now()->toDateString();
        $reserve_id =$request->id;
        $reserve_date=Reservation::where('id',$reserve_id) ->value('date');
        $date = $request->input('date');
        $time = $request->input('start_at'); 
        $number = $request->input('num_of_users');

        if ($today < $reserve_date && $today < $date) {
            $startLimit = Carbon::createFromTime(17, 0, 0);
            $endLimit = Carbon::createFromTime(22, 0, 0);
            $startTime = Carbon::parse($time);

            if ($startTime >= $startLimit && $startTime <= $endLimit) {

                Reservation::where('id', $request->id)
                    ->update([
                        'date' => $date,
                        'start_at' => $time,
                        'num_of_users' => $number,
                    ]);
                return redirect('/mypage')->with('message', 'ご予約を変更しました');
            } else {
                return redirect('/mypage')->with('message', '予約時間は17:00から22:00で受付しております');
            }
        } else if($today >= $date){
                return redirect('/mypage')->with('message', '明日以降の日付をご入力ください');
        } else if($today >= $reserve_date){
        return redirect('/mypage')->with('message', 'ご予約の変更は当日の前日まで受付しております');
        }
    }

    // 管理ページ
    public function reserveManage()
    {
        $shop_reserves = Reservation::paginate(5);
        return view('/manage/reserve_manage',['shop_reserves' => $shop_reserves]);
    }

    public function search_reserve(Request $request)
    {
        if($request->name !== null && $request->area_id == null){
            $shop = Shop::KeywordSearch($request->name)->pluck('id')->toArray();
            $shop_reserves = Reservation::whereIn('shop_id', $shop)->paginate(5);
            return view('/manage/reserve_manage', ['shop_reserves' => $shop_reserves]);
        }else if ($request->name == null && $request->area_id !== null) {
            $shop = Shop::where('area_id', $request->area_id)->pluck('id')->toArray();
            $shop_reserves = Reservation::whereIn('shop_id', $shop)->paginate(5);
            return view('/manage/reserve_manage', ['shop_reserves' => $shop_reserves]);
        } else {
            $shop = Shop::KeywordSearch($request->name)->where('area_id', $request->area_id)->pluck('id')->toArray();
            $shop_reserves = Reservation::whereIn('shop_id', $shop)->paginate(5);
            return view('/manage/reserve_manage', ['shop_reserves' => $shop_reserves]);            
        }
    }

    // 利用者へのメール送信
    public function mail(Request $request) {
    $user_id = $request->only(['user_id']);
    $user = User::find($user_id['user_id']);
    $name = $user->name;
    $shop_id=$request->only(['shop_id']);
    $shop = Shop::find($shop_id['shop_id']);
    $shop_name = $shop->name;
    
    $reserve_id=$request->only(['id']);
    $reservation = Reservation::where('id', $reserve_id)->first();
    $reserve_date = $reservation->date;
    $reserve_time = substr($reservation->start_at,0,5);
    $reserve_number = $reservation->num_of_users;

    Mail::send(new ReserveMail($name,$shop_name,$reserve_date,$reserve_time,$reserve_number));
    return redirect('/manage/reserve_manage')->with('message', 'メールを送信しました');;
    }
}  
