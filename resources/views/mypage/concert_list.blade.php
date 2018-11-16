<div class="card">
    <div class="card-header">ライブ一覧</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @foreach($concerts as $concert)
            @php
                $detail_info = json_decode($concert->detail_info);
            @endphp
            <div class="mypage-concert-list-wrapper">
                <div class="row mypage-concert-list">
                    <div class="col-md-3">
                        <img src={{ asset('storage/images/'. $detail_info->concert_img) }} style="width:100%">
                    </div>
                    <div class="col-md-9">
                        <p>タイトル：{{ $detail_info->concert_name }}</p>
                        <p>バンド名：{{ $detail_info->band_name }}</p>
                        <p>開催日：{{ $detail_info->concert_date }}</p>
                        <a href="/mypage?id={{ $concert->id }}"><i class="fas fa-pencil-alt"></i> 編集する</a>
                    </div>
                </div>
            </div>
        @endforeach
            <p>{{ $concerts->links() }}</p>
    </div>
</div>
