<div class="card">
    <div class="card-header">ライブ新規作成</div>

    <div class="card-body">
        <p>※星マークの欄は入力が必須です。</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form name="concertForm" class="createForm" enctype="multipart/form-data" action="/mypage/create" method="post">
            {{ csrf_field() }}

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブタイトル</label>
                <input class="col-sm-10" name="concert_name" type="text"
                       placeholder="例) 必見！○○バンド東京初ワンマン！(キャッチコピーと考えてください)" value="{{old('concert_name')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>バンド名</label>
                <input class="col-sm-10" name="band_name" type="text" placeholder="例) 高田大輝TORIO" value="{{old('band_name')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>メンバー</label>
                <input class="col-sm-10" name="band_member" type="text"
                       placeholder="例) 高田大輝 (pf), 辰巳浩之 (dr), 牛山健太郎 (bs)" value="{{old('band_member')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブ日付</label>
                <input class="col-sm-10" name="concert_date" type="date" value="{{old('concert_date')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>開始時間</label>
                <input class="col-sm-10" name="start_time" type="time" value="{{old('start_time')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>終了時間</label>
                <input class="col-sm-10" name="end_time" type="time" value="{{old('end_time')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>チャージ料金</label>
                <input class="col-sm-10" name="concert_money" type="text" placeholder="例) 3,500円(税込)" value="{{old('concert_money')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>音楽ジャンル</label>
                <select class="col-sm-10" name="music_type" id="music_type">
                    <option value="" selected>一番近いジャンルを選択</option>
                    @foreach(Helper::getMusicType() as $key => $val)
                        <option value={{ $key }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場名</label>
                <input class="col-sm-10" name="place_name" type="text" placeholder="例) ライブハウス○○" value="{{old('place_name')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場最寄駅</label>
                <div class="col-sm-10" style="text-align: left">
                    <select name="pref" id="pref" onChange="setMenuItem(false, this[this.selectedIndex].value)">
                        <option value="0" selected>都道府県を選択</option>
                        @foreach(Helper::getPref() as $key => $val)
                            <option value={{ $key }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <select name="line" id="line" onChange="setMenuItem(true, this[this.selectedIndex].value)">
                        <option selected>路線を選択
                    </select>
                    <select name="station" id="station">
                        <option selected>駅を選択
                    </select>
                </div>
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">会場HP</label>
                <input class="col-sm-10" name="place_url" type="text" placeholder="例) http://sample.concert.place.com" value="{{old('place_url')}}">
            </div>
            <br>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場住所</label>
                <input class="col-sm-10" name="place_address" type="text" placeholder="例) 神奈川県横浜市港北区テスト町1-1-1" value="{{old('place_address')}}">
            </div>
            <p>※ライブ会場の住所を正しく入力すると、アクセスマップにピンが立って検索されやすくなります。</p>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブ画像</label>
                <input name="concert_img" type="file">
            </div>
            <p>※画像は最大1MB、出来れば横長の画像にしてください。画像軽量化は<a href="https://tinypng.com/">こちらのサイト</a>から簡単にできます。</p>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>YouTube</label>
                <input class="col-sm-10" name="movie_id" type="text" placeholder="任意でYouTube動画リンクを入力。例)https://www.youtube.com/watch?v=ZpbkJTdgVzA">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブ説明</label>
                <textarea class="col-sm-10" name="concert_introduction"
                          placeholder="例) ライブを自由に紹介してください。(最大500文字以内)" maxlength="500">{{old('concert_introduction')}}</textarea>
            </div>

            <input type="submit" value="登録" @click.prevent="popupToggle()">

            <div class="modal-back" :style="popupOpacity">
                <div class="modal-panel">
                    <div class="modal-panel-content">
                        <h3>このライブをSoundAlive公式SNSに投稿できます！</h3>
                        <p>あなたのライブを公式SNSへ投稿しても宜しいですか？<br>(公式SNS投稿は1ライブ1回のみになります)</p>
                        <p>※ライブタイトルとライブ紹介画像が告知内容に使用されます</p>
                        <button type="submit" name="sns" value="true"><i class="fab fa-twitter-square"></i> <i class="fab fa-facebook-square"></i> はい、公式SNSで告知します</button>
                        <br>
                        <button type="submit" name="sns" value="false">いいえ、公式SNSで告知しません</button>
                        <br>
                        <button type="button" @click="closePopup()">キャンセルして編集する</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
