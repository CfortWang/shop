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
                                <p class="user-amount">100</p>
                            </div>
                            <div class="yesterday-user">
                                <span class="user-type">昨日扫码用户</span>
                                <p class="user-amount">1000</p>
                            </div>
                            <div class="user-count">
                                <span class="user-type">累计扫码用户</span>
                                <p class="user-amount">10000</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-md-8 am-u-sm-8 row-mb">
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
                <div class="am-u-md-4 am-u-sm-4 row-mb C">
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
                                <div class="table-content">
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                    <div class="table-tr clear-fix">
                                        <div class="table-td-date">2019-09-09</div>
                                        <div class="table-td-count">1000</div>
                                    </div>
                                </div>
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
        })
        $('.dateSpan').click(function(){
            $(this).siblings().removeClass('blue-on');
            $(this).addClass('blue-on');
            dateSpan = $(this).data('span');
            drawData();
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
