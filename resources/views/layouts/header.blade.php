<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v3.2&appId=1942484519112218&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<header>
    <div class="container">
        <div class="header-left">
            <a href="{{ url('/') }}"><img class="logo" src="https://prog-8.com/images/html/advanced/main_logo.png"></a>
        </div>
        <i class="fas fa-bars menu-icon"></i>
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