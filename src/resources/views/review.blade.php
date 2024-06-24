@extends('layouts.app')

@section('js')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css"> -->

@endsection

@section('content')
<div class="review-content">
    <div class="shop_info">
        <h1>今回のご利用はいかがでしたか？</h1>

        <!-- ショップ情報 -->
        <div class="shop__flex--item">
            @foreach ($shop_infos as $shop_info)
            <div class="shop__card">
                <div class="shop__img">
                    <img src="{{$shop_info->image_url}}" alt="{{$shop_info->getGenre()}}" />
                </div>
                <div class="card__content">
                    <h2 class="card__ttl">{{$shop_info->name}}</h2>
                    <div class="tag">
                        <form class="form" action="/area" method="get">
                            @csrf
                            <button class="card__tag--area" type="submit">#{{$shop_info->getArea()}}</button>
                            <input type="hidden" name="area_id" value="{{$shop_info->area_id}}" />
                        </form>
                        <form class="form" action="/genre" method="get">
                            @csrf
                            <button class="card__tag--genre" type="submit">#{{$shop_info->getGenre()}}</button>
                            <input type="hidden" name="genre_id" value="{{$shop_info->genre_id}}" />
                        </form>
                    </div>

                    @if (isset($averageRatings[$shop_info->id]))
            <div class="card__review">
                <div id=averageStars class="star-rating" data-rating="{{ $averageRatings[$shop_info->id] }}">
                    <star-rating :rating="{{ $averageRatings[$shop_info->id] }}" :increment="0.5" :max-rating="5"
                        inactive-color="#c0c0c0" active-color="#daa520" :star-size="20" :show-rating="false"
                        :padding="1" :read-only="true">
                    </star-rating>
                </div>
            </div>
            @else
            <div class="card__review"><span>&emsp;</span></div>
            @endif
                    <div class="card__button">
                        <form class="form" action="/detail/{{$shop_info->id}}" method="get">
                            @csrf
                            <button class="card__button--details" type="submit">詳しくみる</button>
                        </form>
                        <form class="form" action="/like" method="post">
                            @csrf
                            <input type="hidden" name="shop_id" value="{{$shop_info->id}}" />

                            {{-- お気に入り色変更 --}}
                            @php
                            $isFavorite = false;
                            foreach ($favorite_shops as $favorite_shop) {
                            if ($shop_info->id == $favorite_shop->shop_id) {
                            $isFavorite = true;
                            break;
                            }
                            }
                            @endphp

                            @if ($isFavorite)
                            <button class="card__button--like favorite" type="submit"><i
                                    class="fas fa-heart"></i></button>
                            @else
                            <button class="card__button--like not-favorite" type="submit"><i
                                    class="fas fa-heart"></i></button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="vertical-line no-sp"></div>
    <hr class="no-pc">
    <!-- レビュー投稿-->
    <div class="review-form">
        <div class="review__alert">
            @if(session('new_message'))
            <div class="alert">
                {{ session('new_message') }}
            </div>
            @endif

            @if(session('error_message'))
            <div class="alert">
                {{ session('error_message') }}
            </div>
            @endif

            @if(session('error_message-null'))
            <div class="alert">
                {{ session('error_message-null') }}
            </div>
            @endif

            @if(session('error_message-review'))
            <div class="alert">
                {{ session('error_message-review') }}
            </div>
            @endif
        </div>

        <h3>体験を評価してください</h3>
        <form class="review-create" action="/review/post" method="post" enctype="multipart/form-data">
            @csrf
            <div id="ratingApp" class="star-rating">
                <star-rating v-model="rating" :increment="1" :max-rating="5"
                inactive-color="#c0c0c0" active-color="#daa520" :star-size="40" :show-rating="false"
                :padding="1">
                </star-rating>
                <input type="hidden" name="stars" :value="rating" />
            </div>
            @error('stars')
            <p class="error-message">{{ $message }}</p>
            @enderror
            <h3 class="review-input">口コミを投稿</h3>
            <textarea type="text" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('description')}}</textarea>
            <p class="character-limit">0/400(最高文字数)</p>
            @error('comment')
            <p class="error-message">{{ $message }}</p>
            @enderror
            <h3>画像の追加</h3>
            <div class="upload-area" id="uploadArea">
                <p>Clickして写真を追加</p>
                <p>または画像をドラッグ＆ドロップ</p>
                <input name="files[]" type="file" id="fileInput" multiple style="display: none;"/>
            </div>

            <div class="review-btn"><button type="submit">口コミを投稿</button></div>
            <input type="hidden" name="shop_name" value="{{$shop_info->name}}" />
        </form>
    </div>
</div>

<script src="{{ asset('js/review.js') }}"></script>
<script src="{{ mix('js/starRating.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@endsection