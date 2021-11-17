<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'Web\Auth\AuthController@login')->name('home');

Route::post('show-category-menu-to-web', 'Web\FrontEnd\HomeController@showCategoryMenuToWeb')->name('showCategoryMenuToWeb');

Route::get('contact', function (){
    return view('web.contact');
})->name('contact');






Route::get('faqs', function (){
    return view('web.faqs');
})->name('faqs');

Route::get('about-us', function (){
    return view('web.about_us');
})->name('aboutUs');


/**************** Profile *************************/
Route::get('sign-in/{type?}', 'Web\Auth\AuthController@userLogin')->name('userLogin');
Route::post('sing-in-post', 'Web\Auth\AuthController@postUserLogin')->name('postUserLogin');
Route::post('login-modal-post', 'Web\Auth\AuthController@postLoginModal')->name('postLoginModal');
Route::get('register/{type?}', 'Web\Auth\AuthController@userRegister')->name('userRegister');
Route::post('registration-save', 'Web\Auth\AuthController@userRegistrationSave')->name('userRegistrationSave');
Route::post('registration-modal-save', 'Web\Auth\AuthController@userRegistrationModal')->name('userRegistrationModal');
Route::get('user-verify-email/{code}', 'Web\Auth\AuthController@userVerifyEmail')->name('userVerifyEmail');
Route::get('user-logout', 'Web\Auth\AuthController@userLogOut')->name('userLogOut');

Route::get('auth/{driver}', 'Web\Auth\SocialLoginController@redirectToProvider')->name('socialLogin');
Route::get('auth/{driver}/callback', 'Web\Auth\SocialLoginController@handleProviderCallback');

Route::post('live-charge-payment-by-stripe', 'Web\Payment\StripeController@liveChargePaymentByStripe')->name('liveChargePaymentByStripe');
Route::post('live-charge-payment-by-brain-tree', 'Web\Payment\BrainTreeController@liveChargePaymentByBrainTree')->name('liveChargePaymentByBrainTree');
Route::post('live-charge-payment-by-paypal', 'Web\Payment\PaypalController@liveChargePaymentByPaypal')->name('liveChargePaymentByPaypal');
Route::get('live-charge-paypal-payment-cancel', 'Web\Payment\PaypalController@cancelPaypalPayment')->name('cancelLiveChargePaypalPayment');
Route::get('live-charge-paypal-payment-success', 'Web\Payment\PaypalController@successPaypalPayment')->name('successLiveChargePaypalPayment');

Route::post('load-auction-payment-body','Web\Payment\PaymentController@loadAuctionPaymentBody')->name('loadAuctionPaymentBody');
Route::post('live-charge-payment-with-btc-balance','Web\Payment\CoinPaymentController@liveChargePaymentWithBtcBalance')->name('liveChargePaymentWithBtcBalance');
Route::post('product-purchase-payment-with-btc-balance','Web\Payment\CoinPaymentController@productPurchasePaymentWithBtcBalance')->name('productPurchasePaymentWithBtcBalance');
Route::post('generate-coin-payment-address','Web\Payment\CoinPaymentController@generateCoinPaymentAddress')->name('generateCoinPaymentAddress');
Route::post('covert-price-to-btc-price','Web\Payment\CoinPaymentController@convertPriceToBtcPrice')->name('convertPriceToBtcPrice');
Route::post('user-btc-balance-update','Web\Payment\CoinPaymentController@userBtcBalanceUpdate')->name('userBtcBalanceUpdate');


Route::post('load-product-purchase-payment-body', 'Web\Payment\PaymentController@loadProductPurchasePaymentBody')->name('loadProductPurchasePaymentBody');
Route::post('product-purchase-payment-by-stripe', 'Web\Payment\StripeController@productPurchasePaymentByStripe')->name('productPurchasePaymentByStripe');
Route::post('product-purchase-payment-by-brain-tree', 'Web\Payment\BrainTreeController@productPurchasePaymentByBrainTree')->name('productPurchasePaymentByBrainTree');
Route::post('product-purchase-payment-by-paypal', 'Web\Payment\PaypalController@productPurchasePaymentByPaypal')->name('productPurchasePaymentByPaypal');
Route::get('product-purchase-paypal-payment-cancel', 'Web\Payment\PaypalController@cancelProductPurchasePaypalPayment')->name('cancelProductPurchasePaypalPayment');
Route::get('product-purchase-paypal-payment-success', 'Web\Payment\PaypalController@successProductPurchasePaypalPayment')->name('successProductPurchasePaypalPayment');

