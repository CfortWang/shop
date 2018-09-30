<?php

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


Route::group(['namespace' => 'Web'], function() {
    Route::get('login',                       'LoginController@login')->name("login");
    Route::group(['middleware' => 'login'], function() {
        Route::get('/',               'HomeController@index')->name("shop_index");
        Route::get('/index',               'HomeController@index')->name("shop_index");
        Route::group(['prefix'  => '/statistics'], function() {
            Route::get('/new',                       'StatisticsController@new');
            Route::get('/analysis',                       'StatisticsController@analysis');
            Route::get('/active',                       'StatisticsController@active');
            Route::get('/silence',                       'StatisticsController@silence');
            Route::get('/frequency',                       'StatisticsController@frequency');
            Route::get('/details',                       'StatisticsController@details');
        });
        //customer 
        Route::group(['prefix'  => 'customer'], function() {
            Route::get('/scanned',                       'CustomerController@scannedList')->name("scanned");
            Route::get('/scanned/details',                       'CustomerController@scanDetails');
            Route::get('/groupon',                       'CustomerController@groupOn');
            Route::get('/groupon/details',                       'CustomerController@groupDetails');
            Route::get('/coupon',                       'CustomerController@coupon');
            Route::get('/coupon/details',                       'CustomerController@couponDetails');
        });
   
        //
        Route::group(['prefix'  => 'event'], function() {
            Route::get('/groupon',                       'EventController@groupon');
            Route::get('/groupon/create',                       'EventController@createGroup');
            Route::get('/coupon',                       'EventController@coupon');
            Route::get('/coupon/create',                       'EventController@createCoupon');
        });
        //ad
        Route::group(['prefix'  => 'ad'], function() {
            Route::get('/list',                       'AdController@list');
            Route::get('/register',                   'AdController@createAd');
        });
        //shop
        Route::group(['prefix'  => 'shop'], function() {
            Route::get('/info',                       'ShopController@list');
            Route::get('/code',                       'ShopController@code');
        });
        //account
        Route::group(['prefix'  => 'account'], function() {
        Route::get('/detail',                       'AccountController@detail');
        Route::get('/cashout',                      'AccountController@cashout');
        Route::get('/point',                        'AccountController@point');
    });
    });
});
