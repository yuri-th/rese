@extends('layouts.app')

@section('js')
<script src="{{ mix('js/starRating.js') }}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<div class="sort__search">
    <form class="form" action="/sort" method="get" id="Sort_Form">
        @csrf
        <select name="sort" id="Sort_Select">
            <option value="">並び替え：評価高/低</option>
            <option value="1">ランダム</option>
            <option value="2">評価が高い順</option>
            <option value="3">評価が低い順</option>
        </select>
    </form>
</div>


<div class="search__contents">
    <div class="area__search">
        <form class="form" action="/area" method="get" id="Area_Form">
            @csrf
            <select name="area_id" id="Area_Select">
                <option value="">All area</option>
                <option value="1">東京都</option>
                <option value="2">大阪府</option>
                <option value="3">福岡県</option>
            </select>
        </form>
    </div>
    <div class="genre__search">
        <form class="form" action="/genre" method="get" id="Genre_Form">
            @csrf
            <select name="genre_id" id="Genre_Select">
                <option value="">All genre</option>
                <option value="1">寿司</option>
                <option value="2">焼肉</option>
                <option value="3">居酒屋</option>
                <option value="4">イタリアン</option>
                <option value="5">ラーメン</option>
            </select>
        </form>
        <span></span>
    </div>
    <div class="shop__search">
        <form class="form" action="/shopname" method="get" id="Name_Form">
            @csrf
            <input type="text" name="name" id="Shop_Select" placeholder="Search&thinsp;...">
        </form>
    </div>
</div>
@endsection

@section('content')

@if(isset ($message))
<p class=search_message>{{ $message }}</p>
@endif
<div class="shop__flex--item">
    @foreach ($shop_cards as $shop_card)
    <div class="shop__card">
        <div class="shop__img">
            <img src="{{$shop_card->image_url}}" alt="{{$shop_card->getGenre()}}" />
        </div>
        <div class="card__content">
            <h2 class="card__ttl">{{$shop_card->name}}</h2>
            <div class="tag">
                <form class="form" action="/area" method="get">
                    @csrf
                    <button class="card__tag--area" type="submit">#{{$shop_card->getArea()}}</button>
                    <input type="hidden" name="area_id" value="{{$shop_card->area_id}}" />
                </form>
                <form class="form" action="/genre" method="get">
                    @csrf
                    <button class="card__tag--genre" type="submit">#{{$shop_card->getGenre()}}</button>
                    <input type="hidden" name="genre_id" value="{{$shop_card->genre_id}}" />
                </form>
            </div>

            @if (isset($averageRatings[$shop_card->id]))
            <div class="card__review">
                <div id=averageStars class="star-rating" data-rating="{{ $averageRatings[$shop_card->id] }}">
                    <star-rating :rating="{{ $averageRatings[$shop_card->id] }}" :increment="0.5" :max-rating="5"
                        inactive-color="#c0c0c0" active-color="#daa520" :star-size="20" :show-rating="false"
                        :padding="1" :read-only="true">
                    </star-rating>
                </div>
            </div>
            @else
            <div class="card__review"><span>&emsp;</span></div>
            @endif


            <div class="card__button">
                <form class="form" action="/detail/{{$shop_card->id}}" method="get">
                    @csrf
                    <button class="card__button--details" type="submit">詳しくみる</button>
                </form>
                <form class="form" action="/like" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{$shop_card->id}}" />

                    {{-- お気に入り色変更 --}}
                    @php
    $isFavorite = false;
    foreach ($favorite_shops as $favorite_shop) {
        if ($shop_card->id == $favorite_shop->shop_id) {
            $isFavorite = true;
            break;
        }
    }
                    @endphp

                    @if ($isFavorite)
                    <button class="card__button--like favorite" type="submit"><i class="fas fa-heart"></i></button>
                    @else
                    <button class="card__button--like not-favorite" type="submit"><i class="fas fa-heart"></i></button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script src="{{ asset('js/shop.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection