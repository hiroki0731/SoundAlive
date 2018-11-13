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

/* ログイン・新規登録 */
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


/* マイページ */
Route::get('/mypage', 'MypageController@index')->name('mypage');
