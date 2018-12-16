<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<div class="body-wrapper">
    <body>
        <main id="main">
            @include('layouts.header')
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <div class="footer-wrapper text-center">
                    <a href="https://twitter.com/SoundAlive2">
                        <i class="fab fa-twitter-square fa-3x footer-icon"></i>
                    </a>
                    {{--<a href="https://www.facebook.com/SoundAlive-%E3%83%90%E3%83%B3%E3%83%89%E7%B7%8F%E5%90%88%E6%A4%9C%E7%B4%A2%E3%82%B5%E3%82%A4%E3%83%88-2181257818792730">--}}
                        {{--<i class="fab fa-facebook-square fa-3x footer-icon"></i>--}}
                    {{--</a>--}}
                    <p>SoundAlive公式</p>
                    <p>Copyright © Freedom Freak All Rights Reserved.</p>
                </div>
            </div>
        </footer>
        <script src="{{ asset('js/header.js') }}"></script>
    </body>
</div>
</html>
