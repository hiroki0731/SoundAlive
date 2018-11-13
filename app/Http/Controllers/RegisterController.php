<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

/**
 * ユーザーの作成・更新
 *
 * Class RegisterController
 * @package App\Http\Controllers
 */
class RegisterController extends Controller
{
    /**
     * 新規登録ページを表示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('register');
    }

    /**
     * 新規ユーザ作成
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postRegister()
    {
        $input = Input::all();

        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();

        return view('/');
    }
}
