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
                                <span>用户列表</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="coupon-table">
                            <div class="coupon-table">
                                <div class="table-title clear-fix">
                                    <div class="phone">手机号</div>
                                    <div class="nickname">昵称</div>
                                    <div class="frequency">领取次数</div>
                                    <div class="couponUse">是否使用</div>
                                    <div class="couponID">优惠券码</div>
                                    <div class="getTime">领券时间</div>
                                    <div class="useTime">使用时间</div>
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
    var page = 1
    var pageCount
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/customer/couponUserList',
            type: 'get',
            dataType: 'json',
            data: {
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
                    var $tr = '<div class="table-tr"><div class="table-td-id"></div><div class="table-td-nickname"></div><div class="table-td-frequency"></div><div class="table-td-coupon-use"></div><div class="table-td-coupon-id"></div><div class="table-td-get"><p class="years"></p><p class="hours"></p></div><div class="table-td-use"><p class="years"></p><p class="hours"></p></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $(".table-content").append($tr)
                        if (resData[i].id == null || resData[i].id == '') {
                            var phone = '——'
                        } else {
                            var phone = "+" + resData[i].id.split('@')[1] + " " + resData[i].id.split('@')[0]
                        }
                        let seq = resData[i].user
                        let nickname = resData[i].nickname
                        let frequency = resData[i].user_count
                        let couponUse = resData[i].status
                        let couponID = resData[i].use_code
                        let getTimeYears = resData[i].created_at.split(' ')[0]
                        let getTimeHours = resData[i].created_at.split(' ')[1]
                        let useTimeYears = resData[i].used_at.split(' ')[0]
                        let useTimeHours = resData[i].used_at.split(' ')[1]
                        if (nickname == null || nickname == '') {
                            nickname = '——'
                        }
                        if (couponUse == null || couponUse == '') {
                            couponUse = '——'
                        }
                        if (couponID == null || couponID == '') {
                            couponID = '——'
                        }
                        $(".table-content .table-tr:eq("+ i +")").attr('data-seq', seq)
                        $(".table-content .table-tr:eq("+ i +") .table-td-id").text(phone)
                        $(".table-content .table-tr:eq("+ i +") .table-td-nickname").text(nickname)
                        $(".table-content .table-tr:eq("+ i +") .table-td-frequency").text(frequency)
                        $(".table-content .table-tr:eq("+ i +") .table-td-coupon-use").text(couponUse)
                        $(".table-content .table-tr:eq("+ i +") .table-td-coupon-id").text(couponID)
                        $(".table-content .table-tr:eq("+ i +") .table-td-get .years").text(getTimeYears)
                        $(".table-content .table-tr:eq("+ i +") .table-td-get .hours").text(getTimeHours)
                        $(".table-content .table-tr:eq("+ i +") .table-td-use .years").text(useTimeYears)
                        $(".table-content .table-tr:eq("+ i +") .table-td-use .hours").text(useTimeHours)
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
        let seq = $(this).attr('data-seq')
        let detailLimit = 8
        let detailPage = 1
        window.location.href = '/customer/coupon/details?seq=' + seq + '&limit=' + detailLimit + '&page=' + detailPage
    })
</script>
@endsection