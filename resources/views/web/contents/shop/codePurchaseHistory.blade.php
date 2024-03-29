@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('nav')
<span>商家信息/喜豆码购买记录</span>
@endsection('nav')
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
                                <select data-am-selected="{btnStyle: 'secondary'}">
                                    <option value="registered">registered</option>
                                    <option value="out">out</option>
                                    <option value="sold">sold</option>
                                    <option value="activated">activated</option>
                                    <option value="loss">loss</option>
                                </select>
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
                            <button type="button" class="am-btn am-btn-secondary am-radius cashout" style="display: none" data-am-modal="{target: '#my-popup'}">接收</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    var args = getArgs();
    var seq = args['id']

    var drawInfo = function () {
        $.ajax({
            url: '/api/packages/package_sales/detail',
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
                if (resData.shipping_status == 'shipping') {
                    $(".cashout").show()
                } else {
                    $(".cashout").hide()
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawInfo();

    var type = 'direct'
    var limit = 8
    var page = 1
    var pageCount
    // var keyword = ''
    var selectStatus = ''
    var drawList = function () {
        $.ajax({
            url: '/api/packages/package_sales/item',
            type: 'get',
            dataType: 'json',
            data: {
                limit: limit,
                page: page,
                type: type,
                seq: seq,
                status: selectStatus
            },
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data.data
                let count = res.data.count
                if (count) {
                    $(".no-data").hide()
                    $(".pagination").show()
                    pageCount = Math.ceil(count / limit)
                    var $tr = '<div class="table-tr clear-fix"><div class="table-td-code"></div><div class="table-td-type"></div><div class="table-td-start"></div><div class="table-td-end"></div><div class="table-td-status"></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        let code = resData[i].code
                        let type = resData[i].type
                        let startCode = resData[i].start_q35code
                        let endCode = resData[i].end_q35code
                        let status = resData[i].status
                        // let id = resData[i].seq

                        $(".table-content .table-tr:eq("+ i +") .table-td-code").text(code)
                        $(".table-content .table-tr:eq("+ i +") .table-td-type").text(type)
                        $(".table-content .table-tr:eq("+ i +") .table-td-start").text(startCode)
                        $(".table-content .table-tr:eq("+ i +") .table-td-end").text(endCode)
                        $(".table-content .table-tr:eq("+ i +") .table-td-status").text(status)
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

    var changeStatus = function (id) {
        $.ajax({
            url: '/api/packages/received/' + id,
            type: 'put',
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    toastr.success("接收成功！")
                    setTimeout(() => {
                        window.location.href = window.location.href
                    }, 1000);
                } else {
                    toastr.error(res.message)
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }


    // $(".search-btn").on("click", function () {
    //     keyword = $(".search-input").val()
    //     drawList();
    //     $(".search-input").val("")
    // })

    $(".tab-item").on('click', function () {
        $(this).addClass("tab-active")
        $(this).siblings().removeClass("tab-active")
        type = $(this).attr("data-type")
        drawList();
    })

    $("body").on("click", ".am-selected-list > li", function () {
        selectStatus = $(this).attr("data-value")
        drawList();
    })

    $(".cashout").on('click', function () {
        var args = getArgs();
        var id = args['id']
        changeStatus(id)
    })
</script>
@endsection
