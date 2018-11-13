<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>ライブ検索サイト</title>
</head>
<body>
    @include('layouts.header')
    {{--メインコンテンツ--}}
    @yield('main')
    <footer>
        <div class="container">
            <p>Copyright © Freedom Freak All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>