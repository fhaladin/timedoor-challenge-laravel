<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth.admin')->group(function() {
    Route::get('', 'Admin\DashboardController@index')->name('admin.index');
    Route::delete('{id}', 'Admin\DashboardController@destroy')->name('admin.post.destroy');
    Route::delete('image/{id}', 'Admin\DashboardController@delete_image')->name('admin.image.destroy');
    Route::post('restore/{id}', 'Admin\DashboardController@restore')->name('admin.post.restore');
    Route::post('modal', 'Admin\DashboardController@modal')->name('admin.modal');
    Route::post('table/{search?}', 'Admin\DashboardController@table')->name('admin.table');
});

Route::get('login', 'Admin\AuthController@login_page')->name('admin.login.page');
Route::post('login', 'Admin\AuthController@login')->name('admin.login');