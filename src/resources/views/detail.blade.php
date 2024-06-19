@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="shop__info">
    <div class="shop__detail">
        <div>
            <form action="/" method="get">
                @csrf
                @foreach ($shop_records as $shop_record)
                <div class="shop__detail--ttl">
                    <button class="shop__detail--btn" type="submit">＜</button>
                    <span class="shop__detail--name">{{$shop_record->name}}</span>
                </div>
            </form>
            <div class="shop__detail--img">
                <img src="{{$shop_record->image_url}}" alt="{{$shop_record->getGenre()}}" />
            </div>
            <div class="tag">
                <form class="form" action="/area" method="get">
                    @csrf
                    <button class="shop__tag--area" type="submit">#{{$shop_record->getArea()}}</button>
                    <input type="hidden" name="area_id" value="{{$shop_record->area_id}}" />
                </form>
                <form class="form" action="/genre" method="get">
                    @csrf
                    <button class="shop__tag--genre" type="submit">#{{$shop_record->getGenre()}}</button>
                    <input type="hidden" name="genre_id" value="{{$shop_record->genre_id}}" />
                </form>
            </div>
            <p class="shop__description">{{$shop_record->description}}</p>

        </div>
        @endforeach
        <!-- 口コミ一覧 -->
        <div class="review-list">
            <form class="form" action="/review" method="get">
                @csrf
                <button class="review-post_btn" type="submit">口コミを投稿する</button>
                <input type="hidden" name="shop_id" value="{{$shop_record->id}}" />
            </form>
            <button class="review-list_btn" id="showAllReviews" type="submit">すべての口コミ情報</button>
            <!-- ユーザーのレビューを表示 -->
            <div class="shop__alert">
                @if(session('update_message'))
                <div class="shop__alert--success">
                    {{ session('update_message') }}
                </div>
                @endif
                @if(session('delete_message'))
                <div class="shop__alert--success">
                    {{ session('delete_message') }}
                </div>
                @endif
            </div>
            @foreach ($reviews as $review)
            <div class="user-post">
                <hr>
                <form class="form" action="/review/delete" method="post">
                    @csrf
                    <input type="hidden" name="review_id" value="{{$review->id}}" />
                    <button type="submit" class="delete_btn">口コミを削除</button>
                </form>
                <form action="/review/update" method="post">
                    @csrf
                    <div class="star">
                        @if(isset($review))
                        <div class="star-rating" data-review-stars="{{ $review->stars }}">
                            <star-rating :rating="selectedRating" :increment="1" :max-rating="5"
                                inactive-color="#c0c0c0" active-color="#daa520" :star-size="30" :show-rating="false"
                                :padding="1" @rating-selected="updateRating" data-review-stars="{{ $review->stars }}">
                            </star-rating>
                            <input type="hidden" name="stars" v-model="selectedRating" />
                        </div>
                        @endif
                    </div>

                    <div class="review-comment">
                        <input type="text" name="comment" value="{{$review->comment}}" />
                    </div>
                    <div class="review-image">
                    @if(isset($review->image_path))
                    <img src="{{ asset($review->image_path) }}" alt="Review Image">
                    @else
                    <p>No image available</p>
                    @endif
                    </div>
                    <input type="hidden" name="review_id" value="{{$review->id}}" />
                    <button type="submit" class="edit_btn">口コミを編集</button>
                </form>
            </div>
            @endforeach
            <!-- 他のユーザーのレビューを非表示で表示 -->
            <div id="otherReviews" class="other-user-post" style="display: none;">
                @foreach ($other_reviews as $other_review)
                <hr>
                <div class="star">
                    @if(isset($other_review))
                    <div class="star-rating" data-review-stars="{{ $other_review->stars }}">
                        <star-rating :rating="{{ $other_review->stars }}" :increment="1" :max-rating="5"
                            inactive-color="#c0c0c0" active-color="#daa520" :star-size="30" :show-rating="false"
                            :padding="1" :read-only="true">
                        </star-rating>
                    </div>
                    @endif
                </div>
                <div class="review-comment">
                    {{$other_review->comment}}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="reservation__form">
        <div class="reservation__form--content">
            <h2>予約</h2>
            <div class="reservation__form--date">
                <input type="date" name="reservation_date" id="reservation_date" />
                @error('reservation_date')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="reservation__form--time">
                <select name="time" id="reservation_time">
                    <option value="">Time</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00">18:00</option>
                    <option value="18:30">18:30</option>
                    <option value="19:00">19:00</option>
                    <option value="19:30">19:30</option>
                    <option value="20:00">20:00</option>
                    <option value="20:30">20:30</option>
                    <option value="21:00">21:00</option>
                    <option value="21:30">21:30</option>
                    <option value="22:00">22:00</option>
                </select>
                @error('time')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="reservation__form--number">
                <select name="number" id="reservation_number">
                    <option value="">Number</option>
                    <option value="1人">1人</option>
                    <option value="2人">2人</option>
                    <option value="3人">3人</option>
                    <option value="4人">4人</option>
                    <option value="5人">5人</option>
                    <option value="6人">6人</option>
                    <option value="7人">7人</option>
                    <option value="8人">8人</option>
                    <option value="9人">9人</option>
                    <option value="10人">10人</option>
                </select>
                @error('number')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <form class="form" action="/reserve" method="post">
            @csrf
            <div class="reservation__form--confirm">
                @foreach ($shop_records as $shop_record)
                <div>
                    <label for="confirm__name" class="form-title">Shop</label>
                    <input type="text" name="name" value="{{$shop_record->name}}" readonly />
                    <input type="hidden" name="shop_id" value="{{$shop_record->id}}">
                </div>
                @endforeach
                <div>
                    <label for="confirm__date" class="form-title">Date</label>
                    <input type="text" name="reservation_date" id="confirm__date" readonly />
                </div>
                <div>
                    <label for="confirm__time" class="form-title">Time</label>
                    <input type="text" name="time" id="confirm__time" readonly />
                </div>
                <div>
                    <label for="confirm__number" class="form-title">Number</label>
                    <input type="text" name="number" id="confirm__number" readonly />
                </div>
            </div>
            <button class="reservation__form--btn" type="submit">予約する</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/reserve.js') }}"></script>
<script src="{{ asset('js/detail.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

@endsection