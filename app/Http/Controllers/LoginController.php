<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ユーザーの作成・更新
 *
 * Class RegisterController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /**
     * 新規登録ページを表示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('login');
    }

}
