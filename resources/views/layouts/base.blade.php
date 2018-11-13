<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>ライブ検索サイト</title>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-left">
                <img class="logo" src="https://prog-8.com/images/html/advanced/main_logo.png">
            </div>
            {{--<span class="fa fa-bars menu-icon"></span>--}}
            <div class="header-right">
                <a href="#"><i class="fas fa-search"></i> ライブ検索</a>
                <a href="{{ url('/register') }}"><i class="fas fa-address-book"></i> 新規登録</a>
                <a href="{{ url('/login') }}" class="login"><i class="fas fa-music"></i> ログイン</a>
            </div>
        </div>
    </header>
    {{--メインコンテンツ--}}
    @yield('main')
    <footer>
        <div class="container">
            <p>Copyright © Freedom Freak All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>