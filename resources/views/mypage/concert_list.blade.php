<div class="card">
    <div class="card-header">ライブ一覧</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @foreach($concerts as $concert)
            <?php $detail_info = json_decode($concert->detail_info) ?>
            <div class="mypage-concert-list">
                <div class="row">
                    <div class="col-md-3">
                        <img src={{ asset('public/storage/concert_images/'. $detail_info->concert_img) }} />
                    </div>
                    <div class="col-md-9" style="float:left">
                        <p>{{ $detail_info->concert_name }}</p>
                        <p>{{ $detail_info->band_name }}</p>
                        <p>{{ $detail_info->concert_date }}</p>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
