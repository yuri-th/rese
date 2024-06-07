<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\ShopReview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Storage;



class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shop_cards = Shop::all();

        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();

        $shop_ids = Shop::pluck('id');
        $averageRatings = [];
        foreach ($shop_ids as $shop_id) {
            // 各店舗の評価を取得して平均評価を計算
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();

            // 結果がnullでない場合のみ配列に格納
            if ($ratings !== null) {
                $averageRatings[$shop_id] = $ratings;
            }
        }
        // デバッグ用: $averageRatings の内容をログに記録
        \Log::info('Average Ratings: ', $averageRatings);

        return view('index', [
            'shop_cards' => $shop_cards,
            'favorite_shops' => $favorite_shops,
            'averageRatings' => $averageRatings,
        ]);
    }

    public function detail(Shop $shop)
    {
        $user = Auth::id();
        $shop_record = Shop::where('id', $shop->id)->get();
        $reviews = ShopReview::where('shop_id', $shop->id)->where('user_id', $user)->get();

        // 他のユーザーのレビューを取得
        $other_reviews = ShopReview::where('shop_id', $shop->id)
            ->where('user_id', '!=', $user)
            ->get();

        return view('detail', [
            'shop_records' => $shop_record,
            'reviews' => $reviews,
            'other_reviews' => $other_reviews,
        ]);
    }

    // ソート検索
    public function search_sort(Request $request)
    {
        $sort = $request->input('sort', 'default');

        if ($sort === '2') {
            $shop_cards = ShopReview::with('shop')
                ->orderBy('stars', 'asc')
                ->get();
        } else {
            $shop_cards = ShopReview::all();
        }

        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();
        return view('index', ['shop_cards' => $shop_cards], ['favorite_shops' => $favorite_shops]);
    }

    // エリア検索
    public function search_area(Request $request)
    {
        $shop_cards = Shop::with('areas')->AreaSearch($request->area_id)->get();
        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();
        return view('index', ['shop_cards' => $shop_cards], ['favorite_shops' => $favorite_shops]);
    }

    // ジャンル検索
    public function search_genre(Request $request)
    {
        $shop_cards = Shop::with('genres')->GenreSearch($request->genre_id)->get();
        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();
        return view('index', ['shop_cards' => $shop_cards], ['favorite_shops' => $favorite_shops]);
    }

    // 店名検索
    public function search_name(Request $request)
    {
        $shop_cards = $shop_cards = Shop::KeywordSearch($request->name)->get();
        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();

        if ($shop_cards->isEmpty()) {
            return view('index', ['shop_cards' => $shop_cards, 'favorite_shops' => $favorite_shops, 'message' => 'データがありません']);
        } else {
            return view('index', ['shop_cards' => $shop_cards, 'favorite_shops' => $favorite_shops]);
        }
    }

    //店舗画像の追加・表示
    // public function upload(Request $request)
    // {
    // $request->validate([
    //     'file' => 'required|image|mimes:jpeg,png|max:2048',
    // ]);

    // if ($request->file('file')) {
    //     $file = $request->file('file');
    //     $fileName = time() . '-' . $file->getClientOriginalName();
    //     $file->storeAs('images', $fileName, 'public');
    // }

    // ファイルの保存が成功した場合の処理を追加

    // return response()->json(['success' => 'アップロードが成功しました']);
    // }
    // public function upload()
    // {   
    //     return view('/upload/upload');
    // }

    // public function upload_image(Request $request)
    // {   
    //     $dir = 'images';
    //     $file_name = $request->file('image')->getClientOriginalName();
    //     $request->file('image')->storeAs('public/' . $dir, $file_name);
    //     return redirect('/upload/upload');
    // }

    // 店舗管理：店舗情報の表示

    public function shopmanage()
    {
        $shop_infos = Shop::paginate(10);
        return view('/manage/shop_manage', ['shop_infos' => $shop_infos]);
    }

    // 店舗情報の作成
    public function create(ShopRequest $request)
    {
        if ($request->get('action') === 'back') {
            return redirect()->route('shopmanage')->withInput();
        }

        $info = $request->only([
            'name',
            'area_id',
            'genre_id',
            'image_url',
            'description',
        ]);

        Shop::create($info);
        return redirect('/manage/shop_manage')->with('new_message', '店舗情報を作成しました');
    }

    // 店舗情報の更新
    public function update(Request $request)
    {
        $shop_id = $request->only(['shop_id']);
        $name = $request->input('name');
        $area = $request->input('area');
        $area_id = Area::where('name', $area)->pluck('id')->first();
        $genre = $request->input('genre');
        $genre_id = Genre::where('name', $genre)->pluck('id')->first();
        $image_url = $request->input('image_url');
        $description = $request->input('description');

        Shop::where('id', $shop_id)->update([
            'name' => $name,
            'area_id' => $area_id,
            'genre_id' => $genre_id,
            'image_url' => $image_url,
            'description' => $description,
        ]);

        if ($request->currentPage == 1) {
            return redirect($request->firstPage)->with('new_message', '店舗情報を更新しました');
        } else {
            return back()->with('new_message', '店舗情報を更新しました');
        }
    }

    public function search_shop(Request $request)
    {
        if ($request->name !== null && $request->area_id == null) {
            $shop_infos = Shop::KeywordSearch($request->name)->paginate(10);
            return view('/manage/shop_manage', ['shop_infos' => $shop_infos]);
        } else if ($request->name == null && $request->area_id !== null) {
            $shop_infos = Shop::with('areas')->AreaSearch($request->area_id)
                ->paginate(10);
            return view('/manage/shop_manage', ['shop_infos' => $shop_infos]);
        } else {
            $shop_infos = Shop::with('areas')->AreaSearch($request->area_id)->KeywordSearch($request->name)->paginate(10);
            return view('/manage/shop_manage', ['shop_infos' => $shop_infos]);
        }
    }


    // レビュー投稿ページ表示
    public function review(Request $request)
    {
        $user = Auth::id();
        $shop_id = $request->only(['shop_id']);
        $shop_infos = Shop::where('id', $shop_id)->get();
        $reviews = ShopReview::where('shop_id', $shop_id)->where('user_id', $user)->get();
        $favorite_shops = Like::where('user_id', $user)->get();

        return view('review', [
            'shop_infos' => $shop_infos,
            'reviews' => $reviews,
            'favorite_shops' => $favorite_shops
        ]);
    }

    // レビュー投稿
    public function review_post(ReviewRequest $request)
    {

        $review = $request->only([
            'stars',
            'comment',
            'shop_name',
        ]);

        $user = Auth::id();
        $shop_name = $review['shop_name'];
        $shop = Shop::Where('name', $shop_name)->first();

        $shop_id = $shop->id;
        $userReview = ShopReview::where('user_id', $user)->where('shop_id', $shop_id)->first();

        if ($userReview) {
            return redirect()->back()->with('error_message-review', 'レビューは2回以上投稿できません');
        }


        $reservation = Reservation::with('shops')->Where('shop_id', $shop_id)->where('user_id', $user)->first();


        if ($reservation) {
            $reservationDate = $reservation->date;
            $reservationTime = $reservation->start_at;
            $dateTime = $reservationDate . ' ' . $reservationTime;
            $currentDate = Carbon::now();

            // 予約日時を過ぎている場合
            if ($currentDate > $dateTime) {
                $stars = $request->input('stars');
                $comment = $request->input('comment');

                // ファイルがアップロードされているかを確認
                if ($request->hasFile('file') && $request->file('file')->isValid()) {
                    $request->validate([
                        'file' => 'image|mimes:jpg,png,jpeg|max:2048',
                    ]);

                    $file = $request->file('file');
                    $fileName = $file->getClientOriginalName();
                    $file->storeAs('public/images', $fileName);
                    $imageUrl = Storage::url('public/images/' . $fileName);

                } else {
                    $imageUrl = '';
                }

                ShopReview::create([
                    'shop_id' => $shop_id,
                    'user_id' => $user,
                    'stars' => $stars,
                    'comment' => $comment,
                    'image_path' => $imageUrl
                ]);

                return redirect()->back()->with('new_message', 'レビューを投稿しました！');
            } else if ($currentDate < $dateTime) {
                return redirect()->back()->with('error_message', 'レビューはご来店後にご投稿いただけます');
            }
        } else {
            return redirect()->back()->with('error_message-null', 'ご予約情報が見つかりません');
        }
    }


    // レビュー編集
    public function review_update(Request $request)
    {
        $user = Auth::id();
        $stars = $request->input('stars');
        $comment = $request->input('comment');
        $review_id = $request->input('review_id');
        ShopReview::where('id', $review_id)->where('user_id', $user)->update([
            'stars' => $stars,
            'comment' => $comment,
        ]);
        return back()->with('update_message', 'レビューを更新しました');
    }

    //レビュー削除
    public function review_delete(Request $request)
    {
        $user = Auth::id();
        $review_id = $request->input('review_id');

        ShopReview::where('id', $review_id)->where('user_id', $user)->delete();
        return back()->with('delete_message', 'レビューを削除しました');

    }

}