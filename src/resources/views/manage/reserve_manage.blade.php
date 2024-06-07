@extends('layouts.app_m')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reserve_manage.css') }}">
@endsection

@section('content')
<div class="reserve__information">
  <h2>予約情報</h2>

  <div class="shop__alert">
    @if(session('message'))
    <div class="shop__alert--success">
      {{ session('message') }}
    </div>
    @endif
  </div>

  <div class="form-contents">
    <div class="shop-search">
      <form class="search-form" action="/manage/reserve_manage/search" method="get">
        @csrf
        <div class="search-contents">
          <div class="search-item">
            <label for="name">店舗名</label>
            <input type="text" name="name" />
          </div>
          <div class="search-item">
            <label for="area">エリア</label>
            <select name="area_id">
              <option value="">Area</option>
              <option value="1">東京都</option>
              <option value="2">大阪府</option>
              <option value="3">福岡県</option>
            </select>
          </div>
        </div>
        <div class="search-button">
          <button type="submit">検索</button>
        </div>
      </form>
    </div>
  </div>
  <!-- 登録データ -->
  <div class="reserve-list">
    <div class="table-page">
      <div>
        @if (count($shop_reserves) > 0)
        <p>全{{ $shop_reserves->total() }}件中
          {{ ($shop_reserves->currentPage() - 1) * $shop_reserves->perPage() + 1 }}〜
          {{ ($shop_reserves->currentPage() - 1) * $shop_reserves->perPage() + 1 + (count($shop_reserves) - 1) }}件</p>
        @else
        <p>データがありません。</p>
        @endif
      </div>
      <div>
        {{ $shop_reserves->appends(request()->input())->links('pagination::bootstrap-4') }}
      </div>
    </div>
    <table class="reserve-table">
      <tr class="table-title">
        <th>名前</th>
        <th>店名</th>
        <th>DATE</th>
        <th>TIME</th>
        <th>人数</th>
        <th>E-mail</th>
        <th></th>
      </tr>
      @foreach($shop_reserves as $shop_reserve )
      <tr class="table-data">
        <input type="hidden" name="firstPage" value="">
        <input type="hidden" name="currentPage" value="">
        <input type="hidden" name="shop_id" value="">
        <form class="mail-form" action="/manage/reserve_manage/mail" method="post">
          @csrf
          <td class="table-user">{{$shop_reserve->shopUser()}}</td>
          <td class="table-name">{{$shop_reserve->shopName()}}</td>
          <td class="table-date">{{$shop_reserve->date}}</td>
          <td class="table-time">{{substr($shop_reserve->start_at,0,5)}}</td>
          <td class="table-number">{{$shop_reserve->num_of_users}}</td>

          <td class="table-mail">{{$shop_reserve->userMail()}}</td>
          <input type="hidden" name="user_id" value="{{$shop_reserve->user_id}}">
          <input type="hidden" name="shop_id" value="{{$shop_reserve->shop_id}}">
          <input type="hidden" name="id" value="{{$shop_reserve->id}}">
          <td class="submit"><button type="submit">送信</button></td>
        </form>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection