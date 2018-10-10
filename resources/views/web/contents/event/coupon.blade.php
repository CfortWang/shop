@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" type="text/css" media="all" href="/css/daterangepicker.css" />
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb pdd">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="请输入商品名称查找">
                                <button class="search-btn">搜索</button>
                            </div>
                            <div class="create-pdd">
                                <span>新建拼豆豆</span>
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
                                    <div class="use">已使用</div>
                                    <div class="getRate">领取率</div>
                                    <div class="useRate">使用率</div>
                                    <div class="status">状态</div>
                                    <div class="operating">操作</div>
                                </div>
                                <div class="table-content"></div>
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
    var pageCount
    var keyword = ''
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/shop/couponList',
            type: 'get',
            dataType: 'json',
            data: {
                keyword: keyword
            },
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data
                console.log(resData)
                var $tr = '<div class="table-tr clear-fix"><div class="table-td-name"></div><div class="table-td-price"><p class="new-price"></p><p class="old-price"><del></del></p></div><div class="table-td-effective"></div><div class="table-td-organize"></div><div class="table-td-join"></div><div class="table-td-success"></div><div class="table-td-used"></div><div class="table-td-notuse"></div><div class="table-td-rate"></div><div class="operating"><span class="shelf"></span><span class="obtained"></span><span class="modify">&nbsp;&nbsp;&nbsp;&nbsp;修改</span></div></div>'
                for (let i = 0; i < resData.length; i++) {
                    $('.table-content').append($tr)
                    let groupName = resData[i].title
                    let newPrice = "￥" + resData[i].discounted_price
                    let oldPrice = "原价：" + resData[i].price
                    let effective = resData[i].effective_day.split(' ')[0]
                    let groupNum = resData[i].group
                    let joinNum = resData[i].join_number
                    let usedNum = resData[i].used
                    let unusedNum = resData[i].unused
                    let successNum = usedNum + unusedNum
                    let rate = usedNum + '/' + successNum
                    let status = resData[i].product_status
                    let id = resData[i].id
                    if (status == 0) {
                        $(".table-content .table-tr:eq("+ i +") .operating .obtained").text("下架")
                    }
                    if (status == 1) {
                        $(".table-content .table-tr:eq("+ i +") .operating .shelf").text("上架")
                    }
                    $(".table-content .table-tr:eq("+ i +") .operating").attr({"data-id": id, "data-status": status})
                    $(".table-content .table-tr:eq("+ i +") .table-td-name").text(groupName)
                    $(".table-content .table-tr:eq("+ i +") .table-td-price .new-price").text(newPrice)
                    $(".table-content .table-tr:eq("+ i +") .table-td-price .old-price del").text(oldPrice)
                    $(".table-content .table-tr:eq("+ i +") .table-td-effective").text(effective)
                    $(".table-content .table-tr:eq("+ i +") .table-td-organize").text(groupNum)
                    $(".table-content .table-tr:eq("+ i +") .table-td-join").text(joinNum)
                    $(".table-content .table-tr:eq("+ i +") .table-td-success").text(successNum)
                    $(".table-content .table-tr:eq("+ i +") .table-td-used").text(usedNum)
                    $(".table-content .table-tr:eq("+ i +") .table-td-notuse").text(unusedNum)
                    $(".table-content .table-tr:eq("+ i +") .table-td-rate").text(rate)

                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawList();

    var changeStatus = function (event1, event2, that) {
        $.ajax({
            url: 'http://shop.test/api/event/status',
            type: 'put',
            dataType: 'json',
            data: {
                id: event1,
                status: event2
            },
            success: function (res) {
                if (res.code != 200) {
                    console.log(res.message);
                } else {
                    if (that.parent().attr("data-status") == 0) {
                        that.parent().attr("data-status", 1)
                        that.text("上架")
                    } else {
                        that.parent().attr("data-status", 0)
                        that.text("下架")
                    }
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }

    $(".search-btn").on("click", function () {
        keyword = $(".search-input").val()
        drawList();
        $(".search-input").val("")
    })

    $(".create-pdd").on("click", function () {
        window.location.href = "/event/coupon/create"
    })

    $(".table-content").on("click", ".table-tr .operating .obtained, .table-tr .operating .shelf", function () {
        var id = $(this).parent().attr("data-id")
        var status = $(this).parent().attr("data-status")
        var that = $(this)
        changeStatus(id, status, that);
    })
</script>
@endsection
