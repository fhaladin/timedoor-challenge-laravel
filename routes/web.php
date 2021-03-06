<?php

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

Route::get('/', function() {
    return redirect('post');
});

Route::post('post/password_check/{id}', 'User\PostController@password_check')->name('password_check');
Route::resource('post', 'User\PostController', [
    'only' => ['index', 'store', 'update', 'destroy']
])->middleware('verified.login');

Auth::routes(['verify' => true]);