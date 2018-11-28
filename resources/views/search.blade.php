@extends('layouts.app')

@section('content')
    <div id="mypage" class="mypage-wrapper">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-header">検索条件選択</div>
                    <div class="card-body">
                        <form action="{{ url('/search') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>日付を指定</label>
                                    <br>
                                    <input type="date" name="concert_date" value="">
                                </div>
                                <div class="col-sm-3">
                                    <label>エリアを指定</label>
                                    <br>
                                    <select name="pref" id="pref"
                                            onChange="setMenuItem(false, this[this.selectedIndex].value)">
                                        <option value="0" selected>都道府県を選択</option>
                                        @foreach(Helper::getPref() as $key => $val)
                                            <option value={{ $key }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <select name="line" id="line"
                                            onChange="setMenuItem(true, this[this.selectedIndex].value)">
                                        <option value="" selected>路線を選択
                                    </select>
                                    <br>
                                    <select name="station" id="station">
                                        <option value="" selected>駅を選択
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>ジャンルを指定</label>
                                    <br>
                                    <select name="music_type" id="music_type">
                                        <option value="0" selected>音楽ジャンルを選択</option>
                                        @foreach(Helper::getMusicType() as $key => $val)
                                            <option value={{ $key }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>バンド名で検索</label>
                                    <br>
                                    <input type="text" name="band_name" placeholder="バンド名を入力">
                                </div>
                            </div>

                            <input type="submit" value="検索">
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="card">
                    <div class="card-header">検索結果一覧</div>

                    <div class="card-body">
                        @foreach($concerts as $concert)
                            @php
                                $detail_info = json_decode($concert->detail_info);
                                $music_type = Helper::getMusicTypeName($detail_info->music_type);
                                $station_code = $detail_info->station ?? '';
                                $station_line = Helper::getStationLine($station_code);
                                $station_name = Helper::getStationName($station_code);
                                $pref_name = Helper::getPrefName($detail_info->pref ?? '');
                            @endphp
                            <div class="mypage-concert-list-wrapper">
                                <div class="row mypage-concert-list pointer">
                                    <div class="col-md-3">
                                        <img src={{ asset('storage/images/'. $detail_info->concert_img) }} style="width:100%">
                                    </div>
                                    <div class="col-md-9">
                                        <p>都道府県：{{ $pref_name }}</p>
                                        <p>開催日：{{ $detail_info->concert_date }}</p>
                                        <p>バンド名：{{ $detail_info->band_name }}</p>
                                        <p>音楽ジャンル：{{ $music_type }}</p>
                                        <p>最寄駅：{{ $station_line }} {{ $station_name }}駅</p>
                                        <p>ライブタイトル：{{ $detail_info->concert_name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--<p>{{ $concerts->links() }}</p>--}}

                        @if (empty($concerts) || count($concerts) === 0)
                            <p>検索結果なし</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/area.js') }}"></script>
@endsection