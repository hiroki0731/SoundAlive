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
            <a href="{{ url('/register') }}" class="top-btn signup"><i class="fas fa-address-book"></i> ミュージシャンはこちらから登録</a>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container">
            <div class="heading">
                <h2>このサイトの活用方法</h2>
            </div>
            <div class="contents">
                <div class="content pointer" @click="moveToSearch()">
                    <h3>すぐにライブを検索しよう</h3>
                    <div class="content-icon">
                        <img src="{{ asset('/img/search.png') }}" width="50%">
                    </div>
                    <p class="text-contents">
                        ライブをジャンル・場所・日時などで検索しましょう。近場のライブハウスやジャズバーでは、今日も魂の込もった音楽が演奏されて、誰かの心を動かしています。
                    </p>
                </div>
                <div class="content pointer" @click="moveToRegister()">
                    <h3>登録してライブを告知しよう</h3>
                    <div class="content-icon">
                        <img src="{{ asset('/img/regist.png') }}" width="50%">
                    </div>
                    <p class="text-contents">
                        ミュージシャンは無料登録をして自分のライブをどんどん告知しましょう。ライブハウスのウェブサイトや自分のSNS以外の強力な広告ツールとして活用してください。
                    </p>
                </div>
                <div class="content pointer" @click="moveToRegister()">
                    <h3>もっと詳しく知りたいなら</h3>
                    <div class="content-icon">
                        <img src="{{ asset('/img/book.png') }}" width="50%">
                    </div>
                    <p class="text-contents">
                        このサイトの特徴や活用方法をもっと詳しく記載したページをこちらからご覧ください
                    </p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="container" style="text-align: center;">
        <div class="heading">
            <h2>新着ライブ！</h2>
        </div>
    </div>
    <div class="concert-wrapper">
        <div class="concerts" :style="parentSlider">
            @foreach($concerts as $concert)
                @php
                    $detail_info = json_decode($concert->detail_info);
                    $count = count($concerts) ?? 0;
                @endphp
                <div class="concert" :style="childSlider">
                    <h4>{{ $detail_info->band_name }}</h4>
                    <div class="concert-icon">
                        <div class="row">
                            <div class="col-sm-1">
                                <a class="slide_btn slide_btn_left" @click.prevent="changeSlide(false)"><i class="fas fa-chevron-left"></i></a>
                            </div>
                            <div class="col-sm-10">
                                <div class="concert-img" @click="moveToDetail({{ $concert->id }})">
                                    <img src="{{ asset('storage/images/'. $detail_info->concert_img) }}" width="100%">
                                    <div class="mask">
                                        <div class="caption">詳しくみる...</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <a class="slide_btn slide_btn_right" @click.prevent="changeSlide(true)"><i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <p class="concert-text-contents">
                        開催日：{{ $detail_info->concert_date }}<br>
                        {{ $detail_info->concert_name }}<br>
                    </p>
                </div>
            @endforeach
            <span ref="slideNum" style="display: none">{{ $count }}</span>
            <div class="clear"></div>
        </div>
    </div>
    <script src="{{ asset('js/top.js') }}"></script>
@endsection