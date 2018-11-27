@extends('layouts.app')
@section('content')
    @php
        $detail_info = json_decode($concert->detail_info);
        $station_code = $detail_info->station ?? '';
    @endphp
    <script src="{{ asset('/js/mypage.js') }}"></script>
    <form name="concertForm" enctype="multipart/form-data" action="/mypage/update/{{ $concert->id }}" method="post">
        {{ csrf_field() }}

        <div class="detail-wrapper detail-update">
            <h4 class="text-center">ライブ編集ページ</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="detail-title"><input class="text-center" type="text" name="concert_name"
                                                        value="{{ $detail_info->concert_name }}" placeholder="ライブタイトル">
                        </h1>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6" id="mypage">
                        <div>
                            <p class="card-title">※ライブ紹介用の画像を選んでください。</p>
                            <img v-show="!uploadedImage" src="{{ asset('storage/images/'.$detail_info->concert_img) }}"
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
                                       value="{{ $detail_info->band_name }}" placeholder="バンド名">
                            </h2>
                            <p>
                                <input class="text-center" type="text" name="band_member"
                                       value="{{ $detail_info->band_member }}"
                                       placeholder="バンドメンバー (例) 高田大輝 (pf), 辰巳浩之 (dr), 牛山健太郎 (bs)">
                            </p>
                        </div>
                        <div class="detail-border">
                            <div class="input-group">
                                <p class="input-group-addon">ライブ日程：</p>
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
                                <p class="input-group-addon">ライブ会場：</p>
                                <input class="form-control" type="text" name="place_name"
                                       value="{{ $detail_info->place_name ?? ''}}" placeholder="例) ライブハウス○○">
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">最寄駅：</p>
                                <p class="input-group-addon now-data">{{ Helper::getStationLine($station_code) }} {{ Helper::getStationName($station_code) }}駅</p>
                                <div id="show-select-box" :class="{dispnon: hideSelectBox}">
                                    <select id="pref" name="pref"
                                            onChange="setMenuItem(false, this[this.selectedIndex].value)">
                                        <option value="{{ $detail_info->pref }}" selected>都道府県を選択
                                        <option value="1">北海道
                                        <option value="2">青森県
                                        <option value="3">岩手県
                                        <option value="4">宮城県
                                        <option value="5">秋田県
                                        <option value="6">山形県
                                        <option value="7">福島県
                                        <option value="8">茨城県
                                        <option value="9">栃木県
                                        <option value="10">群馬県
                                        <option value="11">埼玉県
                                        <option value="12">千葉県
                                        <option value="13">東京都
                                        <option value="14">神奈川県
                                        <option value="15">新潟県
                                        <option value="16">富山県
                                        <option value="17">石川県
                                        <option value="18">福井県
                                        <option value="19">山梨県
                                        <option value="20">長野県
                                        <option value="21">岐阜県
                                        <option value="22">静岡県
                                        <option value="23">愛知県
                                        <option value="24">三重県
                                        <option value="25">滋賀県
                                        <option value="26">京都府
                                        <option value="27">大阪府
                                        <option value="28">兵庫県
                                        <option value="29">奈良県
                                        <option value="30">和歌山県
                                        <option value="31">鳥取県
                                        <option value="32">島根県
                                        <option value="33">岡山県
                                        <option value="34">広島県
                                        <option value="35">山口県
                                        <option value="36">徳島県
                                        <option value="37">香川県
                                        <option value="38">愛媛県
                                        <option value="39">高知県
                                        <option value="40">福岡県
                                        <option value="41">佐賀県
                                        <option value="42">長崎県
                                        <option value="43">熊本県
                                        <option value="44">大分県
                                        <option value="45">宮崎県
                                        <option value="46">鹿児島県
                                        <option value="47">沖縄県
                                    </select>
                                    <select name="line" id="line"
                                            onChange="setMenuItem(true, this[this.selectedIndex].value)">
                                        <option value="{{ $detail_info->line }}" selected>路線を選択</option>
                                    </select>
                                    <select name="station" id="station">
                                        <option value="{{ $detail_info->station }}" selected>駅を選択</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group">
                                <p class="input-group-addon">ジャンル：</p>
                                <input class="form-control" type="text" name="music_type"
                                       value="{{ $detail_info->music_type ?? ''}}" placeholder="例) ロック、ジャズ">
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
                            <label for="title">ライブ自由紹介</label>
                            <textarea name="concert_introduction"
                                      placeholder="例) ライブを自由に紹介してください。(200文字以内)">{!! $detail_info->concert_introduction ?? '' !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-submit-btn">
                <input type="submit" value="登録する" width="10%">
            </div>
        </div>
    </form>
    <p @click="showSelectBox()">aaaa</p>
    <script src="{{ asset('/js/mypage.js') }}"></script>

@endsection