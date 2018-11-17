@extends('layouts.app')
@section('content')
    @php
        $detail_info = json_decode($concert->detail_info);
    @endphp
    <div class="detail-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">{{ $detail_info->concert_name }}</h1>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ asset('storage/images/'.$detail_info->concert_img) }}" style="width: 100%;">
                </div>
                <div class="col-md-7">
                    <h2>{{ $detail_info->band_name }}</h2>
                    <p>メンバー：{{ $detail_info->band_member }}</p>
                    <p>ジャンル：{{ $detail_info->music_type }}</p>
                    <p>チャージ：{{ $detail_info->concert_money }}</p>
                    <p>開催日：{{ $detail_info->concert_date }}</p>
                    <p>開始時間：{{ $detail_info->start_time ?? ''}}</p>
                    <p>終了時間：{{ $detail_info->end_time ?? ''}}</p>
                    <p>会場名：{{ $detail_info->place_name ?? ''}}</p>
                    <p>会場最寄駅：{{ $detail_info->place_station ?? ''}}</p>
                    <p>会場住所：{{ $detail_info->place_address ?? ''}}</p>
                    <p>会場URL：{{ $detail_info->place_url ?? ''}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>【ライブ紹介文】</p>
                    <p>{{ $detail_info->concert_introduction }}</p>
                </div>
            </div>
        </div>

@endsection