@extends('layouts.app')

@section('content')
    <div id="mypage">
        <div class="mypage-wrapper">
            <div class="container">
                <div class="row">
                    {{--サイドメニュー--}}
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">{{ $userName }}のマイページ</div>
                            <div class="card-body mypage-menu">
                                <p @click='switchDisplay(displays.list)'
                                   :class="{active_page: !dispNonArray.dispNonList}">ライブ一覧</p>
                                <p @click='switchDisplay(displays.create)'
                                   :class="{active_page: !dispNonArray.dispNonCreate}">ライブ新規作成</p>
                                <p @click='switchDisplay(displays.change)'
                                   :class="{active_page: !dispNonArray.dispNonChange}">ユーザ名変更</p>
                            </div>
                        </div>
                    </div>
                    {{--メインメニュー--}}
                    <div class="col-md-9 mypage-menu-panel">
                        <div id="list" :class="{dispnon: dispNonArray.dispNonList}">
                            @include('mypage.concert_list')
                        </div>
                        <div id="create" :class="{dispnon: dispNonArray.dispNonCreate}">
                            @include('mypage.create_concert')
                        </div>
                        <div id="change" :class="{dispnon: dispNonArray.dispNonChange}">
                            @include('mypage.change_name')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/mypage.js') }}" defer></script>
    <script src="{{ asset('/js/area.js') }}" defer></script>

@endsection
