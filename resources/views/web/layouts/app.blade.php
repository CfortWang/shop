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
    <link rel="stylesheet" href="css/amazeui.min.css" />
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div>
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <!-- <img src="img/logo.png" alt=""> -->
            </a>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">
        </div>
        <!-- r -->
        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
           
        </div>
    </header>
    <div class="tpl-left-nav tpl-left-nav-hover">
        <div class="tpl-left-nav-title">
            商家管理平台
        </div>
        <div class="tpl-left-nav-list">
            <ul class="tpl-left-nav-menu">
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link active tpl-left-nav-link-list">
                        <i class="am-icon-pie-chart"></i>
                        <span>@lang('app.data.title')</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="statistics/new.html">
                                <span>@lang('app.data.new_scanned_code_customer')</span>
                            </a>
                            <a href="statistics/analysis.html">
                                <span>@lang('app.data.customer_analysis')</span>
                            </a>
                            <a href="statistics/active.html">
                                <span>@lang('app.data.active_customer')</span>
                            </a>
                            <a href="statistics/silence.html">
                                <span>@lang('app.data.silence')</span>
                            </a>
                            <a href="statistics/frequency.html">
                                <span>@lang('app.data.frequency')</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-user"></i>
                        <span>@lang('app.customer.title')</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="customer.html">
                                <span>@lang('app.customer.scanned')</span>
                            </a>
                            <a href="customer/scanned.html">
                                <span>@lang('app.customer.scanned')</span>
                            </a>
                            <a href="customer/coupon.html">
                                <span>@lang('app.customer.coupon')</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-table"></i>
                        <span>@lang('app.event.title')</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="event/groupon.html">
                                <span>@lang('app.event.groupon')</span>
                            </a>
                            <a href="event/coupon.html">
                                <span>@lang('app.event.coupon')</span>
                            </a>
                            <a href="event/message.html">
                                <span>@lang('app.event.message')</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-money"></i>
                        <span>@lang('app.advertisement.title')</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu" >
                        <li>
                            <a href="advertisement/setting.html">
                                <span>@lang('app.advertisement.setting')</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-shopping-bag"></i>
                        <span>@lang('app.shop.title')</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="shop/info.html">
                                <span>@lang('app.shop.info')</span>
                            </a>
                            <a href="shop/code.html">
                                <span>@lang('app.shop.code')</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-cog"></i>
                        <span>@lang('app.account.title')</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="account.html">
                                <span>@lang('app.account.detail')</span>
                            </a>
                            <a href="account/cashout.html">
                                <span>@lang('app.account.cashout')</span>
                            </a>
                            <a href="account/point.html">
                                <span>@lang('app.account.point')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
            @yield('content')
            <script src="js/jquery-2.1.1.js"></script>
            <script src="js/amazeui.min.js"></script>
            <script src="js/iscroll.js"></script>
            <script src="js/app.js"></script>
            @yield('script')
        </div>
</body>
</html>