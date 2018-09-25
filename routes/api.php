<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['namespace' => 'Api'], function() {
    Route::group(['prefix'  => 'login'], function() {
        Route::post('/',               'LoginController@login');
        Route::post('/sendCode',       'LoginController@sendCode');
        Route::post('/code',           'LoginController@code');
    });
    Route::group(['prefix'  => 'statistics'], function() {
        Route::get('/new',           'StatisticsController@newCustomer');
        Route::get('/analysis',                       'StatisticsController@analysis');
        Route::get('/active',                       'StatisticsController@active');
        Route::get('/silence',                       'StatisticsController@silence');
        Route::get('/frequency',                       'StatisticsController@frequency');
        Route::get('/all',                       'StatisticsController@all');
        Route::get('/list',                       'StatisticsController@list');
        Route::get('/detail',                       'StatisticsController@detail');
    });

    Route::group(['prefix'  => 'customer'], function() {
        Route::get('/scannedUserList',               'CustomerController@scannedUserList');//扫码用户列表
        Route::get('/{seq}/scannedUserDetail',            'CustomerController@scannedUserDetail');//扫码用户详情
        Route::get('/pddIngUserList',            'CustomerController@pddIngUserList');//拼豆中用户
        Route::get('/pddSuccessUserList',            'CustomerController@pddSuccessUserList');//拼豆成功用户
        Route::get('/couponUserList',            'CustomerController@couponUserList');//领取优惠券用户
    });
    //广告设置
    Route::group(['prefix'  => 'ad'], function() {
        Route::get('/adList',               'AdController@adList');//广告列表
        Route::post('/adtype/{seq}/{type}',               'AdController@adtype');//广告上下架
        Route::post('/modifyAd',            'AdController@modifyAd');//修改广告
    });
    //拼豆豆
    Route::group(['prefix'  => 'groupon'], function() {
        Route::get('/list',                 'GroupOnController@list');
        Route::post('/',                 'GroupOnController@create');
        Route::post('/{seq}',                 'GroupOnController@modify');
    });
});
