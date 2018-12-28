@extends('layouts.app')
@section('content')
    <div id="top">
        <div class="top-wrapper">
            <div class="container">
                <h1>Sound A<span style="color: #ffe70a;">LIVE</span></h1>
                <h2>音楽は、<span style="color: #ffe70a;">生</span>きている</h2>
                <p>サウンドアライブは「<span style="color: #ffe70a;">生の音楽体験をもっと身近に</span>」をモットーにした「ライブ・イベントの告知/検索サービス」です。</p>
                <p>有名アーティストやフェス以外にも、素敵なライブやクラブイベントがそこかしこで開かれています。</p>
                <p>さあ、近場のライブ・イベントを検索して、生の音楽体験を味わいましょう！</p>
                <p>ライブスペースオーナーやミュージシャン、イベント広報の方はどんどんライブ・イベントを告知しましょう！</p>
                <a href="{{ url('/register') }}" class="top-btn signup"><i class="fas fa-address-book"></i>
                    こちらから無料登録して告知する</a>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="container">
                <div class="heading">
                    <h2>このサイトの活用方法</h2>
                </div>
                <div class="contents row">
                    <div class="content col-md-4" @click="moveToSearch()">
                        <h3>すぐにライブ・イベントを検索しよう</h3>
                        <div class="content-icon concert-img">
                            <img src="{{ asset('/img/search.png') }}" width="100%">
                            <div class="mask">
                                <div class="caption">Search...</div>
                            </div>
                        </div>
                        <p class="text-contents">
                            ライブ・イベントをジャンル・場所・日時などで検索しましょう。近場のライブハウスやジャズバーでは、今日も魂の込もった音楽が演奏されて、誰かの心を動かしています。
                        </p>
                    </div>
                    <div class="content col-md-4" @click="moveToRegister()">
                        <h3>登録してライブ・イベントを告知しよう</h3>
                        <div class="content-icon concert-img">
                            <img src="{{ asset('/img/regist.png') }}" width="100%">
                            <div class="mask">
                                <div class="caption">Register...</div>
                            </div>
                        </div>
                        <p class="text-contents">
                            ライブスペースオーナーやミュージシャン・イベント広報担当者の方々は無料登録をしてライブ・イベントをどんどん告知しましょう。ライブハウスのウェブサイトや自分のSNS以外の強力な広告ツールとして活用してください。
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
                    <h2>新着ライブ・イベント！</h2>
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
                                                <img src="{{ asset($detail_info->concert_img ?? '/img/no_image.png') }}"
                                                     width="100%" height="">
                                            </div>
                                            <div class="mask">
                                                <div class="caption">この詳細をみる</div>
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
    <script src="{{ asset('js/top.js') }}" defer></script>
@endsection