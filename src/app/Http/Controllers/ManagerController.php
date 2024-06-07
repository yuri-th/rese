<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Requests\ManagerRequest;

class ManagerController extends Controller
{
    public function manager(){
        $manager_infos = Manager::paginate(5);
        return view('/manage/manager_manage',['manager_infos' => $manager_infos]);
    }

    public function create(ManagerRequest $request)
    {
        if ($request->get('action') === 'back') {
            return redirect()->route('form.show')->withInput();
        }

        $form = $request->only([
            'name',
            'shop',
            'area_id',
            'postcode',
            'address',
            'tel',
            'email',
            'birthdate'
        ]);

        $shop = Shop::where('name',$form['shop'])->first();

        if (!$shop) {
        return redirect('/manage/manager_manage')->with('error_message', '該当するお店が見つかりません');
        }
        
        $shop_id = $shop->id;
         
        Manager::create([
            'name' => $form['name'], 
            'shop_id' => $shop_id,
            'area_id' => $form['area_id'], 
            'postcode' => $form['postcode'],
            'address' => $form['address'],
            'tel' => $form['tel'],
            'email' => $form['email'],
            'birthdate' => $form['birthdate']
            ]);

        
        return redirect('/manage/manager_manage')->with('new_message' ,'店舗代表者を作成しました');
    }

    public function manager_search(Request $request)
    {
        if ($request->name !== null && $request->area_id == null) {
            $shops = Shop::KeywordSearch($request->name)->get();
            $shop_id = $shops->pluck('id')->toArray();
            $manager_infos = Manager::whereIn('shop_id', $shop_id)->paginate(5);
            return view('/manage/manager_manage', ['manager_infos' => $manager_infos]);

            } else if ($request->name == null && $request->area_id !== null) {
            $manager_infos = Manager::where('area_id', $request->area_id)->paginate(5);
            return view('/manage/manager_manage', ['manager_infos' => $manager_infos]);
            } else {
                $shops = Shop::KeywordSearch($request->name)->get();
                $shop_id = $shops->pluck('id')->toArray();
                $manager_infos = Manager::whereIn('shop_id', $shop_id)->where('area_id', $request->area_id)->paginate(5);
                return view('/manage/manager_manage', ['manager_infos' => $manager_infos]);
            }
    }
}
