<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v3.2&appId=1942484519112218&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div id="header">
    <header>
        <div class="container">
            <div class="header-left">
                <a href="{{ url('/') }}"><img class="logo" src="{{ asset('/img/sa.jpg') }}"></a>
            </div>
            <i class="fas fa-bars menu-icon" @click="toggleMobileMenu"></i>
            <div class="header-right">
                <a href="{{ url('/search') }}"><i class="fas fa-search"></i> ライブ検索</a>
                <a href="{{ url('/about') }}"><i class="fas fa-book"></i> このサイトについて</a>
                <?php $check = \Illuminate\Support\Facades\Auth::check(); ?>
                @if(!$check)
                    <a href="{{ url('/register') }}"><i class="fas fa-address-book"></i> 新規登録</a>
                    <a href="{{ url('/login') }}" class="login"><i class="fas fa-music"></i> ログイン</a>
                @else
                    <a href="{{ url('/mypage') }}"><i class="fas fa-home"></i> マイページ</a>
                    <a href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i> ログアウト</a>
                @endif
            </div>
        </div>
    </header>
    <div id="mobile-menu" :style="mobileMenu">
        <ul>
            <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> ホーム</a></li>
            <li><a href="{{ url('/search') }}"><i class="fas fa-search"></i> ライブ検索</a></li>
            <li><a href="{{ url('/about') }}"><i class="fas fa-book"></i> このサイトについて</a></li>
            <?php $check = \Illuminate\Support\Facades\Auth::check(); ?>
            @if(!$check)
                <li><a href="{{ url('/register') }}"><i class="fas fa-address-book"></i> 新規登録</a></li>
                <li><a href="{{ url('/login') }}" class="login"><i class="fas fa-music"></i> ログイン</a></li>
            @else
                <li><a href="{{ url('/mypage') }}"><i class="fas fa-home"></i> マイページ</a></li>
                <li><a href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i> ログアウト</a></li>
            @endif
        </ul>
    </div>
</div>
