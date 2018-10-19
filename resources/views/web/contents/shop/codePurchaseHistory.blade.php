@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet code-details">
                <div class="row">
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">商家ID：</label>
                        <div class="info-content" id="shop"></div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">销售合伙人ID：</label>
                        <div class="info-content" id="sale-partner"></div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">价格：</label>
                        <div class="info-content" id="price">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">总数：</label>
                        <div class="info-content" id="total-num">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">快递费：</label>
                        <div class="info-content" id="postage">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">总额：</label>
                        <div class="info-content" id="total-money">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">支付方式：</label>
                        <div class="info-content" id="payment">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">支付状态：</label>
                        <div class="info-content" id="pay-status">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">状态：</label>
                        <div class="info-content" id="status">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12 row-mb pdd">
                        <div class="tpl-portlet-title">
                            <!-- <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="请输入喜豆码编码查找">
                                <button class="search-btn">搜索</button>
                            </div> -->
                            <ul class="tab">
                                <li class="tab-item tab-active" data-type="direct">面对面交易</li>
                                <li class="tab-item" data-type="shipping">合伙人发货</li>
                                <li class="tab-item" data-type="hq_shipping">总部发货</li>
                            </ul>
                            <div class="status-filter">
                                <select data-am-selected="{btnStyle: 'secondary'}"></select>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="code-table">
                            <div class="code-table">
                                <div class="table-title clear-fix">
                                    <div class="code">喜豆码编码</div>
                                    <div class="code-type">喜豆码类型</div>
                                    <div class="start-code">起始码</div>
                                    <div class="end-code">结束码</div>
                                    <div class="status">状态</div>
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
    var getArgs = function () {
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
    var args = getArgs();
    var seq = args['id']

    var drawInfo = function () {
        $.ajax({
            url: 'http://shop.test/api/packages/package_sales/detail',
            type: 'get',
            dataType: 'json',
            data: {
                seq: seq
            },
            success: function (res) {
                $(".info-content").empty()
                console.log(res)
                let resData = res.data
                $("#shop").text(resData.buyer)
                $("#sale-partner").text(resData.sales_partner)
                $("#price").text(resData.total_sales_price)
                $("#total-num").text(resData.total_quantity)
                $("#postage").text(resData.total_shipping_price)
                $("#total-money").text(resData.total_price)
                $("#payment").text(resData.payment_type)
                $("#pay-status").text(resData.pay_status)
                $("#status").text(resData.status)
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawInfo();

    var limit = 8
    var page = 1
    var pageCount
    // var keyword = ''
    var selectStatus = ''
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/packages/package_sales/item',
            type: 'get',
            dataType: 'json',
            data: {
                limit: limit,
                page: page,
                seq: seq,
                status: selectStatus
            },
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data
                // let count = res.data.count
                // pageCount = Math.ceil(count / limit)
                var $tr = '<div class="table-tr clear-fix"><div class="table-td-code"></div><div class="table-td-active"><p class="years"></p><p class="hours"></p></div><div class="table-td-used"><p class="years"></p><p class="hours"></p></div><div class="table-td-status"></div></div>'
                for (let i = 0; i < resData.length; i++) {
                    $('.table-content').append($tr)
                    let code = resData[i].code
                    let activeTimeYears = resData[i].activated_at.split(' ')[0]
                    let activeTimeHours = resData[i].activated_at.split(' ')[1]
                    let status = resData[i].status
                    let id = resData[i].seq
                    console.log(resData[i].used_at)

                    if (resData[i].used_at == '' || resData[i].used_at == null) {
                        var useTimeYears = "——"
                        var useTimeHours = "——"
                    } else {
                        var useTimeYears = resData[i].used_at.split(' ')[0]
                        var useTimeHours = resData[i].used_at.split(' ')[1]
                    }

                    $(".table-content .table-tr:eq("+ i +") .table-td-code").text(code)
                    $(".table-content .table-tr:eq("+ i +") .table-td-active .years").text(activeTimeYears)
                    $(".table-content .table-tr:eq("+ i +") .table-td-active .hours").text(activeTimeHours)
                    $(".table-content .table-tr:eq("+ i +") .table-td-used .years").text(useTimeYears)
                    $(".table-content .table-tr:eq("+ i +") .table-td-used .hours").text(useTimeHours)
                    $(".table-content .table-tr:eq("+ i +") .table-td-status").text(status)
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    // drawList();


    $(".search-btn").on("click", function () {
        keyword = $(".search-input").val()
        drawList();
        $(".search-input").val("")
    })

    $("body").on("click", ".am-selected-list > li", function () {
        selectStatus = $(this).attr("data-value")
        drawList();
    })

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
