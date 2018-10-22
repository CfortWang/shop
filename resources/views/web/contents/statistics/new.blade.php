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
                            <div class="tpl-caption">
                                <span> 昨日核心指标</span>
                                <p class="tpl-remark">本页面根据昨日数据计算,并非实时数据</p>
                            </div>
                        </div>
                        <!--此部分数据请在 js文件夹下中的 app.js 中的 “百度图表A” 处修改数据 插件使用的是 百度echarts-->
                        <div class="tpl-echarts-A" id="tpl-echarts-A">
                            <div class="new-user">
                                <span class="user-type">新增扫码用户</span>
                                <p class="user-amount"></p>
                            </div>
                            <div class="yesterday-user">
                                <span class="user-type">昨日扫码用户</span>
                                <p class="user-amount"></p>
                            </div>
                            <div class="user-count">
                                <span class="user-type">累计扫码用户</span>
                                <p class="user-amount"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-lg-8 am-u-md-8 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span> 昨日扫码用户</span>
                            </div>
                            <input type="text" id="config-demo" class="form-control" style="max-width:320px;display:inline-block;margin:4px">
                            <div class="actions">
                                <ul class="actions-btn">
                                    <li class="dateSpan blue blue-on" data-span="hour">小时</li>
                                    <li class="dateSpan blue" data-span="day">天</li>
                                    <li class="dateSpan blue" data-span="week">周</li>
                                </ul>
                            </div>
                        </div>
                        <!--此部分数据请在 js文件夹下中的 app.js 中的 “百度图表A” 处修改数据 插件使用的是 百度echarts-->
                        <div class="tpl-echarts" id="tpl-echarts-B">
                        </div>
                    </div>
                </div>
                <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 row-mb new">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title center">
                            <div class="center-caption">
                                <span>新增扫码用户</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="tpl-echarts-C">
                            <div class="user-table">
                                <div class="table-title clear-fix">
                                    <div class="date">日期</div>
                                    <div class="count">新增用户</div>
                                </div>
                                <div class="table-content"></div>
                            </div>
                            <div class="no-data">
                                <img src="/img/main/no-data.png" alt="">
                            </div>
                            <div class="pagination">
                                <div class="page-down">
                                    <img src="/img/main/icon_page_left.png" alt="">
                                </div>
                                <div class="page-number">1</div>
                                <div class="page-up">
                                    <img src="/img/main/icon_page_right.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/js/echarts.min.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/daterangepicker.js"></script>
    <script>
        var startDate = moment().subtract(7, 'days').format('YYYY-MM-DD');
        var endDate = moment().format('YYYY-MM-DD');
        var dateSpan = 'day';
        var type = 'new';
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
            drawList();
        })
        $('.dateSpan').click(function(){
            $(this).siblings().removeClass('blue-on');
            $(this).addClass('blue-on');
            dateSpan = $(this).data('span');
            drawData();
            drawList();
        })

        var getYesterday = function () {
            $.ajax({
                url: 'http://shop.test/api/statistics/all',
                type: 'get',
                dataType: 'json',
                success: function (res) {
                    let resData = res.data
                    let newUser = resData.tomorrowNew
                    let yestdUser = resData.tomorrowAll
                    let userCount = resData.all
                    $(".new-user .user-amount").text(newUser)
                    $(".yesterday-user .user-amount").text(yestdUser)
                    $(".user-count .user-amount").text(userCount)
                },
                error: function (ex) {
                    console.log(ex)
                }
            })
        }
        getYesterday();

        var limit = 8
        var page = 1
        var pageCount
        var drawList = function () {
            $.ajax({
                url: 'http://shop.test/api/statistics/list',
                type: 'get',
                dataType: 'json',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    dateSpan: dateSpan,
                    type: type,
                    limit: limit,
                    page: page
                },
                success: function (res) {
                    $(".user-table .table-content").empty()
                    let resData = res.data.data
                    let count = res.data.count
                    if (count) {
                        $(".no-data").hide()
                        $(".pagination").show()
                        pageCount = Math.ceil(count / limit)
                        var $tr = '<div class="table-tr clear-fix"><div class="table-td-date"></div><div class="table-td-count"></div></div>'
                        for (let i = 0; i < resData.length; i++) {
                            $('.user-table .table-content').append($tr)
                            let date = resData[i].date
                            let count = resData[i].value
                            $(".user-table .table-content .table-tr:eq("+ i +") .table-td-date").text(date)
                            $(".user-table .table-content .table-tr:eq("+ i +") .table-td-count").text(count)
                        }
                    } else {
                        $(".no-data").show()
                        $(".pagination").hide()
                    }
                },
                error: function (ex) {
                    console.log(ex)
                }
            })
        }
        drawList();

        $(".page-down").click(function () {
            if (page > 1) {
                page--
                drawList();
                $(".page-number").text(page)
            } else {
                console.log("当前已是第一页")
            }
        })
        $(".page-up").click(function () {
            if (page < pageCount) {
                page++;
                drawList();
                $(".page-number").text(page)
            } else {
                console.log("已无更多数据")
            }
        })

        $(".table-content").on('click', '.table-tr', function () {
            let type = 'new'
            let time = $(this).children()[0]
            let date = $(time).text()
            let detailLimit = 8
            let detailPage = 1
            window.location.href = '/statistics/details?type=' + type + '&date=' + date + '&limit=' + detailLimit + '&page=' + detailPage
        })

        var drawData = function() {
            var echartsA = echarts.init(document.getElementById('tpl-echarts-B'));
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
