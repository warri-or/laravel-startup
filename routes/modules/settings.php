<?php
/*==============================================Settings===============================================*/
Route::get('site-settings','Settings\SettingsController@siteSetting')->name('siteSetting');
Route::get('payment-settings','Settings\SettingsController@paymentSettings')->name('paymentSettings');
Route::get('admin-payment-settings-save','Settings\SettingsController@paymentSettingSave')->name('paymentSettingSave');

Route::get('coin-payment-settings','Settings\SettingsController@coinPaymentSettings')->name('coinPaymentSettings');
Route::get('coin-payment-settings-save','Settings\SettingsController@coinPaymentSettingSave')->name('coinPaymentSettingSave');

Route::get('logo-settings','Settings\SettingsController@logoSetting')->name('logoSetting');
Route::get('social-settings','Settings\SettingsController@socialSetting')->name('socialSetting');
Route::get('application-settings','Settings\SettingsController@applicationSetting')->name('applicationSetting');
Route::get('commission-rate-settings','Settings\SettingsController@commissionRateSettings')->name('commissionRateSettings');
Route::get('language-settings','Settings\SettingsController@languageSettings')->name('languageSettings');
Route::get('sync-language-list','Settings\SettingsController@syncLanguageList')->name('syncLanguageList');
Route::get('social-login-setting','Settings\SettingsController@socialLoginSettings')->name('socialLoginSettings');
Route::get('email-setting','Settings\SettingsController@emailSettings')->name('emailSettings');

Route::post('admin-settings-save','Settings\SettingsController@adminSettingsSave')->name('adminSettingsSave');
Route::get('commands-settings','Settings\SettingsController@commandSettings')->name('commandSettings');
Route::post('runCommand','Settings\SettingsController@runCommand')->name('runCommand');

Route::post('create-command','Settings\SettingsController@createCommand')->name('createCommand');

Route::get('terms-condition-settings','Settings\SettingsController@termsConditionSettings')->name('termsConditionSettings');
Route::get('privacy-policy-settings','Settings\SettingsController@privacyPolicySettings')->name('privacyPolicySettings');
Route::get('about-us-settings','Settings\SettingsController@aboutUsSettings')->name('aboutUsSettings');
Route::get('help-center-settings','Settings\SettingsController@helpCenterSettings')->name('helpCenterSettings');
Route::get('why-choose-us-settings','Settings\SettingsController@whyChooseUsSettings')->name('whyChooseUsSettings');

Route::get('faqs-settings','Settings\SettingsController@faqsSettings')->name('faqsSettings');
Route::post('faqs-setting-save','Settings\SettingsController@faqsSettingSave')->name('faqsSettingSave');
Route::post('faqs-item-delete','Settings\SettingsController@deleteFaqsItem')->name('deleteFaqsItem');
Route::post('faqs-item-by-id','Settings\SettingsController@getFaqItemById')->name('getFaqItemById');


/*==============================================Settings===============================================*/

/*==============================================Roles && Permissions=======================================*/
Route::get('roles', 'Role\RolePermissionController@index')->name('roles');
Route::post('role-save', 'Role\RolePermissionController@saveRole')->name('saveRole');
Route::post('role-edit', 'Role\RolePermissionController@editRole')->name('editRole');
Route::post('role-delete', 'Role\RolePermissionController@delete')->name('deleteRole');
Route::get('update-routing-list','Role\RouteController@updateRouteList')->name('updateRouteList');
Route::post('get-routes-by-type','Role\RouteController@getRouteByType')->name('getRouteByType');
Route::post('get-module-by-id','Role\RolePermissionController@getModulesById')->name('getModulesById');
Route::post('get-module-by-role','Role\RolePermissionController@getModuleByRole')->name('getModuleByRole');

Route::post('get-route-list-by-module-id','Role\RolePermissionController@getRouteListByModuleId')->name('getRouteListByModuleId');
Route::post('update-route-name','Role\RouteController@updateRouteName')->name('updateRouteName');

Route::post('update-role-routes','Role\RolePermissionController@updateRoleRoute')->name('updateRoleRoute');
/*==============================================Roles && Permissions=======================================*/



