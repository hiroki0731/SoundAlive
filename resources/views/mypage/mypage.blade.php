@extends('layouts.app')

@section('content')
    <div id="mypage" class="mypage-wrapper">
        <div class="container">
            <div class="row">
                {{--サイドメニュー--}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">{{ $userName }}のマイページ</div>
                        <div class="card-body mypage-menu">
                            <p @click='switchDisplay(displays.list)' :class="{active: !activateArray.dispNonList}">ライブ一覧</p>
                            <p @click='switchDisplay(displays.create)' :class="{active: !activateArray.dispNonCreate}">ライブ新規追加</p>
                        </div>
                    </div>
                </div>
                {{--メインメニュー--}}
                <div class="col-md-9">
                    <div id="list" :class="{dispnon: activateArray.dispNonList}">
                        @include('mypage.concert_list')
                    </div>
                    <div id="create" :class="{dispnon: activateArray.dispNonCreate}">
                        @include('mypage.create_concert')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/mypage.js"></script>

    {{--<div id="modal-content">--}}
        {{--<p>おめでとうございます！ライブの新規登録が完了しました！</p>--}}
        {{--<p><a id="modal-close" class="button-link">閉じる</a></p>--}}
    {{--</div>--}}
    {{--<div id="modal-overlay"></div>--}}
    {{--<p><a id="modal-open" class="button-link">クリックするとモーダルウィンドウを開きます。</a></p>--}}
@endsection
