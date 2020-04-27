<?php

Route::name('admin.')->group(function() {
    Route::middleware('auth.admin')->group(function() {
        Route::get('', 'DashboardController@index')->name('index');
        Route::delete('{id}', 'DashboardController@destroy')->name('post.destroy');
        Route::delete('image/{id}', 'DashboardController@deleteImage')->name('image.destroy');
        Route::post('restore/{id}', 'DashboardController@restore')->name('post.restore');
        Route::post('modal', 'DashboardController@modal')->name('modal');
        Route::post('table/{search?}', 'DashboardController@table')->name('table');
    });
    
    Route::get('login', 'AuthController@loginPage')->name('login.page');
    Route::post('login', 'AuthController@login')->name('login');
});