@extends('layouts.app')
@section('content')
    <div id="top">
        <div class="top-wrapper">
            <div class="container">
                <h1>Sound A<span style="color: #ffe70a;">LIVE</span></h1>
                <h2>音楽は、<span style="color: #ffe70a;">生</span>きている</h2>
                <p>サウンドアライブは「もっとライブを身近に。」をモットーにした「総合ライブ検索・登録サービス」です。</p>
                <p>有名バンドやフェス以外にも、素敵なライブがそこかしこで開かれています。</p>
                <p>さあ、近場のライブを検索してみましょう！</p>
                <p>ミュージシャンは自分のライブを告知してみましょう！</p>
                <a href="{{ url('/register') }}" class="top-btn signup"><i class="fas fa-address-book"></i>
                    ミュージシャンはこちらから無料登録</a>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="container">
                <div class="heading">
                    <h2>このサイトの活用方法</h2>
                </div>
                <div class="contents row">
                    <div class="content col-md-4" @click="moveToSearch()">
                        <h3>すぐにライブを検索しよう</h3>
                        <div class="content-icon concert-img">
                            <img src="{{ asset('/img/search.png') }}" width="100%">
                            <div class="mask">
                                <div class="caption">Search...</div>
                            </div>
                        </div>
                        <p class="text-contents">
                            ライブをジャンル・場所・日時などで検索しましょう。近場のライブハウスやジャズバーでは、今日も魂の込もった音楽が演奏されて、誰かの心を動かしています。
                        </p>
                    </div>
                    <div class="content col-md-4" @click="moveToRegister()">
                        <h3>登録してライブを告知しよう</h3>
                        <div class="content-icon concert-img">
                            <img src="{{ asset('/img/regist.png') }}" width="100%">
                            <div class="mask">
                                <div class="caption">Register...</div>
                            </div>
                        </div>
                        <p class="text-contents">
                            ミュージシャンは無料登録をして自分のライブをどんどん告知しましょう。ライブハウスのウェブサイトや自分のSNS以外の強力な広告ツールとして活用してください。
                        </p>
                    </div>
                    <div class="content col-md-4" @click="moveToAbout()">
                        <h3>もっと詳しく知りたいなら</h3>
                        <div class="content-icon concert-img">
                            <img src="{{ asset('/img/book.png') }}" width="100%">
                            <div class="mask">
                                <div class="caption">Detail...</div>
                            </div>
                        </div>
                        <p class="text-contents">
                            このサイトの特徴や活用方法をもっと詳しく記載したページをこちらからご覧ください
                        </p>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        @if(count($concerts) > 0)
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
                            $station_code = $detail_info->station ?? '';
                            $line_code = $detail_info->line ?? '';
                        @endphp
                        <div class="concert" :style="childSlider">
                            <div class="band-name">
                                <h3>{{ $detail_info->band_name }}</h3>
                            </div>
                            <div class="concert-icon">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="concert-img" @click="moveToDetail({{ $concert->id }})">
                                            <div style="max-height: 350px">
                                                <img src="{{ asset($detail_info->concert_img) }}"
                                                     width="100%" height="">
                                            </div>
                                            <div class="mask">
                                                <div class="caption">ライブの詳細をみる</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="concert-text-contents">
                                日付：{{ Helper::formatConcertDate($detail_info->concert_date) }}
                            </p>
                            <p class="concert-text-contents">
                                場所：{{ Helper::getPrefName($detail_info->pref ?? '') }} {{ Helper::getLineName($line_code) }} {{ Helper::getStationName($station_code) }}駅
                            </p>
                            <p>{{ $detail_info->concert_name }}</p>
                        </div>
                    @endforeach
                    <span ref="slideNum" style="display: none">{{ count($concerts) }}</span>
                    <div class="clear"></div>
                </div>
                <a class="slide_btn slide_btn_left" @click.prevent="changeSlide(false)">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a class="slide_btn slide_btn_right" @click.prevent="changeSlide(true)">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        @endif
    </div>
    <script src="{{ asset('js/top.js') }}"></script>
@endsection