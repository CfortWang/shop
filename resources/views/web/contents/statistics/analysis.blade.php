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
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-echarts" id="tpl-echarts-1">
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-echarts" id="tpl-echarts-gender">
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-echarts" id="tpl-echarts-2">
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-echarts" id="tpl-echarts-3">
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-echarts" id="tpl-echarts-D">
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-echarts" id="tpl-echarts-E">
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
            
            $.ajax({
                url: "/api/statistics/analysis",
                dataType: 'json',
                type: 'get',
                data:{
                    startDate:startDate,
					endDate:endDate,
					dateSpan:dateSpan,
				},
                success: function(response){
                    var data = response.data;
                    console.log(data);
                    for (let index = 1; index < 4; index++) {
                        var echart = echarts.init(document.getElementById('tpl-echarts-'+index));
                        console.log(index);
                        var e_data = data[index];
                        console.log(e_data);
                        option = {
                            title : {
                                text: e_data.title,
                                subtext: '',
                                x:'center'
                            },
                            tooltip : {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                orient : 'vertical',
                                x : 'left',
                                data:e_data.item
                            },
                            calculable : true,
                            series : [
                                {
                                    name:e_data.title,
                                    type:'pie',
                                    radius : '55%',
                                    center: ['50%', '60%'],
                                    data:e_data.data
                                }
                            ]
                        };
                        echart.setOption(option,true);
                    }
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
