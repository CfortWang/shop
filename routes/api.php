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
    Route::get('/logout',               'LoginController@logout');
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
        Route::get('/scannedUserList',            'CustomerController@scannedUserList');//扫码用户列表
        Route::get('/scannedUserDetail',          'CustomerController@scannedUserDetail');//扫码用户详情
        Route::get('/pddUserList',               'CustomerController@pddUserList');//拼豆用户列表
        Route::get('/couponUserList',            'CustomerController@couponUserList');//领取优惠券用户
        Route::get('/couponDetailUserList',       'CustomerController@couponDetailUserList');//领取优惠券详细用户列表
    });
    //ad
    Route::group(['prefix'  => 'adv'], function() {
        Route::get('/list',                    'AdController@adList');//广告列表
        Route::post('/adStatus',               'AdController@adStatus');//广告上下架
        Route::post('/modifyAd',               'AdController@modifyAd');//修改广告
        Route::get('/pkgList',                 'AdController@pkgList');//喜豆码列表
        Route::post('/createAd',               'AdController@createAd');
        Route::get('/adDetail',                'AdController@detail');
    });
    //common
    Route::group(['prefix'  => 'common'], function() {
        Route::get('/pkgList',                 'AdController@pkgList');//喜豆码列表
        Route::get('/country',                 'CommonController@country');//喜豆码列表
        Route::get('/province/{seq}',                 'CommonController@province');//喜豆码列表
        Route::get('/city/{seq}',                 'CommonController@city');//喜豆码列表
        Route::get('/area/{seq}',                 'CommonController@area');//喜豆码列表
        Route::post('/set_locale',                 'CommonController@setLocale');//喜豆码列表
    });
    //shop
    Route::group(['prefix'  => 'shop'], function() {
        Route::get('/info',                  'ShopController@info');
        Route::get('/category',              'ShopController@category');
        Route::post('/modify',               'ShopController@modify');
        Route::put('/deleteImage',           'ShopController@deleteImage');
        Route::post('/createCoupon',          'ShopController@createCoupon');  //创建优惠券
        Route::get('/couponList',             'ShopController@couponList');   //优惠券列表
        Route::put('/couponStatus',           'ShopController@couponStatus');// 
        Route::get('/couponDetail',           'ShopController@detail');
        Route::delete('/deleteCoupon',        'ShopController@deleteCoupon');
        Route::get('/statusList',        'ShopController@statusList');
        Route::post('/modifyCoupon',               'ShopController@modifyCoupon');
    });
    //Package
    Route::group(['prefix' => 'packages'], function() {
        Route::get('package_sales',                   'PackagesController@packageSales');//购买记录列表
        Route::get('buyer_request',                   'PackagesController@buyerRequest');
        Route::get('package_sales/detail',            'PackagesController@salesDetail');//销售记录详情
        Route::get('package_sales/item',              'PackagesController@salesItem');//购买记录详情列表
        Route::post('refund/{seq}',                    'PackagesController@refundSales');
        Route::put('received/{seq}',  'PackagesController@received');
        Route::get('package_sales/item_detail',       'PackagesController@itemDetail');//改变物流状态
        Route::post('buying_create',                  'PackagesController@buyingCreate');
        Route::get('my_package',                      'PackagesController@myPackageList');//我的喜豆码列表
        Route::get('my_package/codeDetailList',        'PackagesController@codeList');//我的喜豆码详情列表
        Route::get('my_package/myPackageDetail',       'PackagesController@myPackageDetail');//我的喜豆码详情
        Route::post('activation',    'PackagesController@codeActivation');
    });
    //Account Info
    Route::group(['prefix'  => 'account'], function() {
        Route::get('detail',                      'AccountInfoController@detail'); // 账号信息
        Route::get('scoreList',                   'AccountInfoController@scoreList'); // 积分列表
        Route::post('modify',                     'AccountInfoController@modify');
        Route::get('bank-list',                   'AccountInfoController@bankList');
        Route::get('cashList',                     'AccountInfoController@cashList');//提现列表
        Route::get('showBuyerInfo',                 'AccountInfoController@showBuyerInfo');
        Route::post('requestCash',                 'AccountInfoController@requestCash');//提现申请
    });

    Route::group(['prefix'  => 'event'], function() {
        Route::get('groupon',                      'GroupOnController@list'); 
        Route::post('groupon',                   'GroupOnController@create');
        Route::get('groupon/{id}',                   'GroupOnController@detail');
        Route::post('mgroupon',                   'GroupOnController@modify');

        Route::put('status',                      'GroupOnController@status'); 
        Route::post('upload',                   'GroupOnController@upload');

        Route::get('message',                      'MessageController@list'); 
        Route::post('message',                      'MessageController@create');
        Route::post('modifyMessage',                      'MessageController@modify');
        Route::get('message/{id}',                   'MessageController@detail');
        Route::put('deleteMessage/{id}',                   'MessageController@delete');
    });


});
