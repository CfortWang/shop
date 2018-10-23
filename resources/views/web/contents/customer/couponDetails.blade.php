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
                <div class="am-u-md-12 am-u-sm-12 row-mb scan-user">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title center">
                            <div class="center-caption">
                                <span>详细列表</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="coupon-table">
                            <div class="coupon-details-table">
                                <div class="table-title clear-fix">
                                    <div class="couponName">@lang('customer/coupon.coupon_name')</div>
                                    <div class="couponUse">@lang('customer/coupon.is_used')</div>
                                    <div class="couponID">@lang('customer/coupon.coupon_code')</div>
                                    <div class="getTime">@lang('customer/coupon.receive_time')</div>
                                    <div class="useTime">@lang('customer/coupon.used_time')</div>
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
    var seq = args['seq']
    var limit = args['limit']
    var page = args['page']
    var pageCount
    var drawList = function () {
        $.ajax({
            url: '/api/customer/couponDetailUserList',
            type: 'get',
            dataType: 'json',
            data: {
                user: seq,
                limit: limit,
                page: page
            },
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data.data
                console.log(resData)
                let count = res.data.count
                pageCount = Math.ceil(count / limit)
                var $tr = '<div class="table-tr"><div class="table-td-name"></div><div class="table-td-coupon-use"></div><div class="table-td-coupon-id"></div><div class="table-td-get"><p class="years"></p><p class="hours"></p></div><div class="table-td-use"><p class="years"></p><p class="hours"></p></div></div>'
                for (let i = 0; i < resData.length; i++) {
                    $(".table-content").append($tr)
                    if (resData[i].is_owner) {
                        var character = "发起拼豆"
                    } else {
                        var character = '参与拼豆'
                    }
                    // if (nickname == null || nickname == '') {
                    //     nickname = '——'
                    // }
                    let couponName = resData[i].name
                    let couponUse = resData[i].status
                    let couponID = resData[i].use_code
                    let getTimeYears = resData[i].created_at.split(' ')[0]
                    let getTimeHours = resData[i].created_at.split(' ')[1]
                    let useTimeYears = resData[i].used_at.split(' ')[0]
                    let useTimeHours = resData[i].used_at.split(' ')[1]
                    $(".table-content .table-tr:eq("+ i +") .table-td-name").text(couponName)
                    $(".table-content .table-tr:eq("+ i +") .table-td-coupon-use").text(couponUse)
                    $(".table-content .table-tr:eq("+ i +") .table-td-coupon-id").text(couponID)
                    $(".table-content .table-tr:eq("+ i +") .table-td-get .years").text(getTimeYears)
                    $(".table-content .table-tr:eq("+ i +") .table-td-get .hours").text(getTimeHours)
                    $(".table-content .table-tr:eq("+ i +") .table-td-use .years").text(useTimeYears)
                    $(".table-content .table-tr:eq("+ i +") .table-td-use .hours").text(useTimeHours)
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

    // $(".table-content").on('click', '.table-tr', function () {
    //     let type = 'new'
    //     let time = $(this).children()[0]
    //     let date = $(time).text()
    //     let detailLimit = 8
    //     let detailPage = 1
    //     window.location.href = '/statistics/details?type=' + type + '&date=' + date + '&limit=' + detailLimit + '&page=' + detailPage
    // })
</script>
@endsection