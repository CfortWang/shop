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
                        <div class="tpl-portlet-title">
                            <ul class="tab">
                                <li class="tab-item tab-active" data-type="ing">@lang('customer/groupon.grouponing')</li>
                                <li class="tab-item" data-type="success">@lang('customer/groupon.groupon_success')</li>
                                <li class="tab-item" data-type="fail">@lang('customer/groupon.groupon_failed')</li>
                            </ul>
                        </div>
                        <div class="tpl-echarts" id="pdd-table">
                            <div class="pdd-ing-table" data-type="ing">
                                <div class="table-title clear-fix">
                                    <div class="ID">@lang('customer/groupon.phone_num')</div>
                                    <div class="nickname">@lang('customer/groupon.nickname')</div>
                                    <div class="character">@lang('customer/groupon.groupon_role')</div>
                                    <div class="pddTime">@lang('customer/groupon.groupon_start_time')</div>
                                </div>
                                <div class="table-content"></div>
                            </div>
                            <div class="pdd-success-table" data-type="success">
                                <div class="table-title clear-fix">
                                    <div class="ID">@lang('customer/groupon.phone_num')</div>
                                    <div class="nickname">@lang('customer/groupon.nickname')</div>
                                    <div class="character">@lang('customer/groupon.groupon_role')</div>
                                    <div class="couponUse">@lang('customer/groupon.is_groupon_used')</div>
                                    <div class="couponID">	@lang('customer/groupon.groupon_coupon_code')</div>
                                    <div class="successTime">@lang('customer/groupon.groupon_success_time')</div>
                                    <div class="pddTime">@lang('customer/groupon.groupon_start_time')</div>
                                </div>
                                <div class="table-content"></div>
                            </div>
                            <div class="pdd-fail-table" data-type="fail">
                                <div class="table-title clear-fix">
                                    <div class="ID">@lang('customer/groupon.phone_num')</div>
                                    <div class="nickname">@lang('customer/groupon.nickname')</div>
                                    <div class="character">@lang('customer/groupon.groupon_role')</div>
                                    <div class="failTime">@lang('customer/groupon.groupon_failed_time')</div>
                                    <div class="pddTime">@lang('customer/groupon.groupon_start_time')</div>
                                </div>
                                <div class="table-content"></div>
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
<script>
    var limit = 8
    var type = 'ing'
    var page = 1
    var pageCount
    var drawList = function () {
        $.ajax({
            url: '/api/customer/pddUserList',
            type: 'get',
            dataType: 'json',
            data: {
                type: type,
                limit: limit,
                page: page
            },
            success: function (res) {
                $(".table-content").empty()
                if (type == 'ing') {
                    var selected = $(".pdd-ing-table .table-content")
                }
                if (type == 'success') {
                    var selected = $(".pdd-success-table .table-content")
                }
                if (type == 'fail') {
                    var selected = $(".pdd-fail-table .table-content")
                }
                let resData = res.data.data
                let count = res.data.count
                if (count) {
                    $(".no-data").hide()
                    $(".pagination").show()
                    pageCount = Math.ceil(count / limit)
                    if (type == 'ing') {
                        var $tr = '<div class="table-tr"><div class="table-td-id"></div><div class="table-td-nickname"></div><div class="table-td-character"></div><div class="table-td-join"><p class="years"></p><p class="hours"></p></div></div>'
                    }
                    if (type == 'success') {
                        var $tr = '<div class="table-tr"><div class="table-td-id"></div><div class="table-td-nickname"></div><div class="table-td-character"></div><div class="table-td-coupon-use"></div><div class="table-td-coupon-id"></div><div class="table-td-success"><p class="years"></p><p class="hours"></p></div><div class="table-td-join"><p class="years"></p><p class="hours"></p></div></div>'
                    }
                    if (type == 'fail') {
                        var $tr = '<div class="table-tr"><div class="table-td-id"></div><div class="table-td-nickname"></div><div class="table-td-character"></div><div class="table-td-fail"><p class="years"></p><p class="hours"></p></div><div class="table-td-join"><p class="years"></p><p class="hours"></p></div></div>'
                    }
                    for (let i = 0; i < resData.length; i++) {
                        selected.append($tr)
                        if (resData[i].phone == null || resData[i].phone == '') {
                            var phone = '——'
                        } else {
                            var phone = "+" + resData[i].phone.split('@')[1] + " " + resData[i].phone.split('@')[0]
                        }
                        if (resData[i].is_owner) {
                            var character = "发起拼豆"
                        } else {
                            var character = '参与拼豆'
                        }
                        let nickname = resData[i].nickname
                        let joinTimeYears = resData[i].created_at.split(' ')[0]
                        let joinTimeHours = resData[i].created_at.split(' ')[1]

                        if (type == 'success') {
                            if (resData[i].paid_status == 2) {
                                var couponUse = "已使用"
                            } else {
                                var couponUse = "未使用"
                            }
                            let couponID = resData[i].use_code
                            let successTimeYears = resData[i].updated_at.split(' ')[0]
                            let successTimeHours = resData[i].updated_at.split(' ')[1]
                            $(".table-content .table-tr:eq("+ i +") .table-td-coupon-use").text(couponUse)
                            $(".table-content .table-tr:eq("+ i +") .table-td-coupon-id").text(couponID)
                            $(".table-content .table-tr:eq("+ i +") .table-td-success .years").text(successTimeYears)
                            $(".table-content .table-tr:eq("+ i +") .table-td-success .hours").text(successTimeHours)
                        }
                        if (type == 'fail') {
                            let failTimeYears = resData[i].expried_at.split(' ')[0]
                            let failTimeHours = resData[i].expried_at.split(' ')[1]
                            $(".table-content .table-tr:eq("+ i +") .table-td-fail .years").text(failTimeYears)
                            $(".table-content .table-tr:eq("+ i +") .table-td-fail .hours").text(failTimeHours)
                        }
                        if (nickname == null || nickname == '') {
                            nickname = '——'
                        }

                        $(".table-content .table-tr:eq("+ i +") .table-td-id").text(phone)
                        $(".table-content .table-tr:eq("+ i +") .table-td-nickname").text(nickname)
                        $(".table-content .table-tr:eq("+ i +") .table-td-character").text(character)
                        $(".table-content .table-tr:eq("+ i +") .table-td-join .years").text(joinTimeYears)
                        $(".table-content .table-tr:eq("+ i +") .table-td-join .hours").text(joinTimeHours)
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

    $(".tab-item").on('click', function () {
        $(this).addClass("tab-active")
        $(this).siblings().removeClass("tab-active")
        type = $(this).attr("data-type")
        for (let i = 0; i < 3; i++) {
            var pddType = $("#pdd-table > div:eq("+ i +")").attr("data-type")
            if (pddType == type) {
                $("#pdd-table > div:eq("+ i +")").show()
            } else {
                $("#pdd-table > div:eq("+ i +")").hide()
            }
        }
        drawList();
    })
</script>
@endsection