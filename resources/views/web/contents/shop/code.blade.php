@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('nav')
<span>商家信息/我的喜豆码</span>
@endsection('nav')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb scan-user">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <ul class="code-tab">
                                <li class="code-tab-item tab-active" data-type="history">购买记录</li>
                                <li class="code-tab-item" data-type="mine">我的喜豆码</li>
                            </ul>
                        </div>
                        <div class="tpl-echarts" id="pdd-table">
                            <div class="buy-history" data-type="history">
                                <div class="table-title clear-fix">
                                    <div class="amount">数量</div>
                                    <div class="pay-way">支付方式</div>
                                    <div class="active-time">激活时间</div>
                                    <div class="status">状态</div>
                                </div>
                                <div class="table-content"></div>
                            </div>
                            <div class="my-code" data-type="mine">
                                <div class="table-title clear-fix">
                                    <div class="code">喜豆码</div>
                                    <div class="amount">数量（个）</div>
                                    <div class="used">已使用（个）</div>
                                    <div class="active-time">激活时间</div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    // var limit = 8
    var type = 'history'
    var page = 1
    var pageCount
    var drawBuyList = function () {
        $.ajax({
            url: '/api/packages/package_sales',
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data
                if (resData.length) {
                    $(".no-data").hide()
                    $(".pagination").show()
                    var $tr = '<div class="table-tr"><div class="table-td-amount"></div><div class="table-td-payment"></div><div class="table-td-create"><p class="years"></p><p class="hours"></p></div><div class="table-td-status"></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $(".buy-history .table-content").append($tr)
                        let amount = resData[i].total_quantity
                        let payment = resData[i].payment_type
                        let status = resData[i].status
                        let activeTimeYear = resData[i].created_at.split(' ')[0]
                        let activeTimeHour = resData[i].created_at.split(' ')[1]
                        let id = resData[i].seq
    
                        $(".buy-history .table-content .table-tr:eq("+ i +") .table-td-amount").attr("data-seq", id)
                        $(".buy-history .table-content .table-tr:eq("+ i +") .table-td-amount").text(amount)
                        $(".buy-history .table-content .table-tr:eq("+ i +") .table-td-payment").text(payment)
                        $(".buy-history .table-content .table-tr:eq("+ i +") .table-td-create .years").text(activeTimeYear)
                        $(".buy-history .table-content .table-tr:eq("+ i +") .table-td-create .hours").text(activeTimeHour)
                        $(".buy-history .table-content .table-tr:eq("+ i +") .table-td-status").text(status)
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
    drawBuyList();

    var drawCodeList = function () {
        $.ajax({
            url: '/api/packages/my_package',
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data
                if (resData.length) {
                    $(".no-data").hide()
                    $(".pagination").show()
                    var $tr = '<div class="table-tr"><div class="table-td-code"></div><div class="table-td-amount"></div><div class="table-td-used"></div><div class="table-td-create"><p class="years"></p><p class="hours"></p></div><div class="table-td-status"></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $(".my-code .table-content").append($tr)
                        let code = resData[i].code
                        let amount = resData[i].total_cnt
                        let used = resData[i].used_cnt
                        let status = resData[i].status
                        let activeTimeYear = resData[i].activated_at.split(' ')[0]
                        let activeTimeHour = resData[i].activated_at.split(' ')[1]
                        let id = resData[i].seq

                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-code").attr("data-seq", id)
                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-code").text(code)
                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-amount").text(amount)
                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-used").text(used)
                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-create .years").text(activeTimeYear)
                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-create .hours").text(activeTimeHour)
                        $(".my-code .table-content .table-tr:eq("+ i +") .table-td-status").text(status)
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

    $(".code-tab-item").on('click', function () {
        $(this).addClass("tab-active")
        $(this).siblings().removeClass("tab-active")
        type = $(this).attr("data-type")
        if (type == 'mine') {
            $(".buy-history").hide()
            $(".my-code").show()
            drawCodeList();
        } else {
            $(".buy-history").show()
            $(".my-code").hide()
            drawBuyList();
        }
    })

    $(".buy-history").on('click', ".table-td-amount", function () {
        let id = $(this).attr("data-seq")
        console.log(id)
        window.location.href = 'code/history?id=' + id
    })

    $(".my-code").on('click', ".table-td-code", function () {
        let id = $(this).attr("data-seq")
        console.log(id)
        window.location.href = 'code/details?id=' + id
    })
</script>
@endsection