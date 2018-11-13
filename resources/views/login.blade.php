@extends('layouts.base')
@section('main')
    <div class="login-wrapper">
        <div class="container">
            <p>ログイン</p>
            <form action="">
                {{ csrf_field() }}

                <p>ユーザー名</p>
                <input class="userinput" type="text" name="name" placeholder="ユーザー名を入力してください">
                <p>パスワード</p>
                <input class="userinput" type="text" name="password" placeholder="パスワードを入力してください">
                <br>
                <input class="submit-btn" type="submit" value="ログイン">
            </form>
        </div>
    </div>
@endsection