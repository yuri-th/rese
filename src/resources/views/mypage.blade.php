@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <h1 class="user-name">
        <?php $user = Auth::user(); ?>{{ $user->name }}さん
    </h1>

    <div class="reserve__alert">
        @if(session('message'))
            <div class="reserve__alert--success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="mypage__content">
        <div class="reservation__status">
            <h2>予約状況</h2>
            @foreach ($reserves as $index => $reserve)
                <div class="reservation__form">
                    <div class="reservation__status-icon">
                        <div class="icon__clock">
                            <i class="far fa-clock icon__clock--size"></i>
                            <span>{{$index + 1}}</span>
                        </div>
                        <form class="delete__form" action="/reserve/delete" method="post">
                            @csrf
                            <button class="icon__delete" type="submit">
                                <i class="far fa-times-circle icon__delete--size"></i>
                            </button>
                            <input type="hidden" name="id" value="{{$reserve->id}}">
                        </form>
                    </div>
                    <form class="update__form" action="/reserve/update" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="confirm__name">
                            <label for="confirm__name" class="form-title">Shop</label>
                            <input type="text" name="name" value="{{$reserve->shopName()}}" readonly />
                            <input type="hidden" name="shop_id" value="{{$reserve->shop_id}}">
                            <input type="hidden" name="id" value="{{$reserve->id}}">
                        </div>
                        <div class="confirm__date">
                            <label for="confirm__date" class="form-title">Date</label>
                            <input type="text" name="date" value="{{$reserve->date}}" />
                        </div>
                        <div class="confirm__time">
                            <label for="confirm__time" class="form-title">Time</label>
                            <input type="text" name="start_at" value="{{substr($reserve->start_at, 0, 5)}}" />
                        </div>
                        <div class="confirm__number">
                            <label for="confirm__number" class="form-title">Number</label>
                            <input type="text" name="num_of_users" value="{{$reserve->num_of_users}}" />
                        </div>
                        <button class="reservation__change--btn" type="submit">変更する</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="favorite__store">
            <h2>お気に入り店舗</h2>
            <div class="favorite__store-list">
                @foreach ($shops as $shop)
                                <div class="shop__card">
                                    <div class="shop__img">
                                        <img src="{{$shop->image_url}}" alt="{{$shop->getGenre()}}" />
                                    </div>
                                    <div class="card__content">
                                        <h2 class="card__ttl">{{$shop->name}}</h2>
                                        <div class="tag">
                                            <form class="form" action="/area" method="get">
                                                @csrf
                                                <button class="card__tag--area" type="submit">#{{$shop->getArea()}}</button>
                                                <input type="hidden" name="area_id" value="{{$shop->area_id}}" />
                                            </form>
                                            <form class="form" action="/genre" method="get">
                                                @csrf
                                                <button class="card__tag--genre">#{{$shop->getGenre()}}</button>
                                                <input type="hidden" name="genre_id" value="{{$shop->genre_id}}" />
                                            </form>
                                        </div>
                                        <!-- レビュー -->
                                        <form class="form" action="/review" method="get">
                                            @csrf
                                            <div class="card__review"><button type="submit">review</button></div>
                                            <input type="hidden" name="shop_id" value="{{$shop->id}}" />
                                        </form>
                                        <div class="card__button">
                                            <form class="form" action="/detail/{{$shop->id}}" method="get">
                                                @csrf
                                                <button class="card__button--details" type="submit">詳しくみる</button>
                                            </form>
                                            <form class="form" action="/like" method="post">
                                                @csrf
                                                <input type="hidden" name="shop_id" value="{{$shop->id}}" />

                                                {{-- お気に入り色変更 --}}
                                                @php
                                                    $isFavorite = false;
                                                    foreach ($likes as $like) {
                                                        if ($shop->id == $like) {
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
    </div>
</div>
@endsection