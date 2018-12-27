<div class="card">
    <div class="card-header">ユーザ名変更</div>

    <div class="card-body">
        <form action="/mypage/change" method="post">
            {{ csrf_field() }}

            <p>現在のユーザ名は{{ $userName }}です。</p>

            <div class="row concertInput">
                <label class="col-sm-2">新ユーザ名</label>
                <input class="col-sm-9" name="new_user_name" type="text"
                       placeholder="新しいユーザ名" value="{{old('new_user_name')}}">
            </div>
            @if($errors->has('new_user_name'))
                <p class="alert alert-danger">{{ $errors->first('new_user_name') }}</p>
            @endif

            <input type="submit" value="変更する">
        </form>
    </div>

    @if(Session::has('name_changed'))
        <script type="text/javascript">
            alert('名前変更が完了しました');
        </script>
    @endif
</div>
