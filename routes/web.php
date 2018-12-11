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

/* 認証用のルート作成 */
Auth::routes();
/*
// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/

/* トップページ */
Route::get('/', 'TopController@index')->name('top');
Route::get('/about', 'TopController@showAbout')->name('about');
Route::get('/detail/{id}', 'TopController@showDetail')->where('id', '[1-9][0-9]*')->name('detail');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

/* 検索ページ */
Route::get('/search', 'SearchController@search');
Route::post('/search', 'SearchController@search');

/* マイページ */
Route::prefix('/mypage')->group(function () {
    Route::get('/', 'MypageController@index')->name('mypage');
    Route::post('/create', 'MypageController@createConcert');
    Route::get('/update/{concertId}', 'MypageController@showUpdate')->where('id', '[1-9][0-9]*');
    Route::post('/update/{concertId}', 'MypageController@updateConcert')->where('id', '[1-9][0-9]*');
    Route::get('/delete/{concertId}', 'MypageController@deleteConcert')->where('id', '[1-9][0-9]*');
});

/* SNS */
Route::get('/twitter', 'TwitterController@tweet');
