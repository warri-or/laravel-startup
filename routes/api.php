<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','Api\Auth\AuthController@login');
Route::post('register','Api\Auth\AuthController@register');
Route::post('user-verify-email','Api\Auth\AuthController@userVerifyEmail')->name('userVerifyEmailApi');

Route::post('send-forget-password-mail', 'Api\Auth\AuthController@sendForgetPasswordMail')->name('sendForgetPasswordMail');
Route::post('reset-password', 'Api\Auth\AuthController@updatePassword')->name('updatePassword');

Route::get('category-list','Api\Auction\AuctionController@getCategoryList');
Route::any('auction-list/{type?}','Api\Auction\AuctionController@auctionList');
Route::any('auction-list-by-category/{category_id}','Api\Auction\AuctionController@auctionListByCategory');
Route::get('auction-details/{slug}','Api\Auction\AuctionController@auctionDetails');
Route::get('general-info','Api\HomeDeelerController@generalInfo');

Route::post('search-auction','Api\Auction\AuctionController@searchAuction')->name('searchAuction');
Route::post('live-auction-by-date','Api\Auction\AuctionController@liveAuctionByDate')->name('liveAuctionByDate');

Route::group(['middleware'=>'auth:api'],function (){
    Route::get('my-profile','Api\Profile\ProfileController@myProfile');
    Route::get('my-earnings','Api\Profile\ProfileController@myEarnings');
    Route::post('update-profile','Api\Profile\ProfileController@updateProfile');
    Route::post('update-profile-picture','Api\Profile\ProfileController@updateProfilePicture');
    Route::post('update-password','Api\Profile\ProfileController@updatePassword');
    Route::get('my-payment-options','Api\Profile\ProfileController@myPaymentOption');
    Route::post('add-payment-options','Api\Profile\ProfileController@addPaymentOption');

    Route::get('make-auction-favourite/{auction_id}','Api\Auction\AuctionController@makeAuctionFavourite');
    Route::post('bid','Api\Auction\AuctionController@bid');
    Route::get('my-favourite-list','Api\Auction\AuctionController@myFavouriteList');
    Route::get('my-active-bid','Api\Auction\AuctionController@myActiveBid');
    Route::get('my-expired-bid','Api\Auction\AuctionController@myExpiredBid');
    Route::get('my-winning-bid','Api\Auction\AuctionController@myWinningBid');

    Route::post('send-seller-request','Api\Auth\AuthController@sellerRequestSend');
    Route::get('my-auctions','Api\Auction\AuctionController@myAuctions');
    Route::get('my-auction-approved','Api\Auction\AuctionController@myAuctionApproved');
    Route::get('my-auction-pending','Api\Auction\AuctionController@myAuctionPending');
    Route::get('my-items-on-live','Api\Auction\AuctionController@myItemsOnLive');
    Route::get('my-items-sold','Api\Auction\AuctionController@myItemsSold');
    Route::get('payment-history','Api\Auction\AuctionController@paymentHistory');
    Route::get('logout','Api\Auth\AuthController@logOutApi');

    Route::post('send-live-auction-message','Api\MessageController@sendLiveAuctionMessage');

    Route::post('send-auction-message','Api\MessageController@sendAuctionMessage');
    Route::get('get-my-auction-message','Api\MessageController@getAuctionMessageList');
    Route::post('get-auction-message-details','Api\MessageController@getAuctionMessageDetails');

    Route::post('send-admin-message','Api\MessageController@sendAdminMessage');
    Route::get('get-my-admin-message','Api\MessageController@getAdminMessageList');
    Route::post('get-admin-message-details','Api\MessageController@getAdminMessageDetails');
});

