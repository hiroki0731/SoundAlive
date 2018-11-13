@extends('layouts.base')
@section('main')
    <div class="login-wrapper">
        <div class="container">
            <p>新規登録</p>
            <form action="/register" method="post">
                {{ csrf_field() }}

                <p>ユーザー名</p>
                <input class="userinput" type="text" name="name" placeholder="任意のユーザー名を入力してください">
                <p>メールアドレス</p>
                <input class="userinput" type="text" name="email" placeholder="メールアドレスを入力してください">
                <p>パスワード</p>
                <input class="userinput" type="text" name="password" placeholder="パスワードを入力してください">
                <p>パスワード再入力</p>
                <input class="userinput" type="text" name="re-password" placeholder="パスワードを再入力してください">
                <br>
                <input class="submit-btn" type="submit" value="登録">
            </form>
        </div>
    </div>
@endsection