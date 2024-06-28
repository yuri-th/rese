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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();

            // デバッグ出力
            // logger("Shop ID: $shop_id");
            // logger("Ratings: " . json_encode($ratings));

            // 平均評価を小数点第一位までにする
            if ($ratings !== null) {
                $averageRatings[$shop_id] = round($ratings, 1);
            }
        }

        return view('index', [
            'shop_cards' => $shop_cards,
            'favorite_shops' => $favorite_shops,
            'averageRatings' => $averageRatings,
        ]);
    }

    public function detail(Shop $shop)
    {
        $user = Auth::id();
        $user_role = optional(Auth::user())->role;
        // Log::info('User Role:', ['role' => $user_role]);

        $shop_record = Shop::where('id', $shop->id)->get();
        $other_reviews = '';

        // 管理者の場合は全てのレビューを取得
        if ($user_role === 'admin') {
            $reviews = ShopReview::where('shop_id', $shop->id)->get();
        } else {
            $reviews = ShopReview::where('shop_id', $shop->id)->where('user_id', $user)->get();
            $other_reviews = ShopReview::where('shop_id', $shop->id)
                ->where('user_id', '!=', $user)
                ->get();
        }

        return view('detail', [
            'shop_records' => $shop_record,
            'reviews' => $reviews,
            'other_reviews' => $other_reviews,
        ]);
    }

    // 各種ソート検索
    public function search_sort(Request $request)
    {
        $sort = $request->input('sort', 'default');
        $query = Shop::with('reviews');
        // 評価のあるお店を取得してソート
        $shop_cards_with_ratings = $query->get()->filter(function ($shop) {
            return $shop->averageRating() > 0; // 評価があるお店のみをフィルタリング
        });

        if ($sort === '2') {
            $shop_cards_with_ratings = $shop_cards_with_ratings->sortByDesc(function ($shop) {
                return $shop->averageRating();
            });
        } elseif ($sort === '3') {
            $shop_cards_with_ratings = $shop_cards_with_ratings->sortBy(function ($shop) {
                return $shop->averageRating();
            });
        }

        // 評価のないお店を取得
        $shop_cards_without_ratings = $query->get()->filter(function ($shop) {
            return $shop->averageRating() === 0;
        });

        // 評価のあるお店の後に評価のないお店を追加
        $shop_cards = $shop_cards_with_ratings->merge($shop_cards_without_ratings);

        // ランダムソート
        if ($sort === '1') {
            $shop_cards = $shop_cards->shuffle();
        }

        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();
        $shop_ids = Shop::pluck('id');
        $averageRatings = [];
        foreach ($shop_ids as $shop_id) {
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();

            if ($ratings !== null) {
                $averageRatings[$shop_id] = $ratings;
            }
        }

        return view('index', [
            'shop_cards' => $shop_cards,
            'favorite_shops' => $favorite_shops,
            'sort' => $sort,
            'averageRatings' => $averageRatings,
        ]);
    }

    // エリア検索
    public function search_area(Request $request)
    {
        $shop_cards = Shop::with('areas')->AreaSearch($request->area_id)->get();
        $shop_ids = Shop::pluck('id');
        $averageRatings = [];
        foreach ($shop_ids as $shop_id) {
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();
            if ($ratings !== null) {
                $averageRatings[$shop_id] = $ratings;
            }
        }
        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();

        return view('index', [
            'shop_cards' => $shop_cards,
            'favorite_shops' => $favorite_shops,
            'averageRatings' => $averageRatings
        ]);
    }

    // ジャンル検索
    public function search_genre(Request $request)
    {
        $shop_cards = Shop::with('genres')->GenreSearch($request->genre_id)->get();
        $shop_ids = Shop::pluck('id');
        $averageRatings = [];
        foreach ($shop_ids as $shop_id) {
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();
            if ($ratings !== null) {
                $averageRatings[$shop_id] = $ratings;
            }
        }
        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();

        return view('index', [
            'shop_cards' => $shop_cards,
            'favorite_shops' => $favorite_shops,
            'averageRatings' => $averageRatings
        ]);
    }

    // 店名検索
    public function search_name(Request $request)
    {
        $shop_cards = $shop_cards = Shop::KeywordSearch($request->name)->get();
        $shop_ids = Shop::pluck('id');
        $averageRatings = [];
        foreach ($shop_ids as $shop_id) {
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();
            if ($ratings !== null) {
                $averageRatings[$shop_id] = $ratings;
            }
        }
        $user = Auth::id();
        $favorite_shops = Like::where('user_id', $user)->get();

        if ($shop_cards->isEmpty()) {
            return view('index', ['shop_cards' => $shop_cards, 'favorite_shops' => $favorite_shops, 'message' => 'データがありません']);
        } else {
            return view('index', [
                'shop_cards' => $shop_cards,
                'favorite_shops' => $favorite_shops,
                'averageRatings' => $averageRatings
            ]);
        }
    }

    // 店舗管理：店舗情報の表示
    public function shopmanage(Request $request)
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

    // CSVインポート（店舗情報）
    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect('/manage/shop_manage')->with('error_message', 'ファイルがアップロードされていません');
        }

        $file = $request->file('file');
        $validator = Validator::make(
            ['file' => $file],
            ['file' => 'required|mimes:csv,txt|max:2048']
        );

        if ($validator->fails()) {
            return redirect('/manage/shop_manage')->withErrors($validator)->with('error_message', 'ファイルが無効です');
        }

        $filePath = $file->getRealPath();
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        while ($row = fgetcsv($file)) {
            if (count($header) !== count($row)) {
                $errorCount++;
                $errors[] = $row;
                continue;
            }

            $shopData = array_combine($header, $row);

            // 地域の値を変換するマッピング配列
            $areaMap = [
                '東京' => '東京都',
                '大阪' => '大阪府',
                '福岡' => '福岡県'
            ];

            // 地域の値を変換
            if (isset($areaMap[$shopData['地域']])) {
                $shopData['地域'] = $areaMap[$shopData['地域']];
            }

            $isNameValid = strlen($shopData['店舗名']) <= 50;
            $isAreaValid = in_array($shopData['地域'], ['東京都', '大阪府', '福岡県']);
            $isGenreValid = in_array($shopData['ジャンル'], ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン']);
            $isDescriptionValid = strlen($shopData['店舗概要']) <= 400;
            $isImageUrlValid = in_array(pathinfo($shopData['画像URL'], PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png']);

            // Log::debug('Validation results:', [
            //     'name' => $isNameValid,
            //     'area' => $isAreaValid,
            //     'genre' => $isGenreValid,
            //     'description' => $isDescriptionValid,
            //     'image_url' => $isImageUrlValid,
            //     'row_data' => $shopData
            // ]);

            if ($isNameValid && $isAreaValid && $isGenreValid && $isDescriptionValid && $isImageUrlValid) {
                try {
                    $area = Area::where('name', $shopData['地域'])->first();
                    $genre = Genre::where('name', $shopData['ジャンル'])->first();

                    if ($area && $genre) {
                        Shop::create([
                            'name' => $shopData['店舗名'],
                            'area_id' => $area->id,
                            'genre_id' => $genre->id,
                            'description' => $shopData['店舗概要'],
                            'image_url' => $shopData['画像URL']
                        ]);
                        $successCount++;
                    } else {
                        throw new \Exception('Area or Genre not found');
                    }
                } catch (\Exception $e) {
                    // Log::error('Shop creation failed for row: ' . json_encode($shopData) . ' with error: ' . $e->getMessage());
                    $errorCount++;
                    $errors[] = $shopData;
                }
            } else {
                // Log::warning('Validation failed for row: ' . json_encode($shopData));
                $errorCount++;
                $errors[] = $shopData;
            }
        }

        fclose($file);

        if ($errorCount > 0) {
            return redirect('/manage/shop_manage')->with('error_message', '店舗情報データは条件を満たせずインポートできません')->withErrors($errors);
        } else {
            return redirect('/manage/shop_manage')->with('new_message', '全ての店舗情報をインポートしました');
        }
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
        $shop_ids = Shop::pluck('id');
        $averageRatings = [];
        foreach ($shop_ids as $shop_id) {
            $ratings = ShopReview::where('shop_id', $shop_id)->pluck('stars')->avg();

            if ($ratings !== null) {
                $averageRatings[$shop_id] = $ratings;
            }
        }

        return view('review', [
            'shop_infos' => $shop_infos,
            'reviews' => $reviews,
            'favorite_shops' => $favorite_shops,
            'averageRatings' => $averageRatings,
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
                $imageUrls = [];

                // ファイルがアップロードされているかを確認
                if ($request->hasFile('files')) {
                    Log::info('Files found');
                    foreach ($request->file('files') as $file) {
                        if ($file->isValid()) {
                            $request->validate([
                                'files.*' => 'image|mimes:jpg,png,jpeg|max:2048',
                            ]);

                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs('public/images', $fileName);
                            $imageUrls[] = Storage::url($filePath);
                        }
                    }
                }

                // 複数のファイルがアップロードされた場合の処理
                $imageUrl = count($imageUrls) > 0 ? implode(',', $imageUrls) : '';

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
        $user_role = Auth::user()->role;
        $stars = $request->input('stars');
        $comment = $request->input('comment');
        $review_id = $request->input('review_id');

        if ($user_role !== 'user') {
            return back()->with('update_message', '投稿者以外は編集できません');
        }

        if ($user_role === 'user') {
            ShopReview::where('id', $review_id)->where('user_id', $user)->update([
                'stars' => $stars,
                'comment' => $comment,
            ]);
        }
        return back()->with('update_message', 'レビューを更新しました');
    }

    //レビュー削除
    public function review_delete(Request $request)
    {
        $user = Auth::id();
        $user_role = Auth::user()->role;
        $review_id = $request->input('review_id');

        if ($user_role === 'admin') {
            ShopReview::where('id', $review_id)->delete();
        } else {
            ShopReview::where('id', $review_id)->where('user_id', $user)->delete();
        }
        return back()->with('delete_message', 'レビューを削除しました');
    }

}