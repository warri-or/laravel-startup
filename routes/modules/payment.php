<?php

Route::post('payment-by-stripe', 'Payment\StripeController@liveChargePaymentByStripe')->name('paymentByStripe');
Route::post('payment-by-brain-tree', 'Payment\BrainTreeController@liveChargePaymentByBrainTree')->name('paymentByBrainTree');
Route::post('payment-by-paypal', 'Payment\PaypalController@liveChargePaymentByPaypal')->name('paymentByPaypal');
Route::get('paypal-payment-cancel', 'Payment\PaypalController@cancelPaypalPayment')->name('cancelPaypalPayment');
Route::get('paypal-payment-success', 'Payment\PaypalController@successPaypalPayment')->name('successPaypalPayment');

Route::get('payment-complete/{status}', 'Payment\Payment@paymentComplete')->name('paymentComplete');

Route::post('payment-with-btc-balance','Payment\CoinPaymentController@paymentWithBtcBalance')->name('paymentWithBtcBalance');
Route::post('generate-coin-payment-address','Payment\CoinPaymentController@generateCoinPaymentAddress')->name('generateCoinPaymentAddress');
Route::post('covert-price-to-btc-price','Payment\CoinPaymentController@convertPriceToBtcPrice')->name('convertPriceToBtcPrice');
Route::post('user-btc-balance-update','Payment\CoinPaymentController@userBtcBalanceUpdate')->name('userBtcBalanceUpdate');




