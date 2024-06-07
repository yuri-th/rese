<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Management</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manager_manage.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-ttl">
                <a class="header__logo" href="/manage/manager_manage">
                    Manager Management
                </a>
            </div>
        </div>
    </header>
    <main>
        <div class="manager-information">
            <h2>店舗代表者情報</h2>

            <div class="manager__alert">
            @if(session('new_message'))
            <div class="manager__alert--success">
            {{ session('new_message') }}
            </div>
            @endif

            @if(session('error_message'))
            <div class="alert alert-danger">
            {{ session('error_message') }}
            </div>
            @endif
            </div>

            <div class="form-contents">
                <div class="manager-search">
                    <form class="search-form" action="/manage/manager_manage/search" method="get">
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
                <hr>
                <div class="manager-create">
                    <div class="manager-create__contents">
                        <form class="create-form" action="/manage/manager_manage" method="post">
                            @csrf
                            <div class="create-item">
                                <label for="name">代表者氏名</label>
                                <input type="text" name="name" value="{{ old('name')}}" />
                                @error('name')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="create-item_shop">
                                <label for="shop">店舗名</label>
                                <input type="text" name="shop" value="{{ old('shop')}}" />
                                @error('shop')
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
                            <div class="create-item_birthday">
                                <label for="'birthday">生年月日</label>
                                <input type="date" name="birthdate" value="{{ old('birthdate')}}" />
                                @error('birthdate')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="create-item_postcode">
                                <label for="postcode">郵便番号</label>
                                <span> 〒 </span>
                                <input type="hidden" class="p-country-name" value="Japan">
                                <input type="text" placeholder="例）100-0003"  name="postcode" id="postcode" value="{{ old('postcode')}}"
                                    onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" z />
                                @error('postcode')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="create-item">
                                <label for="address">住所</label>
                                <input type="text" name="address" id="address" value="{{ old('address')}}" />
                                @error('address')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="create-item">
                                <label for="tel">電話番号</label>
                                <input type="tel" placeholder="例）0363521321" name="tel" value="{{ old('tel')}}" />
                                @error('tel')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="create-item">
                                <label for="mail">メールアドレス</label>
                                <input type="email" placeholder="例）example@test.com" name="email" value="{{ old('email')}}" />
                                @error('email')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="create-button">
                                <button type="submit">作成</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- 登録データ -->
            <div class="manager-list">
                <div class="table-page">
                    <div>
                        @if (count($manager_infos) > 0)
                        <p>全{{ $manager_infos->total() }}件中
                            {{ ($manager_infos->currentPage() - 1) * $manager_infos->perPage() + 1 }}〜
                            {{ ($manager_infos->currentPage() - 1) * $manager_infos->perPage() + 1 +
                            (count($manager_infos)
                            - 1) }}件</p>
                        @else
                        <p>データがありません。</p>
                        @endif
                    </div>
                    <div>
                        {{ $manager_infos->appends(request()->input())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <table class="manager-table">
                    <tr class="table-title">
                        <th>ID</th>
                        <th>エリア</th>
                        <th>店舗名</th>
                        <th>代表者</th>
                        <th>メールアドレス</th>
                    </tr>
                    @foreach($manager_infos as $manager_info )
                    <form action="" method="">
                        @csrf
                        <tr class="table-data">
                            <input type="hidden" name="firstPage" value="{{$manager_infos->url(1)}}">
                            <input type="hidden" name="currentPage" value="{{$manager_infos->currentPage()}}">
                            <input type="hidden" name="id" value="">
                            <td class="table-id"><input type="text" name="id" value="{{$manager_info->id}}" /></td>
                            <td class="table-area"><input type="text" name="area"
                                    value="{{$manager_info->getArea()}}" />
                            </td>
                            <td class="table-shop"><input type="text" name="shop"
                                    value="{{$manager_info->getShop()}}" />
                            </td>
                            <td class="table-name"><input type="text" name="name" value="{{$manager_info->name}}" />
                            </td>
                            <td class="table-mail"><input type="text" name="email" value="{{$manager_info->email}}" />
                            </td>
                        </tr>
                    </form>
                    @endforeach
                </table>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/manager.js') }}"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</body>

</html>