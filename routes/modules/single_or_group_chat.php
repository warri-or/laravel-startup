<?php
/*==============================================Settings===============================================*/
Route::get('sog-messaging','Sog\SogChatController@messagingSog')->name('messagingSog');
Route::get('sog-get-event-message/{event_type}/{load_type}','Sog\SogChatController@getEventMessagesSog')->name('getEventMessagesSog');
Route::post('sog-get-all-message-list','Sog\SogChatController@getAllMessageListSog')->name('getAllMessageListSog');
Route::post('sog-show-message-details','Sog\SogChatController@showMessageDetailsSog')->name('showMessageDetailsSog');

Route::post('sog-load-message-by-scroll','Messaging\MessagingController@loadMessagesByScrollSog')->name('loadMessagesByScrollSog');
Route::post('sog-send-message','Messaging\MessagingController@sendMessageSog')->name('sendMessageSog');
