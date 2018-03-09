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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', function () {
    return redirect()->to('/rooms');
});



Route::get('/home', function () {
    return redirect()->to('/rooms');
})->name('home');
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('refresh_captcha', 'Auth\LoginController@refreshCaptcha')->name('refresh_captcha');

Route::get('/rooms', 'RoomController@index')->name('rooms');
Route::get('/rooms/new', 'RoomController@newRoomGet')->name('rooms.new');
Route::post('/rooms/new', 'RoomController@newRoomPost');
Route::get('/rooms/{id}/delete', 'RoomController@deleteGet')->name('rooms.delete')->where('id', '[0-9]+');
Route::post('/rooms/{id}/delete', 'RoomController@deletePost')->where('id', '[0-9]+');

Route::get('rooms/{id}/vote', 'VoteController@vote')->name('rooms.vote')->where('id', '[0-9]+');

Route::group(['prefix' => 'ajax'], function () {
    Route::get('/rooms/{id}/voteData', 'VoteController@voteDataGet')->where('id', '[0-9]+');
    Route::post('/rooms/{id}/voteData', 'VoteController@voteDataPost')->where('id', '[0-9]+');
    Route::post('/rooms/{id}/clear', 'VoteController@clearVotesDataPost')->where('id', '[0-9]+');
});

