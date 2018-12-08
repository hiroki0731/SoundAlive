@extends('layouts.app')
@section('content')
    <div id="top">
        <div class="about-wrapper">
            <div class="container">
                <h1>SoundAliveは<br>無料のライブ総合検索・告知サービスです</h1>
                <p>ライブは「有名プロのチケットを事前予約して行くもの」ではありません </p>
                <p>実はすぐそこのJazz BarやLive Houseは、今日も素敵なミュージシャンの演奏で溢れています</p>
                <p>・・・にも関わらず、それを知るすべがあまりに限られてます</p>
                <p>もっと多くの人にこんなにも素晴らしいライブがそこかしこで開かれていることを伝えたく、このサイトは生まれました</p>
            </div>
        </div>
        <div class="heading" style="width: 100%">
            <h2>ライブをお探しの方</h2>
        </div>
        <div class="about-content-wrapper">
            <div class="container">
                <div class="row user-explain">
                    <div class="col-sm-4" @click="moveToSearch()">
                        <h3><i class="far fa-hand-point-right"></i> 簡単にライブが検索できる！</h3>
                        <div class="content-icon concert-img">
                            <img src="{{ asset('/img/search.png') }}" width="100%">
                            <div class="mask">
                                <div class="caption">Search...</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 text-middle">
                        <p>「明日、山手線沿線のどこかの駅でやってるジャズのライブないかなあ」</p>
                        <p>といったような、ふわっとした気持ちでも気楽で簡単にライブを探すことができます。</p>
                        <p>他にも駅の直接指定、バンド名の指定、ライブ会場名の指定、などの絞り込みが可能です。</p>
                        <p>色々なアーティストの音楽を聴いて、豊かな時間を送ってみませんか？</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="heading" style="width: 100%">
            <h2>ライブを告知したい方</h2>
        </div>
        <div class="about-content-wrapper">
            <div class="container">
                <div class="row user-explain">
                    <div class="col-sm-4">
                        <h3><i class="far fa-hand-point-right"></i> このウェブサイトにライブを無料掲載できる！</h3>
                        <div class="content-icon about-img">
                            <img src="{{ asset('/img/pc.png') }}" width="100%">
                        </div>
                    </div>
                    <div class="col-sm-8 text-middle">
                        <p>あなたのライブがこのサイトに掲載され、日本中のみなさんに見てもらえます！</p>
                        <p>今までは、あなたのSNSとライブ会場のHP以外にライブを告知できるツールがなかなかありませんでした。</p>
                        <p>このサイトはそんなあなたの為に、第三のライブ告知媒体として活用することができます。</p>
                    </div>
                </div>
                <div class="row user-explain">
                    <div class="col-sm-4">
                        <h3><i class="far fa-hand-point-right"></i> SoundAlive公式SNSがライブを告知してくれる！</h3>
                        <div class="content-icon about-img">
                            <img src="{{ asset('/img/sns.png') }}" width="100%">
                        </div>
                    </div>
                    <div class="col-sm-8 text-middle">
                        <div>
                            <p>SoundAliveは公式のSNS（現在はTwitter）を持っています。</p>
                            <p>ライブを作成した後に、公式SNSで拡散ボタンを押すと、あなたのライブ情報を公式SNSに投稿できます！</p>
                            <p>もちろんその投稿をあなた自身のSNSでシェアし直すこともできます。</p>
                            <p>あなたのライブ告知を加速させるツールとして活用してください。</p>
                        </div>
                    </div>
                </div>
                {{--<div class="row user-explain">--}}
                    {{--<div class="col-sm-4">--}}
                        {{--<h3><i class="far fa-hand-point-right"></i> 簡単にライブのチラシが作成できる!</h3>--}}
                        {{--<div class="content-icon about-img">--}}
                            {{--<img src="{{ asset('/img/printer.png') }}" width="100%">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-8 text-middle">--}}
                        {{--<p>ライブのチラシを作成するのって以外と面倒ではありませんか？</p>--}}
                        {{--<p>このサイトでライブを作成すると、そのライブ情報の画面をそのまま画像としてダウンロードできるので</p>--}}
                        {{--<p>それをそのままチラシとして印刷することができます。</p>--}}
                        {{--<p>背景は何種類もありますので、あなたのライブとマッチするものをお選びください。</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/top.js') }}"></script>
@endsection