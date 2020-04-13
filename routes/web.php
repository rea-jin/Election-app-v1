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
// top ページ あとで作る
Route::get('/', 'ElectionsController@index')->name('elections');
// 一覧表示アクション
Route::get('/elections', 'ElectionsController@index')->name('elections');
// 退会用アクション
Route::delete('/elections', 'ElectionsController@delete')->name('elections.duser')->middleware('check');

// 新規登録表示アクション
Route::get('/elections/new', 'ElectionsController@new')->name('elections.new')->middleware('check');
// 登録アクション
Route::post('/elections/new', 'ElectionsController@create')->middleware('check');

// 編集アクション
Route::get('/elections/{id}/edit', 'ElectionsController@edit')->name('elections.edit')->middleware('check');
// 更新アクション
Route::put('/elections/{id}/edit', 'ElectionsController@update')->name('elections.update');
// 選挙開始アクション
Route::post('/elections/{id}/edit', 'ElectionsController@start')->name('elections.start')->middleware('check');

// 詳細アクション
Route::get('/elections/{id}/show', 'ElectionsController@show')->name('elections.show')->middleware('check');
// 投票アクション
Route::post('/elections/{id}/show', 'ElectionsController@vote')->name('elections.vote')->middleware('check');

// マイページアクション
Route::get('/elections/mypage', 'ElectionsController@mypage')->name('elections.mypage')->middleware('check');
// 削除用アクション idを指定する
Route::delete('/elections/{id}/delete', 'ElectionsController@destroy')->name('elections.delete')->middleware('check');
// 問い合わせ
Route::get('/elections/contact', 'ElectionsController@contact')->name('elections.contact');
Route::post('/elections/contact', 'ElectionsController@contact')->name('elections.contact');

Auth::routes();

// Route::get('/elections/mypage', 'ElectionsConroller@deleteData')->name('elections.contact')->middleware('check');
