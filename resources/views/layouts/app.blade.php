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
                        <p>SoundAlive公式</p>
                    </a>
                    <p>Copyright © Freedom Freak All Rights Reserved.</p>
                </div>
            </div>
        </footer>
        <script src="{{ asset('js/header.js') }}"></script>
    </body>
</div>
</html>
