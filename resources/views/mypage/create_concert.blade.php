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
                <input class="col-sm-10" name="music_type" type="text" placeholder="例) ロック、ジャズ、シャンソン、など" value="{{old('music_type')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場名</label>
                <input class="col-sm-10" name="place_name" type="text" placeholder="例) ライブハウス○○" value="{{old('place_name')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場最寄駅</label>
                <div class="col-sm-10" style="text-align: left">
                    <select name="pref" onChange="setMenuItem(false, this[this.selectedIndex].value)">
                        <option value="0" selected>都道府県を選択
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
                    <select name="line" onChange="setMenuItem(true, this[this.selectedIndex].value)">
                        <option selected>路線を選択
                    </select>
                    <select name="station">
                        <option selected>駅を選択
                    </select>
                </div>
            </div>

            <div class="row concertInput">
                <label class="col-sm-2">会場HP</label>
                <input class="col-sm-10" name="place_url" type="text" placeholder="例) http://sample.concert.place.com" value="{{old('place_url')}}">
            </div>
            <br>

            <p>※以下にライブ会場の住所を正しく入力すると、マップにピンが立って検索されやすくなります。</p>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>会場住所</label>
                <input class="col-sm-10" name="place_address" type="text" placeholder="例) 神奈川県横浜市港北区テスト町1-1-1" value="{{old('place_address')}}">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブ画像</label>
                <input name="concert_img" type="file">
            </div>

            <div class="row concertInput">
                <label class="col-sm-2"><i class="far fa-star"></i>ライブ説明</label>
                <textarea class="col-sm-10" name="concert_introduction"
                          placeholder="例) ライブを自由に紹介してください。(最大500文字以内)" maxlength="500">{{old('concert_introduction')}}</textarea>
            </div>

            <input type="submit" value="登録">
        </form>
    </div>
</div>
