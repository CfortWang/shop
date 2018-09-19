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
        });
        //customer 我的客户
        Route::group(['prefix'  => 'customer'], function() {
            Route::get('/scanned',                       'CustomerController@scannedList')->name("scanned");
            Route::get('/{seq}/scannedDetai',            'CustomerController@scannedDetail');
            Route::get('/groupon',                       'CustomerController@grouponList');
            Route::get('/coupon',                        'CustomerController@couponList');
        });
    });
});
