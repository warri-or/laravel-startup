<?php
Route::get('admin-home', 'Web\Admin\DashboardController@index')->name('adminHome');

/*==============================================Users===============================================*/
Route::get('users', 'Web\Admin\User\UserController@users')->name('users');
Route::post('user-save', 'Web\Admin\User\UserController@saveUser')->name('saveUser');
Route::post('user-edit', 'Web\Admin\User\UserController@editUser')->name('editUser');
Route::post('user-delete', 'Web\Admin\User\UserController@delete')->name('deleteUser');
Route::post('user-slug-check','Web\Admin\User\UserController@userSlugCheck')->name('userSlugCheck');

Route::get('user-details/{user_id}','Web\Admin\User\UserController@userDetails')->name('userDetails');

Route::post('verify-user','Web\Admin\User\UserController@verifyUser')->name('verifyUser');
Route::post('user-status-change','Web\Admin\User\UserController@userStatusChange')->name('userStatusChange');
/*==============================================Users===============================================*/

Route::get('sellers', 'Web\Admin\User\UserController@sellers')->name('sellers');
Route::post('seller-save', 'Web\Admin\User\UserController@saveSeller')->name('saveSeller');
Route::post('seller-edit', 'Web\Admin\User\UserController@editSeller')->name('editSeller');
Route::post('seller-approve', 'Web\Admin\User\UserController@approveSeller')->name('approveSeller');

Route::get('bidders', 'Web\Admin\User\UserController@bidders')->name('bidders');
Route::post('bidder-save', 'Web\Admin\User\UserController@saveBidder')->name('saveBidder');
Route::post('bidder-edit', 'Web\Admin\User\UserController@editBidder')->name('editBidder');

/*==============================================User Brands=======================================*/
// Logs
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('adminLogs');

Route::get('test-notification', 'HomeController@triggerTestNotification')->name('triggerTestNotification');



