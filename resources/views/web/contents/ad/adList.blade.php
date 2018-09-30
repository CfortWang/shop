@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb ad">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="create-ad">
                                <span>新建广告</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="coupon-table">
                            <div class="coupon-table">
                                <div class="table-title clear-fix">
                                    <div class="name">优惠券名称</div>
                                    <div class="worth">价值</div>
                                    <div class="condition">领取限制</div>
                                    <div class="effective">有效期</div>
                                    <div class="getTimes">领取人数/次</div>
                                    <div class="operating">操作</div>
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
    var limit = 1
    var page = 1
    var type = 'ing'
    var pageCount
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/ad/adList',
            type: 'get',
            dataType: 'json',
            data: {
                limit: limit,
                page: page
            },
            success: function (res) {
                console.log(res)
                // $(".table-content").empty()
                // let resData = res.data.scanUserList
                // console.log(resData)
                // let count = res.data.count
                // pageCount = Math.ceil(count / limit)
                // console.log(pageCount)
                // var $tr = '<div class="table-tr clear-fix"><div class="table-td-id"></div><div class="table-td-nickname"></div><div class="table-td-sex"></div><div class="table-td-age"></div><div class="table-td-first"><p class="years"></p><p class="hours"></p></div><div class="table-td-last"><p class="years"></p><p class="hours"></p></div><div class="table-td-frequency"></div><div class="table-td-count"></div><div class="see-more">查看更多</div></div>'
                // for (let i = 0; i < resData.length; i++) {
                //     $('.table-content').append($tr)
                //     if (resData[i].id == null || resData[i].id == '') {
                //         var id = '——'
                //     } else {
                //         var id = "+" + resData[i].id.split('@')[1] + " " + resData[i].id.split('@')[0]
                //     }
                //     let seq = resData[i].user
                //     let nickname = resData[i].nickname
                //     let gender = resData[i].gender
                //     let age = resData[i].age
                //     let firstTimeYears = resData[i].firstTime.split(' ')[0]
                //     let firstTimeHours = resData[i].firstTime.split(' ')[1]
                //     let endTimeYears = resData[i].endTime.split(' ')[0]
                //     let endTimeHours = resData[i].endTime.split(' ')[1]
                //     let percent = resData[i].rate
                //     let count = resData[i].scannedCount
                //     if (gender == null || gender == '') {
                //         gender = '——'
                //     }
                //     if (nickname == null || nickname == '') {
                //         nickname = '——'
                //     }
                //     $(".table-content .table-tr:eq("+ i +")").attr('data-seq', seq)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-id").text(id)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-nickname").text(nickname)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-sex").text(gender)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-age").text(age)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-first .years").text(firstTimeYears)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-first .hours").text(firstTimeHours)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-last .years").text(endTimeYears)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-last .hours").text(endTimeHours)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-frequency").text(percent)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-count").text(count)
                // }
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

    $(".create-pdd").on("click", function () {
        window.location.href = "/ad/createAD"
    })
</script>
@endsection
