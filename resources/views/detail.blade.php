@extends('layouts.app')
@section('content')
    @php
        $detail_info = json_decode($concert->detail_info);
        $station_code = $detail_info->station ?? '';
        $line_code = $detail_info->line ?? '';
    @endphp
    <div class="detail-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center detail-title">{{ $detail_info->concert_name }}</h1>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/images/'.$detail_info->concert_img) }}" style="width: 100%;">
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <h2>{{ $detail_info->band_name }}</h2>
                        <p>{{ $detail_info->band_member }}</p>
                    </div>
                    <div class="detail-border">
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ ライブ日程</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $detail_info->concert_date }} </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ 開催時間</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $detail_info->start_time ?? ''}}
                                    ~ {{ $detail_info->end_time ?? ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ ライブ会場</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $detail_info->place_name ?? ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ 最寄駅</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ Helper::getLineName($line_code) }} {{ Helper::getStationName($station_code) }}駅</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ ジャンル</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $detail_info->music_type ?? ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ チャージ</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $detail_info->concert_money ?? ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ 会場住所</p>
                            </div>
                            <div class="col-md-8">
                                <p id="concert-address">{{ $detail_info->place_address ?? ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>■ 会場URL</p>
                            </div>
                            <div class="col-md-8">
                                <p>{{ $detail_info->place_url ?? ''}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="detail-introduction">
                        <label for="title">ライブ説明</label>
                        <p>{!! nl2br(e($detail_info->concert_introduction)) !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="detail-introduction">
                        <label for="title">会場アクセスマップ</label>
                        <div id="address-map"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="detail-introduction">
                        <label for="title">YouTube動画</label>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/map.js') }}"></script>
    {{--TODO:apikeyをgithubから消す--}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZowbweHM-maatrVX4XYk0z9P6nVCU9KU&callback=initMap" type="text/javascript"></script>
@endsection