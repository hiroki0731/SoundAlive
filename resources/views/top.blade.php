@extends('layouts.app')
@section('content')
<div class="top-wrapper">
    <div class="container">
        <h1>Sound A<span style="color: #ffe70a;">LIVE</span></h1>
        <h1>音楽は<span style="color: #ffe70a;">生</span>きてる。音楽は<span style="color: #ffe70a;">LIVE</span>だ。</h1>
        <p>サウンドアライブは「もっとライブを身近に。」をモットーにした「総合ライブ検索・登録サービス」です。</p>
        <p>有名バンドやフェス以外にも、素敵なライブがそこかしこで開かれています。</p>
        <p>さあ、近場のライブを検索してみましょう。</p>
        <p>ミュージシャンは自分のライブを登録してみましょう。</p>
        <a href="{{ url('/register') }}" class="btn signup"><i class="fas fa-address-book"></i> ミュージシャンはこちらから登録</a>
    </div>
</div>
<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <h2>このサイトの活用方法</h2>
        </div>
        <div class="contents">
            <div class="content">
                <h3>ライブを検索しよう</h3>
                <div class="content-icon">
                    <img src="{{ asset('/img/search.png') }}" width="50%">
                </div>
                <p class="text-contents">ライブをジャンル・場所・日時などで検索しましょう。近場のライブハウスやジャズバーでは、今日も魂の込もった音楽が演奏されて、誰かの心を動かしています。</p>
            </div>
            <div class="content">
                <h3>登録してライブを告知しよう</h3>
                <div class="content-icon">
                    <img src="{{ asset('/img/regist.png') }}" width="50%">
                </div>
                <p class="text-contents">
                    ミュージシャンは無料登録をして自分のライブをどんどん告知しましょう。ライブハウスのウェブサイトや自分のSNS以外の強力な広告ツールとして活用してください。</p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="content-wrapper">
    <div class="heading">
        <h2>おすすめライブ</h2>
    </div>
</div>
@endsection