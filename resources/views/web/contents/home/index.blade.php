@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" type="text/css" media="all" href="/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" media="all" href="/css/bootstrap-datetimepicker.min.css" />
@endsection('css')
@section('content')

    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span> 昨日扫码用户</span>
                            </div>
                            <input type="text" id="config-demo" class="form-control" style="max-width:320px;display:inline-block;margin:4px">
                            <div class="actions">
                                <ul class="actions-btn">
                                    <li class="dateSpan blue blue-on" data-span="hour">@lang('statistics.hour')</li>
                                    <li class="dateSpan blue" data-span="day">@lang('statistics.day')</li>
                                    <li class="dateSpan blue" data-span="week">@lang('statistics.week')</li>
                                </ul>
                            </div>
                        </div>
                        <!--此部分数据请在 js文件夹下中的 app.js 中的 “百度图表A” 处修改数据 插件使用的是 百度echarts-->
                        <div class="tpl-echarts" id="tpl-echarts-A">
                        </div>
                    </div>
                </div>
                <!-- <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-red ">
                                <i class="am-icon-bar-chart"></i>
                                <span> Cloud 动态资料</span>
                            </div>
                            <div class="actions">
                                <ul class="actions-btn">
                                    <li class="purple-on">@lang('statistics.day')</li>
                                    <li class="green">@lang('statistics.week')</li>
                                </ul>
                            </div>
                        </div>
                        <div class="tpl-scrollable">
                            <div class="number-stats">
                                <div class="stat-number am-fl am-u-md-6">
                                    <div class="title am-text-right"> Total </div>
                                    <div class="number am-text-right am-text-warning"> 2460 </div>
                                </div>
                                <div class="stat-number am-fr am-u-md-6">
                                    <div class="title"> Total </div>
                                    <div class="number am-text-success"> 2460 </div>
                                </div>
                            </div>
                            <table class="am-table tpl-table">
                                <thead>
                                    <tr class="tpl-table-uppercase">
                                        <th>人员</th>
                                        <th>余额</th>
                                        <th>次数</th>
                                        <th>效率</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="img/user01.png" alt="" class="user-pic">
                                            <a class="user-name" href="###">禁言小张</a>
                                        </td>
                                        <td>￥3213</td>
                                        <td>65</td>
                                        <td class="font-green bold">26%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="img/user02.png" alt="" class="user-pic">
                                            <a class="user-name" href="###">Alex.</a>
                                        </td>
                                        <td>￥2635</td>
                                        <td>52</td>
                                        <td class="font-green bold">32%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="img/user03.png" alt="" class="user-pic">
                                            <a class="user-name" href="###">Tinker404</a>
                                        </td>
                                        <td>￥1267</td>
                                        <td>65</td>
                                        <td class="font-green bold">51%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="img/user04.png" alt="" class="user-pic">
                                            <a class="user-name" href="###">Arron.y</a>
                                        </td>
                                        <td>￥657</td>
                                        <td>65</td>
                                        <td class="font-green bold">73%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="img/user05.png" alt="" class="user-pic">
                                            <a class="user-name" href="###">Yves</a>
                                        </td>
                                        <td>￥3907</td>
                                        <td>65</td>
                                        <td class="font-green bold">12%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="img/user06.png" alt="" class="user-pic">
                                            <a class="user-name" href="###">小黄鸡</a>
                                        </td>
                                        <td>￥900</td>
                                        <td>65</td>
                                        <td class="font-green bold">10%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- <div class="row">
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span>指派任务</span>
                                <span class="caption-helper">16 件</span>
                            </div>
                            <div class="tpl-portlet-input">
                                <div class="portlet-input input-small input-inline">
                                    <div class="input-icon right">
                                        <i class="am-icon-search"></i>
                                        <input type="text" class="form-control form-control-solid" placeholder="搜索...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="wrapper" class="wrapper">
                            <div id="scroller" class="scroller">
                                <ul class="tpl-task-list">
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> Amaze UI Icon 组件目前使用了 Font Awesome </span>
                                            <span class="label label-sm label-success">技术部</span>
                                            <span class="task-bell">
                                                <i class="am-icon-bell-o"></i>
                                            </span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 在 data-am-dropdown
                                                里指定要适应到的元素，下拉内容的宽度会设置为该元素的宽度。当然可以直接在 CSS 里设置下拉内容的宽度。 </span>
                                            <span class="label label-sm label-danger">运营</span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 使用 LESS： 通过设置变量 @fa-font-path 覆盖默认的值，如
                                                @fa-font-path: "../fonts";。这个变量定义在 icon.less 里。 </span>
                                            <span class="label label-sm label-warning">市场部</span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 添加 .am-btn-group-justify class
                                                让按钮组里的按钮平均分布，填满容器宽度。 </span>
                                            <span class="label label-sm label-default">已废弃</span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 按照示例组织好 HTML 结构（不加 data-am-dropdown 属性），然后通过
                                                JS 来调用。 </span>
                                            <span class="label label-sm label-success">技术部</span>
                                            <span class="task-bell">
                                                <i class="am-icon-bell-o"></i>
                                            </span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 添加 .am-btn-group-justify class
                                                让按钮组里的按钮平均分布，填满容器宽度。 </span>
                                            <span class="label label-sm label-default">已废弃</span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 使用 LESS： 通过设置变量 @fa-font-path 覆盖默认的值，如
                                                @fa-font-path: "../fonts";。这个变量定义在 icon.less 里。 </span>
                                            <span class="label label-sm label-warning">市场部</span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 添加 .am-btn-group-justify class
                                                让按钮组里的按钮平均分布，填满容器宽度。 </span>
                                            <span class="label label-sm label-default">已废弃</span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="task-checkbox">
                                            <input type="hidden" value="1" name="test">
                                            <input type="checkbox" class="liChild" value="2" name="test"> </div>
                                        <div class="task-title">
                                            <span class="task-title-sp"> 按照示例组织好 HTML 结构（不加 data-am-dropdown 属性），然后通过
                                                JS 来调用。 </span>
                                            <span class="label label-sm label-success">技术部</span>
                                            <span class="task-bell">
                                                <i class="am-icon-bell-o"></i>
                                            </span>
                                        </div>
                                        <div class="task-config">
                                            <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                <a href="###" class="am-dropdown-toggle tpl-task-list-hover "
                                                    data-am-dropdown-toggle>
                                                    <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                </a>
                                                <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-check"></i> 保存 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-pencil"></i> 编辑 </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;">
                                                            <i class="am-icon-trash-o"></i> 删除 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span>项目进度</span>
                            </div>
                        </div>
                        <div class="am-tabs tpl-index-tabs" data-am-tabs>
                            <ul class="am-tabs-nav am-nav am-nav-tabs">
                                <li class="am-active"><a href="#tab1">进行中</a></li>
                                <li><a href="#tab2">已完成</a></li>
                            </ul>
                            <div class="am-tabs-bd">
                                <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                                    <div id="wrapperA" class="wrapper">
                                        <div id="scroller" class="scroller">
                                            <ul class="tpl-task-list tpl-task-remind">
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                                                            <i class="am-icon-bell-o"></i>
                                                        </span>
                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display:
                                                            block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                                <i class="am-icon-share"></i>
                                                            </span></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                                                            <i class="am-icon-bolt"></i>
                                                        </span>
                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw
                                                            将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                                                            <i class="am-icon-bullhorn"></i>
                                                        </span>
                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        1天前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-warning">
                                                            <i class="am-icon-plus"></i>
                                                        </span>
                                                        <span> 部分用户反应在过长的 Tabs 中滚动页面时会意外触发 Tab 切换事件，用户可以选择禁用触控操作。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                                                            <i class="am-icon-bell-o"></i>
                                                        </span>
                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display:
                                                            block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                                <i class="am-icon-share"></i>
                                                            </span></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                                                            <i class="am-icon-bolt"></i>
                                                        </span>
                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw
                                                            将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                                                            <i class="am-icon-bullhorn"></i>
                                                        </span>
                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-tab-panel am-fade" id="tab2">
                                    <div id="wrapperB" class="wrapper">
                                        <div id="scroller" class="scroller">
                                            <ul class="tpl-task-list tpl-task-remind">
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                                                            <i class="am-icon-bell-o"></i>
                                                        </span>
                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display:
                                                            block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                                <i class="am-icon-share"></i>
                                                            </span></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                                                            <i class="am-icon-bolt"></i>
                                                        </span>
                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw
                                                            将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                                                            <i class="am-icon-bullhorn"></i>
                                                        </span>
                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        1天前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-warning">
                                                            <i class="am-icon-plus"></i>
                                                        </span>
                                                        <span> 部分用户反应在过长的 Tabs 中滚动页面时会意外触发 Tab 切换事件，用户可以选择禁用触控操作。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                                                            <i class="am-icon-bell-o"></i>
                                                        </span>
                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display:
                                                            block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                                <i class="am-icon-share"></i>
                                                            </span></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                                                            <i class="am-icon-bolt"></i>
                                                        </span>
                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw
                                                            将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                                                            <i class="am-icon-bullhorn"></i>
                                                        </span>
                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
