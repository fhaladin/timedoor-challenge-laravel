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

Route::post('post/restore/{id}', 'PostController@restore')->name('post.restore');
Route::post('post/password_check/{id}', 'PostController@password_check')->name('password_check');
Route::delete('post/delete_image/{id}/{redirect}', 'PostController@delete_image')->name('delete_image');
Route::resource('post', 'PostController', [
    'only' => ['index', 'store', 'update', 'destroy']
])->middleware('verified.login');

Route::prefix('admin')->group(function() {
    Route::get('', 'AdminController@index')->name('admin.index');
    Route::post('modal', 'AdminController@modal')->name('admin.modal');
    Route::post('login', 'AdminController@login')->name('admin.login');
    Route::post('table/{search?}', 'AdminController@table')->name('admin.table');
});

Auth::routes(['verify' => true]);