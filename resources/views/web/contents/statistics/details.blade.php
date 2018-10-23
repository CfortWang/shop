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
            <div class="am-u-md-12 am-u-sm-12 row-mb active-user">
                <div class="tpl-portlet">
                    <div class="tpl-portlet-title center">
                        <div class="center-caption">
                            <span>@lang('statistics.new.active_user')</span>
                        </div>
                    </div>
                    <div class="detail-page" id="tpl-echarts-C">
                        <div class="active-table">
                            <div class="table-title clear-fix">
                                <div class="user-id">@lang('statistics.user_id')</div>
                                <div class="user-name">@lang('statistics.nickname')</div>
                                <div class="scan-time">@lang('statistics.last_scanned_time')</div>
                            </div>
                            <div class="table-content"></div>
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
    <script>
        function getArgs () {
            var url = location.search
            var args = {}
            if (url.indexOf("?") != -1) {
                var str = url.substr(1)
                var strs = str.split("&")
                for (let i = 0; i < strs.length; i++) {
                    args[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1])
                }
            }
            return args
        }
        var args = getArgs()
        var type = args['type']
        var limit = args['limit']
        var date = args['date']
        var page = args['page']
        var pageCount
        var drawList = function () {
            $.ajax({
                url: 'http://shop.test/api/statistics/detail',
                type: 'get',
                dataType: 'json',
                data: {
                    date: date,
                    type: type,
                    limit: limit,
                    page: page
                },
                success: function (res) {
                    $(".table-content").empty()
                    let resData = res.data.data
                    console.log(resData)
                    let count = res.data.count
                    pageCount = Math.ceil(count / limit)
                    var $tr = '<div class="table-tr clear-fix"><div class="table-td-id"></div><div class="table-td-name"></div><div class="table-td-time"></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        let userID = resData[i].seq
                        let userName = resData[i].nickname
                        let scanTime = resData[i].created_at
                        if (userID == null || userID == '') {
                            userID = '——'
                        }
                        if (userName == null || userName == '') {
                            userName = '——'
                        }
                        if (scanTime == null || scanTime == '') {
                            scanTime = '——'
                        }
                        $(".table-content .table-tr:eq("+ i +") .table-td-id").text(userID)
                        $(".table-content .table-tr:eq("+ i +") .table-td-name").text(userName)
                        $(".table-content .table-tr:eq("+ i +") .table-td-time").text(scanTime)
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
    </script>
@endsection