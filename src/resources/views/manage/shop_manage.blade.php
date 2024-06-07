@extends('layouts.app_m')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_manage.css') }}">
@endsection

@section('content')
<div class="shop-information">
  <h2>店舗情報</h2>

  <div class="shop__alert">
    @if(session('new_message'))
    <div class="shop__alert--success">
      {{ session('new_message') }}
    </div>
    @endif
  </div>

  <div class="form-contents">
    <div class="shop-search">
      <form class="search-form" action="/manage/shop_manage/search" method="get">
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
          <button type="submit">店舗検索</button>
        </div>
      </form>
    </div>
    <hr>
    <div class="shop-create">
      <div class="shop-create__contents">
        <form class="create-form" action="/manage/shop_manage" method="post">
          @csrf
          <div class="create-item">
            <label for="name">店舗名</label>
            <input type="text" name="name" value="{{ old('name')}}" />
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="create-item">
            <label for="area">エリア</label>
            <select name="area_id">
              <option value="">Area</option>
              <option value="1" @if(old('area_id')==1) selected @endif>東京都</option>
              <option value="2" @if(old('area_id')==2) selected @endif>大阪府</option>
              <option value="3" @if(old('area_id')==3) selected @endif>福岡県</option>
            </select>
            @error('area_id')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="create-item">
            <label for="genre">ジャンル</label>
            <select name="genre_id">
              <option value="">Genre</option>
              <option value="1" @if(old('genre_id')==1) selected @endif>寿司</option>
              <option value="2" @if(old('genre_id')==2) selected @endif>焼肉</option>
              <option value="3" @if(old('genre_id')==3) selected @endif>居酒屋</option>
              <option value="4" @if(old('genre_id')==4) selected @endif>イタリアン</option>
              <option value="5" @if(old('genre_id')==5) selected @endif>ラーメン</option>
            </select>
            @error('genre_id')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="create-item__image">
            <label for="image_url">画像URL</label>
            <input type="url" name="image_url" value="{{ old('image_url')}}" />
            @error('image_url')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="create-item">
            <label for="description">店舗詳細</label>
            <textarea type="text" name="description">{{ old('description')}}</textarea>
            @error('description')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="create-button">
            <button type="submit">新規作成</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- 登録データ -->
  <div class="shop-list">
    <div class="table-page">
      <div>
        @if (count($shop_infos) > 0)
        <p>全{{ $shop_infos->total() }}件中
          {{ ($shop_infos->currentPage() - 1) * $shop_infos->perPage() + 1 }}〜
          {{ ($shop_infos->currentPage() - 1) * $shop_infos->perPage() + 1 + (count($shop_infos) - 1) }}件</p>
        @else
        <p>データがありません。</p>
        @endif
      </div>
      <div>
        {{ $shop_infos->appends(request()->input())->links('pagination::bootstrap-4') }}
      </div>
    </div>
    <table class="shop-table">
      <tr class="table-title">
        <th>店名</th>
        <th>エリア</th>
        <th>ジャンル</th>
        <th>イメージ</th>
        <th>詳細</th>
        <th></th>
      </tr>
      @foreach($shop_infos as $shop_info )
      <form action="/manage/shop_manage/update" method="PATCH">
        @csrf
        @method('PATCH')
        <tr class="table-data">
          <input type="hidden" name="firstPage" value="{{$shop_infos->url(1)}}">
          <input type="hidden" name="currentPage" value="{{$shop_infos->currentPage()}}">
          <input type="hidden" name="shop_id" value="{{$shop_info->id}}">
          <td class="table-name"><input type="text" name="name" value="{{ $shop_info->name }}" /></td>
          <td class="table-area"><input type="text" name="area" value="{{ $shop_info->getArea() }}" /></td>
          <td class="table-genre"><input type="text" name="genre" value="{{ $shop_info->getGenre() }}" /></td>
          <td class="table-image"><input type="text" name="image_url" value="{{ $shop_info->image_url }}" /></td>
          <td class="table-description"><input type="text" name="description" value="{{ $shop_info->description }}" />
          </td>
          <td class="update"><button type="submit">更新</button></td>
        </tr>
      </form>
      @endforeach
    </table>
  </div>
</div>
@endsection