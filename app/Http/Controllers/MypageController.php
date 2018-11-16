<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ライブ検索一覧画面を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect('/');
        }

        // TODO: ユーザーIDをキーにしてコンサートテーブルの情報を取得してviewに渡す
        $userId = Auth::user()->id;
        $userName = Auth::user()->name ?? 'NoName';

        return view('mypage/mypage')->with('userName' , $userName);
    }


    public function createConcert()
    {
        dd(Input::all());
    }
}
