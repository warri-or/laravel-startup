<?php
use Illuminate\Support\Facades\Route;

Route::get('super-admin-home', 'Web\Admin\SuperAdmin\DashboardController@index')->name('superAdminHome');
Route::get('hello-get', 'Web\Admin\SuperAdmin\DashboardController@helloGet')->name('helloGet');





