<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<div class="body-wrapper">
    <body>
        @include('layouts.header')
        <main id="vue-contents">
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <p>Copyright © Freedom Freak All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</div>
</html>
