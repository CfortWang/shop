<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shop BeanPOP</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" href="/img/logo.ico" type="image/x-icon">
    <!-- <link rel="apple-touch-icon-precomposed" href="i/app-icon72x72@2x.png"> -->
    <!-- <meta name="apple-mobile-web-app-title" content="Amaze UI" /> -->
    <!-- <link rel="stylesheet" href="/css/amazeui.min.css" /> -->
    <link href="https://cdn.bootcss.com/amazeui/2.7.2/css/amazeui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/toastr.min.css">
    @yield('css')
</head>
<body>
<div>
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <!-- <img src="/img/logo.png" alt=""> -->
                <img src="/img/seedo-logo-black.svg" alt="">
            </a>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">
        </div>
        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
            
        </div>
    </header>
    <div class="empty-header"></div>
    <div class="page-content">
        <div class="empty"></div>
        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                商家营销管理后台
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link active tpl-left-nav-link-list">
                            <img src="/img/main/icon_data.png" alt="">
                            <span>@lang('app.data.title')</span>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="/statistics/new">
                                    <span>@lang('app.data.new_scanned_code_customer')</span>
                                </a>
                                <a href="/statistics/analysis">
                                    <span>@lang('app.data.customer_analysis')</span>
                                </a>
                                <a href="/statistics/active">
                                    <span>@lang('app.data.active_customer')</span>
                                </a>
                                <a href="/statistics/silence">
                                    <span>@lang('app.data.silence')</span>
                                </a>
                                <a href="/statistics/frequency">
                                    <span>@lang('app.data.frequency')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <img src="/img/main/icon_user.png" alt="">
                            <span>@lang('app.customer.title')</span>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="/customer/scanned">
                                    <span>@lang('app.customer.scanned')</span>
                                </a>
                                <a href="/customer/groupon">
                                    <span>@lang('app.customer.groupon')</span>
                                </a>
                                <a href="/customer/coupon">
                                    <span>@lang('app.customer.coupon')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <img src="/img/main/icon_gift.png" alt="">
                            <span>@lang('app.event.title')</span>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="/event/groupon">
                                    <span>@lang('app.event.groupon')</span>
                                </a>
                                <a href="/event/coupon">
                                    <span>@lang('app.event.coupon')</span>
                                </a>
                                <a href="/event/message">
                                    <span>@lang('app.event.message')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <img src="/img/main/icon_gg.png" alt="">
                            <span>@lang('app.advertisement.title')</span>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" >
                            <li>
                                <a href="/ad/adList">
                                    <span>@lang('app.advertisement.setting')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <img src="/img/main/icon_shop_info.png" alt="">
                            <span>@lang('app.shop.title')</span>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="/shop/info">
                                    <span>@lang('app.shop.info')</span>
                                </a>
                                <a href="/shop/code">
                                    <span>@lang('app.shop.code')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <img src="/img/main/icon_setting.png" alt="">
                            <span>@lang('app.account.title')</span>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="/account/detail">
                                    <span>@lang('app.account.detail')</span>
                                </a>
                                <a href="/account/cashout">
                                    <span>@lang('app.account.cashout')</span>
                                </a>
                                <a href="/account/point">
                                    <span>@lang('app.account.point')</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class='contain'>
            <div class="header">
                <div class="header-lang">
                    <div class="exit">
                        <img src="/img/main/icon_exit.png" alt="">
                        <span>退出</span>
                    </div>
                    <div class="language-item">
                        <img src="/img/main/icon_global.png" alt="">
                        <div class="lang-selected">
                            <select name="lang" id="lang">
                                <option value="zh" {{App::getLocale() === 'zh' ? 'selected':null}}>zh - 中國</option>
                                <option value="en" {{App::getLocale() === 'en' ? 'selected':null}}>en - English</option>
                                <option value="ko" {{App::getLocale() === 'ko' ? 'selected':null}}>ko - 한국어</option>
                            </select>
                        </div>
                        <img src="/img/main/icon_right.png" alt="">
                    </div>
                </div>
                <div class="header-title">@yield('nav')</div>
            </div>
            <div class="content-outer">
                @yield('content')
            </div>
        </div>
            <!-- <script src="/js/jquery-2.1.1.js"></script> -->
            <!-- <script src="/js/amazeui.min.js"></script> -->
            <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
            <!-- <script src="/js/iscroll.js"></script> -->
            <script src="/js/toastr.min.js"></script>
            <script src="/js/app.js"></script>
            <script>
                $('#lang').change(function(e) {
                    var locale = $('#lang').val();
                    $.ajax({
                        url: '/api/common/set_locale',
                        data: {
                            'locale' : locale
                        },
                        dataType: 'json',
                        type: 'POST',
                        success: function(data){
                            location.reload();
                        },
                        error: function(data) {
                            // var httpStatus = data.status;
                            // var detailStatus = data.responseJSON.status;

                            // if (httpStatus === 400 && detailStatus === 401) {
                            //     bootbox.alert(localeWrongReq); 
                            // } else {
                            //     bootbox.alert(serverErrReq); 
                            // }
                        }
                    });
                });
                $('.exit').click(function(){
                    $.ajax({
                        url: '/api/logout/',
                        type: 'GET',
                        success: function(data){
                            location.reload();
                        },
                        // error: function(data) {
                        //     var httpStatus = data.status;
                        //     var detailStatus = data.responseJSON.status;

                        //     if (httpStatus === 400 && detailStatus === 401) {
                        //         bootbox.alert(localeWrongReq); 
                        //     } else {
                        //         bootbox.alert(serverErrReq); 
                        //     }
                        // }
                    });
                })
            </script>
            @yield('script')
        </div>
    </div>
</body>
</html>