@endsection
@section('script')
    <!-- <script src="/js/echarts.min.js"></script> -->
    <script src="https://cdn.bootcss.com/echarts/4.2.0-rc.1/echarts.simple.min.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/daterangepicker.js"></script>
    <script>
    var startDate = moment().subtract(7, 'days').format('YYYY-MM-DD');
    var endDate = moment().format('YYYY-MM-DD');
    var dateSpan = 'day';
    var options = {};
     options.locale = {
            format: "YYYY-MM-DD",
            separator: " - ",
            daysOfWeek: ["日","一","二","三","四","五","六"],
            monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
        };
        options.ranges= {
            '过去7天': [moment().subtract(6, 'days').startOf('week'), moment().endOf('week')],
            '过去30天': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
            '这个月': [moment().startOf('month'), moment().endOf('month')],
            '上个月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
        options.startDate =  moment().subtract(7, 'days');
        options.endDate =  moment();
        options.maxDate =  moment();
        options.autoApply = true;
        $('#config-demo').daterangepicker(options, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')'); 
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            drawData();
        })
        $('.dateSpan').click(function(){
            $(this).siblings().removeClass('blue-on');
            $(this).addClass('blue-on');
            dateSpan = $(this).data('span');
            drawData();
        })
        var drawData = function() {
            var echartsA = echarts.init(document.getElementById('tpl-echarts-A'));
            $.ajax({
                url: "/api/statistics/new",
                dataType: 'json',
                type: 'get',
                data:{
                    startDate:startDate,
					endDate:endDate,
					dateSpan:dateSpan,
				},
                success: function(response){
                    var data = response.data;
                    var e_data = data.data;
                    var e_item = data.item;
                    option = {
                        tooltip: {
                            trigger: 'axis',
                        },
                        legend: {
                            data: ['新增用户']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: [{
                            type: 'category',
                            boundaryGap: true,
                            data: e_item
                        }],
            
                        yAxis: [{
                            type: 'value'
                        }],
                        series: [{
                                name: '新增用户',
                                type: 'line',
                                stack: '总量',
                                // areaStyle: { normal: {} },
                                data: e_data,
                                itemStyle: {
                                    normal: {
                                        color: '#59aea2'
                                    },
                                    emphasis: {
            
                                    }
                                }
                            },
                        ]
                    };
                    echartsA.setOption(option,true);
                },
                error: function(e) {
                    console.log(e);
                }
            }).always(function(){
            });
        }
        drawData();
       
    </script>
@endsection
