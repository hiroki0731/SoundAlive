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
                                   :class="{active_page: !activateArray.dispNonList}">ライブ一覧</p>
                                <p @click='switchDisplay(displays.create)'
                                   :class="{active_page: !activateArray.dispNonCreate}">ライブ新規作成</p>
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
    </div>
    <script src="{{ asset('/js/mypage.js') }}"></script>
    <script src="{{ asset('/js/area.js') }}"></script>

@endsection
