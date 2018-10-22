@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb scan-user">
                    <div class="tpl-portlet">
                        <!-- <div class="tpl-portlet-title">
                            <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="">
                                <button class="search-btn">搜索</button>
                            </div>
                        </div> -->
                        <div class="tpl-echarts" id="coupon-table">
                            <div class="coupon-table">
                                <div class="table-title clear-fix">
                                    <div class="amount">金额</div>
                                    <div class="shopid">商家ID</div>
                                    <div class="bank">银行</div>
                                    <div class="ownerName">持卡人</div>
                                    <div class="bankID">银行卡号</div>
                                    <div class="signTime">申请日期</div>
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
                                <button type="button" class="am-btn am-btn-secondary am-radius cashout" data-am-modal="{target: '#my-popup'}">提现</button>
                            </div>
                        </div>
                        <div class="am-popup" id="my-popup">
                            <div class="am-popup-inner">
                                <div class="am-popup-hd">
                                <h4 class="am-popup-title">提现申请</h4>
                                <span data-am-modal-close
                                        class="am-close">&times;</span>
                                </div>
                                <div class="am-popup-bd">
                                    <div class="form-group clear-fix">
                                        <div class="cashout-title">可提现积分</div>
                                        <div class="cashout-content">
                                            <input type="text" class="form-control" id="point" name="point">
                                        </div>
                                    </div>
                                    <div class="form-group clear-fix">
                                        <div class="cashout-title">金额</div>
                                        <div class="cashout-content">
                                            <input type="number" class="form-control" id="amount" name="amount" placeholder="积分与人民币提现比例为100：1，每次提现不得少于20000积分" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="form-group clear-fix">
                                        <div class="cashout-title">银行</div>
                                        <div class="cashout-content">
                                            <input type="text" class="form-control" id="bank_name" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="form-group clear-fix">
                                        <div class="cashout-title">银行卡号</div>
                                        <div class="cashout-content">
                                            <input type="text" class="form-control" id="bank_id" name="bank_id">
                                        </div>
                                    </div>
                                    <div class="form-group clear-fix">
                                        <div class="cashout-title">账户名</div>
                                        <div class="cashout-content">
                                            <input type="text" class="form-control" id="account" name="account">
                                        </div>
                                    </div>
                                </div>
                                <div class="cashout-btn-box">
                                    <button type="button" class="am-btn am-btn-primary sign-up">申请</button>
                                    <button type="button" class="am-btn am-btn-warning" data-am-modal="{target: '#my-popup'}">取消</button>
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
            url: 'http://shop.test/api/account/cashList',
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
                    var $tr = '<div class="table-tr clear-fix"><div class="table-td-amount"></div><div class="table-td-shopid"></div><div class="table-td-bank"></div><div class="table-td-owner"></div><div class="table-td-bankid"></div><div class="table-td-sign"><p class="years"></p><p class="hours"></p></div><div class="table-td-status"></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        // let seq = resData[i].seq
                        let amount = resData[i].amount
                        let shopID = resData[i].id
                        let bankName = resData[i].bank_name
                        let owner = resData[i].account_holder
                        let bankID = resData[i].account_number
                        let signYears = resData[i].created_at.split(' ')[0]
                        let signHours = resData[i].created_at.split(' ')[1]
                        let status = resData[i].status
                        
                        // $(".table-content .table-tr:eq("+ i +")").attr('data-seq', seq)
                        $(".table-content .table-tr:eq("+ i +") .table-td-amount").text(amount)
                        $(".table-content .table-tr:eq("+ i +") .table-td-shopid").text(shopID)
                        $(".table-content .table-tr:eq("+ i +") .table-td-bank").text(bankName)
                        $(".table-content .table-tr:eq("+ i +") .table-td-owner").text(owner)
                        $(".table-content .table-tr:eq("+ i +") .table-td-bankid").text(bankID)
                        $(".table-content .table-tr:eq("+ i +") .table-td-sign .years").text(signYears)
                        $(".table-content .table-tr:eq("+ i +") .table-td-sign .hours").text(signHours)
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

    var getCashoutInfo = function () {
        $.ajax({
            url: 'http://shop.test/api/account/showBuyerInfo',
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let resData = res.data
                $("input#point").val(resData.point)
                $("input#bank_name").val(resData.bankName)
                $("input#bank_id").val(resData.bank_account)
                $("input#account").val(resData.bank_account_owner)
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    
    var Cashout = function (amount) {
        $.ajax({
            url: 'http://shop.test/api/account/requestCash',
            type: 'post',
            dataType: 'json',
            data: {
                modal_amount: amount
            },
            success: function (res) {
                if (res.code == 200) {
                    var $modal = $('#my-popup');
                    $modal.modal('close');
                    alert("提现成功")
                } else {
                    alert(res.message)
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }

    $(".cashout").on("click", function () {
        getCashoutInfo();
    })

    $(".sign-up").on("click", function () {
        let amount = $("input#amount").val()
        Cashout(amount);
    })

    $("input").attr("disabled", true)
    $("input#amount").attr("disabled", false)
</script>
@endsection
