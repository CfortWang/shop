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
                        <span>数据</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="table-font-list.html">
                                <span>新增扫码用户</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>用户分析</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>活跃用户</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>沉默用户</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>平均扫码频率</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-user"></i>
                        <span>我的客户</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="table-font-list.html">
                                <span>扫码用户</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>拼豆豆用户</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>领取优惠券用户</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-table"></i>
                        <span>营销</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="table-font-list.html">
                                <span>拼豆豆</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>优惠券</span>
                            </a>
                            <a href="table-font-list.html">
                                <span>消息通知</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-money"></i>
                        <span>广告</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu" >
                        <li>
                            <a href="form-amazeui.html">
                                <span>广告设置</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-shopping-bag"></i>
                        <span>商家信息</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="form-amazeui.html">
                                <span>基本信息</span>
                            </a>
                            <a href="form-line.html">
                                <span>喜豆码</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-cog"></i>
                        <span>账号信息</span>
                    </a>
                    <ul class="tpl-left-nav-sub-menu">
                        <li>
                            <a href="form-amazeui.html">
                                <span>账户详情</span>
                            </a>
                            <a href="form-line.html">
                                <span>提现</span>
                            </a>
                            <a href="form-line.html">
                                <span>积分</span>
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