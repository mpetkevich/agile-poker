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

Route::get('/rooms', 'RoomController@index')->name('rooms');
Route::get('rooms/{id}/vote', 'RoomController@vote')->name('rooms.vote')->where('id', '[0-9]+');
Route::get('refresh_captcha', 'Auth\LoginController@refreshCaptcha')->name('refresh_captcha');

Route::group(['prefix' => 'ajax'], function () {
    Route::get('/rooms/{id}/voteData', 'RoomController@voteDataGet')->where('id', '[0-9]+');
    Route::post('/rooms/{id}/voteData', 'RoomController@voteDataPost')->where('id', '[0-9]+');
});

