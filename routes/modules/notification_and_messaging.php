<?php
/*==============================================Settings===============================================*/
Route::get('messaging','Messaging\MessagingController@messaging')->name('messaging');
Route::get('get-event-message/{event_type}/{load_type}','Messaging\MessagingController@getEventMessages')->name('getEventMessages');
Route::post('get-all-message-list','Messaging\MessagingController@getAllMessageList')->name('getAllMessageList');
Route::post('show-message-details','Messaging\MessagingController@showMessageDetails')->name('showMessageDetails');

Route::post('load-message-by-scroll','Messaging\MessagingController@loadMessagesByScroll')->name('loadMessagesByScroll');
Route::post('send-message','Messaging\MessagingController@sendMessage')->name('sendMessage');

Route::get('show-new-notifications', 'Notification\NotificationController@showNewNotification')->name('showNewNotification');
Route::get('clear-all-notifications', 'Notification\NotificationController@clearAllNotification')->name('clearAllNotification');
Route::post('make-notification-read', 'Notification\NotificationController@makeNotificationRead')->name('makeNotificationRead');
Route::get('view-all-notifications', 'Notification\NotificationController@viewAllNotifications')->name('viewAllNotifications');
Route::post('delete-notifications', 'Notification\NotificationController@deleteNotification')->name('deleteNotification');
