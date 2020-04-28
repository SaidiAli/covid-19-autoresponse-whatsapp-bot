<?php

use App\Http\Controllers\OutBoundMessageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'OutBoundMessageController@index')->middleware('custom.auth');
Route::get('/updates', 'OutBoundMessageController@updates');
Route::get('/news', 'OutBoundMessageController@news');
Route::post('/', 'InBoundMessageController@index');
Route::post('/send-message', 'OutBoundMessageController@send');

// Auth routes
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login')->name('login');
Route::get('/register', 'RegisterController@index');
Route::post('/register', 'RegisterController@register')->name('register');
Route::get('/logout', 'LoginController@logout')->name('logout');
