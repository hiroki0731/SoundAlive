<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* トップページ */
Route::get('/', function () {
    return view('top');
});

/* ログイン */
Route::get('/login', 'LoginController@index');

/* 新規登録 */
Route::get('/register', 'RegisterController@index');
Route::post('/register', 'RegisterController@postRegister');