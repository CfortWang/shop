<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Amaze UI Admin index Examples</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!-- <link rel="icon" type="image/png" href="i/favicon.png"> -->
    <!-- <link rel="apple-touch-icon-precomposed" href="i/app-icon72x72@2x.png"> -->
    <!-- <meta name="apple-mobile-web-app-title" content="Amaze UI" /> -->
    <link rel="stylesheet" href="/css/amazeui.min.css" />
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/app.css">
    @yield('css')
</head>
<body>
<div>
    <!-- <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <img src="img/logo.png" alt="">
            </a>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">
        </div>
        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
           
        </div>
    </header> -->
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
                                <a href="advertisement/setting">
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
                                <a href="shop/info">
                                    <span>@lang('app.shop.info')</span>
                                </a>
                                <a href="shop/code">
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
                                <a href="account">
                                    <span>@lang('app.account.detail')</span>
                                </a>
                                <a href="account/cashout">
                                    <span>@lang('app.account.cashout')</span>
                                </a>
                                <a href="account/point">
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
                            <select name="" id="">
                                <option value="1">zh-中国</option>
                                <option value="2">zh-中国</option>
                                <option value="3">zh-中国</option>
                            </select>
                        </div>
                        <img src="/img/main/icon_right.png" alt="">
                    </div>
                </div>
                <div class="header-title">数据/新增扫码用户</div>
            </div>
            <div class="content-outer">
                @yield('content')
            </div>
        </div>
            <script src="/js/jquery-2.1.1.js"></script>
            <script src="/js/amazeui.min.js"></script>
            <script src="/js/iscroll.js"></script>
            <script src="/js/app.js"></script>
            @yield('script')
        </div>
    </div>
</body>
</html>