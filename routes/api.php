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
        Route::get('/scannedUserDetail',            'CustomerController@scannedUserDetail');//扫码用户详情
        Route::get('/pddUserList',            'CustomerController@pddUserList');//拼豆用户列表
        Route::get('/couponUserList',            'CustomerController@couponUserList');//领取优惠券用户
    });
    //ad
    Route::group(['prefix'  => 'ad'], function() {
        Route::get('/adList',               'AdController@adList');//广告列表
        Route::post('/adtype/{seq}/{type}',               'AdController@adtype');//广告上下架
        Route::post('/modifyAd/{seq}',              'AdController@modifyAd');//修改广告
        Route::get('/pkgList',            'AdController@pkgList');//喜豆码列表
    });
    //shop
    Route::group(['prefix'  => 'shop'], function() {
        Route::get('info',                  'ShopController@info');
        Route::get('category',              'ShopController@category');
        Route::post('modify',               'ShopController@modify');
        Route::post('delete/image',         'ShopController@deleteImage');
    });
    //Package
    Route::group(['prefix' => 'packages'], function() {
    Route::get('package_sales',                   'PackagesController@packageSales');
    Route::get('buyer_request',                   'PackagesController@buyerRequest');
    Route::get('package_sales/{seq}/detail',      'PackagesController@salesDetail');
    Route::get('package_sales/{seq}/item',        'PackagesController@salesItem');
    Route::post('refund/{seq}',                    'PackagesController@refundSales');
    Route::patch('package_sales/{seq}/received',  'PackagesController@received');
    Route::get('package_sales/{seq}/item_detail', 'PackagesController@itemDetail');
    Route::post('buying_create',                  'PackagesController@buyingCreate');
    Route::get('my_package',                      'PackagesController@myPackageList');
    Route::get('my_package/codes/{seq}',          'PackagesController@codeList');
    Route::post('my_package/codes/activation',    'PackagesController@codeActivation');
});
  // Account Info
  Route::group(['prefix'  => 'account'], function() {
    Route::get('detail',                      'AccountInfoController@detail'); // 账号信息
    Route::get('scoreList',                   'AccountInfoController@scoreList'); // 积分列表
    Route::post('modify',                   'AccountInfoController@modify');
    Route::get('bank-list',                 'AccountInfoController@bankList');
});
});
