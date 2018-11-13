<header>
    <div class="container">
        <div class="header-left">
            <img class="logo" src="https://prog-8.com/images/html/advanced/main_logo.png">
        </div>
        {{--<span class="fa fa-bars menu-icon"></span>--}}
        <div class="header-right">
            <a href="#"><i class="fas fa-search"></i> ライブ検索</a>
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