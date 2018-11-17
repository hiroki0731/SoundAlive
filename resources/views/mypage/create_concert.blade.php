<div class="card">
    <div class="card-header">ライブ新規作成</div>

    <div class="card-body">
        <p>※星マークの欄は入力が必須です。</p>

        <form name="concertForm" enctype="multipart/form-data" action="/mypage/create" method="post">
            {{ csrf_field() }}

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブタイトル</label>
                <input class="col-sm-10" name="concert_name" type="text" placeholder="例) 必見！○○バンド東京初ワンマン！(キャッチコピーと考えてください)">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">バンド名</label>
                <input class="col-sm-10" name="band_name" type="text" placeholder="例) 高田大輝TORIO">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">メンバー</label>
                <input class="col-sm-10" name="band_member" type="text"
                       placeholder="例) 高田大輝 (pf), 辰巳浩之 (dr), 牛山健太郎 (bs)">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>日付</label>
                <input class="col-sm-10" name="concert_date" type="date">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>開始時間</label>
                <input class="col-sm-10" name="start_time" type="time">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>終了時間</label>
                <input class="col-sm-10" name="end_time" type="time">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>チャージ料金</label>
                <input class="col-sm-10" name="concert_money" type="text" placeholder="例) 3,500円(税込)">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>音楽ジャンル</label>
                <input class="col-sm-10" name="music_type" type="text" placeholder="例) ロック、ジャズ">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場名</label>
                <input class="col-sm-10" name="place_name" type="text" placeholder="例) ライブハウス○○">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場最寄駅</label>
                <input class="col-sm-10" name="place_station" type="text" placeholder="例) 渋谷駅">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">会場HP</label>
                <input class="col-sm-10" name="place_url" type="text" placeholder="例) http://sample.concert.place.com">
            </div>
            <br>

            <p>※以下にライブ会場の住所を正しく入力すると、マップにピンが立って検索されやすくなります。</p>

            <div class="row concertInput">
                <label class="col-sm-2">会場住所</label>
                <input class="col-sm-10" name="place_address" type="text" placeholder="例) 神奈川県横浜市港北区テスト町1-1-1">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">ライブ紹介画像</label>
                <input name="concert_img" type="file">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">自由紹介文</label>
                <textarea class="col-sm-10" name="concert_introduction" placeholder="例) ライブを自由に紹介してください。(200文字以内)"></textarea>
            </div>

            <input type="submit" value="登録">
        </form>
    </div>
</div>
