@extends('layouts.app')
@section('content')
    @php
        $detail_info = json_decode($concert->detail_info);
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
                        <p>ライブ日程：{{ $detail_info->concert_date }} </p>
                        <p>開催時間：{{ $detail_info->start_time ?? ''}}
                            ~ {{ $detail_info->end_time ?? ''}}</p>
                        <p>ライブ会場：{{ $detail_info->place_name ?? ''}}</p>
                        <p>最寄駅：{{ $detail_info->place_station ?? ''}}</p>
                        <p>ジャンル：{{ $detail_info->music_type }}</p>
                        <p>チャージ：{{ $detail_info->concert_money }}</p>
                        <p>会場住所：{{ $detail_info->place_address ?? ''}}</p>
                        <p>URL：{{ $detail_info->place_url ?? ''}}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="detail-introduction">
                        <label for="title">ライブ自由紹介</label>
                        <p>{!! nl2br(e($detail_info->concert_introduction)) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection