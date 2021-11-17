<?php
use Illuminate\Support\Facades\Route;


Route::get('login', 'Web\Auth\AuthController@login')->name('login');
Route::post('post-login', 'Web\Auth\AuthController@postLogin')->name('postLogin');

Route::get('forget-password', 'Web\Auth\AuthController@forgetPassword')->name('forgetPassword');
Route::post('send-forget-password-mail', 'Web\Auth\AuthController@sendForgetPasswordMail')->name('sendForgetPasswordMail');
Route::get('reset-password/{token}', 'Web\Auth\AuthController@resetPassword')->name('resetPassword');
Route::post('change-password', 'Web\Auth\AuthController@changePassword')->name('changePassword');
Route::get('logout', 'Web\Auth\AuthController@logout')->name('logout');
