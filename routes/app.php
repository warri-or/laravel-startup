<?php

use Illuminate\Support\Facades\Route;

Route::get('set-language/{code}', 'HomeController@setLang')->name('setLang');

Route::group(['prefix' => 'admin'], function () {
    Route::get('permission-denied', 'Web\Admin\DashboardController@permissionDenied')->name('permissionDenied');
    Route::get('profile', 'Web\Admin\Profile\ProfileController@index')->name('profile');
    Route::post('update-profile', 'Web\Admin\Profile\ProfileController@updateProfile')->name('updateProfile');
    Route::post('update-password', 'Web\Admin\Profile\ProfileController@updatePassword')->name('updatePassword');
    Route::post('update-user-avatar', 'Web\Admin\Profile\ProfileController@userAvatarUpdate')->name('userAvatarUpdate');

    Route::get('payment-option', 'Web\Admin\Profile\PaymentOptionController@index')->name('paymentOption');
    Route::post('payment-option-edit', 'Web\Admin\Profile\PaymentOptionController@edit')->name('editPaymentOption');
    Route::post('payment-option-save', 'Web\Admin\Profile\PaymentOptionController@store')->name('storePaymentOption');
    Route::post('payment-option-delete', 'Web\Admin\Profile\PaymentOptionController@delete')->name('deletePaymentOption');

    Route::post('user-payment-option-change', 'Web\Admin\Profile\PaymentOptionController@userPaymentStatusChange')->name('userPaymentStatusChange');

    Route::get('order', 'Web\Admin\Settings\SettingsController@order')->name('order');

});

Route::post('load-auction-message-by-scroll','Web\Admin\Messaging\MessagingController@loadAuctionMessagesByScroll')->name('loadAuctionMessagesByScroll');
Route::get('generate-coin-payment-address', 'Web\Payment\CoinPaymentController@generateCoinPaymentAddress')->name('generateCoinPaymentAddress');
Route::get('product-purchase-payment-by-btc', 'Web\Payment\CoinPaymentController@productPurchasePaymentByBtc')->name('productPurchasePaymentByBtc');


