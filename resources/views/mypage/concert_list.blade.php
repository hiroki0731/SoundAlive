<div class="card">
    <div class="card-header">ライブ・イベント一覧</div>

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
            <div class="mypage-concert-list-wrapper" @click="moveToDetail({{ $concert->id }})">
                <div class="row mypage-concert-list pointer">
                    <div class="col-md-3 icon-img">
                        <img src={{ asset($detail_info->concert_img ?? '/img/no_image.png') }} style="width:100%">
                    </div>
                    <div class="col-md-9">
                        <p>タイトル：{{ $detail_info->concert_name }}</p>
                        <p>アーティスト名：{{ $detail_info->band_name }}</p>
                        <p>開催日付：{{ Helper::formatConcertDate($detail_info->concert_date) }}</p>
                        <a href="/mypage/update/{{ $concert->id }}"><i class="fas fa-pencil-alt"></i> 編集する</a>
                        <a href="/mypage/delete/{{ $concert->id }}"><i class="far fa-trash-alt"></i> 削除する</a>
                    </div>
                </div>
            </div>
        @endforeach
        <p>{{ $concerts->links() }}</p>

        @if (empty($concerts) || count($concerts) === 0)
            <p>ライブ・イベントが登録されていません。</p>
            <p>左のメニューから「ライブ・イベント新規作成」を選び、新しく登録しましょう！</p>
        @endif
    </div>
</div>
