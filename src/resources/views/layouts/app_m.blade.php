<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Management</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common_m.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-ttl">
                <a class="header__logo" href="/manage/shop_manage">
                    Shop Management
                </a>
            </div>
            <nav class="header-nav">
                <ul class="header-nav-list">
                    <li class="header-nav-item"><a href="/manage/shop_manage">店舗情報</a></li>
                    <li class="header-nav-item"><a href="/manage/reserve_manage">予約情報</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>