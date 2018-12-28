@extends('layouts.app')
@section('content')
    @php
        $detail_info = json_decode($concert->detail_info);
        $station_code = $detail_info->station ?? '';
        $line_code = $detail_info->line ?? '';
    @endphp
    <form name="concertForm" enctype="multipart/form-data" action="/mypage/update/{{ $concert->id }}" method="post"
          id="mypage">
        {{ csrf_field() }}

        <div class="detail-wrapper detail-update">
            <h4 class="text-center">ライブ・イベント編集ページ</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="detail-container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="detail-title"><input class="text-center" type="text" name="concert_name"
                                                        value="{{ $detail_info->concert_name }}" placeholder="ライブ・イベントタイトル">
                        </h1>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <p class="card-title">※ライブ・イベント紹介用の画像を選んでください。</p>
                            <img v-show="!uploadedImage" src="{{ asset($detail_info->concert_img ?? '/img/no_image.png') }}"
                                 style="width: 100%;">
                            <img v-show="uploadedImage" :src="uploadedImage" style="width: 100%;"/>
                            <input type="file" @change="onFileChange" name="concert_img"
                                   value="{{ $detail_info->concert_img }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <h2>
                                <input class="text-center" type="text" name="band_name"
                                       value="{{ $detail_info->band_name }}" placeholder="アーティスト名">
                            </h2>
                            <p>
                                <input class="text-center" type="text" name="band_member"
                                       value="{{ $detail_info->band_member }}"
                                       placeholder="メンバー (例) 高田大輝 (pf), 辰巳浩之 (dr), 牛山健太郎 (bs)">
                            </p>
                        </div>
                        <div class="detail-border">
                            <div class="input-group">
                                <p class="input-group-addon">ライブ・イベント日程：</p>
                                <input class="form-control" type="date" name="concert_date"
                                       value="{{ $detail_info->concert_date }}">
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">開催時間：</p>
                                <input class="form-control text-center" type="time" name="start_time"
                                       value="{{ $detail_info->start_time ?? ''}}"> 〜
                                <input class="form-control text-center" type="time" name="end_time"
                                       value="{{ $detail_info->end_time ?? ''}}">
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">会場名：</p>
                                <input class="form-control" type="text" name="place_name"
                                       value="{{ $detail_info->place_name ?? ''}}" placeholder="例) ライブハウス○○">
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">最寄駅：</p>
                                <p class="input-group-addon now-data">{{ Helper::getLineName($line_code) }} {{ Helper::getStationName($station_code) }}
                                    駅</p>
                                <button id="show-area-button" type="button" @click="toggleSelectBox">変更</button>
                                <div id="show-select-box area" :class="{dispnon: hideSelectBox}"
                                     style="margin-top: 3px;">
                                    <select id="pref" name="pref"
                                            onChange="setMenuItem(false, this[this.selectedIndex].value)">
                                        <option value="{{ $detail_info->pref ?? ''}}" selected>都道府県を選択
                                        @foreach(Helper::getPref() as $key => $val)
                                            <option value={{ $key }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    <select name="line" id="line"
                                            onChange="setMenuItem(true, this[this.selectedIndex].value)">
                                        <option value="{{ $detail_info->line ?? '' }}" selected>路線を選択</option>
                                    </select>
                                    <select name="station" id="station">
                                        <option value="{{ $detail_info->station ?? '' }}" selected>駅を選択</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">ジャンル：</p>
                                <select name="music_type" id="music_type">
                                    <option value="" selected>一番近いジャンルを選択</option>
                                    @foreach(Helper::getMusicType() as $key => $val)
                                        <option value={{ $key }} @if($key == $detail_info->music_type) selected @endif>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">チャージ：</p>
                                <input class="form-control" type="text" name="concert_money"
                                       value="{{ $detail_info->concert_money ?? ''}}" placeholder="例) 3,500円(税込)">
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">会場住所：</p>
                                <input class="form-control" type="text" name="place_address"
                                       value="{{ $detail_info->place_address ?? ''}}"
                                       placeholder="例) 神奈川県横浜市港北区テスト町1-1-1">
                                <p id="concert-address" style="display: none">{{ $detail_info->place_address ?? ''}}</p>
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">URL：</p>
                                <input class="form-control" type="text" name="place_url"
                                       value="{{ $detail_info->place_url ?? ''}}"
                                       placeholder="例) http://sample.concert.place.com">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="detail-introduction">
                            <label for="title">ライブ・イベント説明</label>
                            <textarea name="concert_introduction"
                                      placeholder="例) ライブ・イベントを自由に紹介してください。(200文字以内)">{!! $detail_info->concert_introduction ?? '' !!}</textarea>
                        </div>
                    </div>
                </div>
                @if(!empty($detail_info->movie_id))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="detail-introduction">
                                <label for="title">紹介動画</label> ※正しい動画URLを貼って登録すると表示されます。
                                <br>
                                <input type="text" name="movie_id"
                                       value="https://www.youtube.com/embed/{{ $detail_info->movie_id}}"
                                       placeholder="任意でYouTube動画リンクを入力。例)https://www.youtube.com/watch?v=ZpbkJTdgVzA">
                                <div class="youtube">
                                    <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/{{ $detail_info->movie_id}}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="detail-introduction">
                            <label for="title">会場アクセスマップ</label> ※正しい会場住所を入れて登録すると表示されます。
                            <div id="address-map"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-submit-btn">
                <input type="submit" value="編集を完了する">
            </div>
        </div>
    </form>
    <script src="{{ asset('/js/mypage.js') }}"></script>
    <script src="{{ asset('/js/area.js') }}"></script>
    <script src="{{ asset('/js/map.js') }}"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ Helper::getGoogleMapKey() }}&callback=initMap"
            type="text/javascript"></script>

@endsection