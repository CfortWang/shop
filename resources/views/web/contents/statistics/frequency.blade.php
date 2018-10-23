@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" type="text/css" media="all" href="/css/daterangepicker.css" />
@endsection('css')
@section('nav')
<span>数据/平均扫描频率</span>
@endsection('nav')

@section('content')

    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span> @lang('statistics.scan_frequency.scan_frequency')</span>
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

                <div class="am-u-md-12 am-u-sm-12 row-mb active-user">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title center">
                            <div class="center-caption">
                                <span>@lang('statistics.scan_frequency.average_code_number')</span>
                            </div>
                        </div>
                        <div class="" id="tpl-echarts-C">
                            <div class="frequency-table">
                                <div class="table-title clear-fix">
                                    <div class="date">@lang('statistics.silent_user.date')</div>
                                    <div class="count">@lang('statistics.scan_frequency.average_code_number')</div>
                                </div>
                                <div class="table-content pointer"></div>
                            </div>
                            <div class="no-data">
                                <img src="/img/main/no-data.png" alt="">
                                <div>暂无数据</div>
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
        })
        var drawData = function() {
            var echartsA = echarts.init(document.getElementById('tpl-echarts-A'));
            $.ajax({
                url: "/api/statistics/frequency",
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
                            data: ['扫码频率']
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
                                name: '扫码频率',
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

        var limit = 8
        var type = 'frequency'
        var page = 1
        var pageCount
        var drawList = function () {
            $.ajax({
                url: '/api/statistics/list',
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
                    $(".table-content").empty()
                    let resData = res.data.data
                    let count = res.data.count
                    if (count) {
                        $(".no-data").hide()
                        $(".pagination").show()
                        pageCount = Math.ceil(count / limit)
                        var $tr = '<div class="table-tr clear-fix"><div class="table-td-date"></div><div class="table-td-days"></div></div>'
                        for (let i = 0; i < resData.length; i++) {
                            $('.table-content').append($tr)
                            let date = resData[i].date
                            let days = resData[i].value
                            $(".table-content .table-tr:eq("+ i +") .table-td-date").text(date)
                            $(".table-content .table-tr:eq("+ i +") .table-td-days").text(days)
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

        $(".table-content").on('click', '.table-tr', function () {
            let type = 'frequency'
            let time = $(this).children()[0]
            let date = $(time).text()
            let detailLimit = 8
            let detailPage = 1
            window.location.href = '/statistics/details?type=' + type + '&date=' + date + '&limit=' + detailLimit + '&page=' + detailPage
        })
    </script>
@endsection
