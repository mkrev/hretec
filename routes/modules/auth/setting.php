<?php
Route::group(['namespace' => 'Settings'], function () {
    Route::patch('settings/profile', 'ProfileController@update')->middleware('formdata');
    Route::patch('settings/password', 'PasswordController@update');
});
