@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('nav')
<span>营销/优惠券</span>
@endsection('nav')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb pdd">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="@lang('event/coupon.list.search_text')">
                                <button class="search-btn">@lang('event/coupon.list.search_button')</button>
                            </div>
                            <div class="status-filter">
                                <select data-am-selected="{btnStyle: 'secondary'}">
                                    <option class="qq" value="processed"></option>
                                    <option value="registered"></option>
                                    <option value="overed"></option>
                                </select>
                            </div>
                            <div class="create-pdd">
                                <span>@lang('event/coupon.list.new_coupon')</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="coupon-table">
                            <div class="coupon-table">
                                <div class="table-title clear-fix">
                                    <div class="name">@lang('event/coupon.list.coupon_name')</div>
                                    <div class="worth">@lang('event/coupon.list.price')</div>
                                    <div class="condition">@lang('event/coupon.list.receive_limit')</div>
                                    <div class="effective">@lang('event/coupon.list.effective_at')</div>
                                    <div class="getTimes">@lang('event/coupon.list.receive_people')</div>
                                    <div class="use">@lang('event/coupon.list.used')</div>
                                    <div class="getRate">@lang('event/coupon.list.receive_rate')</div>
                                    <div class="useRate">@lang('event/coupon.list.use_rate')</div>
                                    <div class="status">@lang('event/coupon.list.status')</div>
                                    <div class="operating">@lang('event/coupon.list.action')</div>
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
                        <div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
                            <div class="am-modal-dialog">
                                <div class="am-modal-hd">
                                    <img src="/img/main/icon_warning.png" alt="">
                                    <span>确定下架该优惠券?</span>
                                </div>
                                <div class="am-modal-bd">优惠券下架后,买家无法再领取该优惠券；买家之前已领到的优惠券,在有效期内可继续使用。</div>
                                <div class="am-modal-footer">
                                    <span class="am-modal-btn give-up-btn" data-am-modal-cancel>取消</span>
                                    <span class="am-modal-btn ensure-btn" data-am-modal-confirm>确定</span>
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
    var keyword = ''
    var selectStatus = 'processed'
    var drawList = function () {
        $.ajax({
            url: '/api/shop/couponList',
            type: 'get',
            dataType: 'json',
            data: {
                limit: limit,
                page: page,
                coupon_name: keyword,
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
                    var $tr = '<div class="table-tr clear-fix"><div class="table-td-name"></div><div class="table-td-price"><p class="new-price"></p><p class="old-price"></p></div><div class="table-td-condition"><p class="new-price"></p><p class="old-price"></p></div><div class="table-td-effective"></div><div class="table-td-getTimes"></div><div class="table-td-used"></div><div class="table-td-getRate"></div><div class="table-td-useRate"></div><div class="table-td-status"></div><div class="operating"><span class="shelf"></span><span class="delete"></span><span class="obtained"></span><span class="modify" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;修改</span></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        let couponName = resData[i].coupon_name
                        let newPrice = resData[i].value
                        let oldPrice = resData[i].limit_money
                        let limitCount = resData[i].limit_count
                        let reserve = "库存：" + resData[i].reserve
                        let effective = resData[i].period_time
                        let peopleCount = resData[i].peopleCount
                        let receiveCount = resData[i].receiveCount
                        let useCount = resData[i].usedCount
                        let receive = resData[i].receiving_rate
                        let use = resData[i].used_rate
                        let status = resData[i].status
                        let statusValue = resData[i].statusValue
                        let id = resData[i].id

                        if (oldPrice == '' || oldPrice == null) {
                            oldPrice = "最低消费：—"
                        } else {
                            oldPrice = "最低消费：" + oldPrice
                        }

                        if (peopleCount == '' || peopleCount == null) {
                            peopleCount = '-'
                        }
                        if (receiveCount == '' || receiveCount == null) {
                            receiveCount = '-'
                        }
                        let statistics = peopleCount + '/' + receiveCount


                        if (statusValue == 'processed') {
                            $(".table-content .table-tr:eq("+ i +") .operating .obtained").text("下架")
                        }
                        if (statusValue == "registered") {
                            $(".table-content .table-tr:eq("+ i +") .operating .shelf").text("上架")
                            $(".table-content .table-tr:eq("+ i +") .operating .modify").css("display", 'inline')
                        }
                        if (statusValue == "overed") {
                            $(".table-content .table-tr:eq("+ i +") .operating .delete").text("删除")
                        }
                        $(".table-content .table-tr:eq("+ i +") .operating").attr({"data-id": id, "data-status": statusValue})
                        $(".table-content .table-tr:eq("+ i +") .table-td-name").text(couponName)
                        $(".table-content .table-tr:eq("+ i +") .table-td-price .new-price").text(newPrice)
                        $(".table-content .table-tr:eq("+ i +") .table-td-price .old-price").text(oldPrice)
                        $(".table-content .table-tr:eq("+ i +") .table-td-condition .new-price").text(limitCount)
                        $(".table-content .table-tr:eq("+ i +") .table-td-condition .old-price").text(reserve)
                        $(".table-content .table-tr:eq("+ i +") .table-td-effective").text(effective)
                        $(".table-content .table-tr:eq("+ i +") .table-td-getTimes").text(statistics)
                        $(".table-content .table-tr:eq("+ i +") .table-td-used").text(useCount)
                        $(".table-content .table-tr:eq("+ i +") .table-td-getRate").text(receive)
                        $(".table-content .table-tr:eq("+ i +") .table-td-useRate").text(use)
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

    var getStatus = function () {
        $.ajax({
            url: '/api/shop/statusList',
            type: 'get',
            dataType: 'json',
            success: function (res) {
                let resData = res.data
                for (let i = 0; i < 3; i++) {
                    $(".status-filter select option:eq("+ i +")").text(resData[i].value)
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    getStatus();

    var changeStatus = function (event1, event2, that) {
        $.ajax({
            url: '/api/shop/couponStatus',
            type: 'put',
            dataType: 'json',
            data: {
                id: event1,
                status: event2
            },
            success: function (res) {
                let resData = res.data
                if (res.code != 200) {
                    toastr.error(res.message)
                } else {
                    if (that.parent().attr("data-status") == "registered") {
                        that.parent().attr("data-status", "processed")
                        that.parent().parent().children(".table-td-status").text("进行中")
                        that.text("下架")
                        that.parent().children(".modify").css("display", "none")
                    } else {
                        that.parent().attr("data-status", "registered")
                        that.parent().parent().children(".table-td-status").text("未开始")
                        that.parent().children(".modify").css("display", "inline")
                        that.text("上架")
                    }
                    toastr.success(res.message)
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }

    var deleteCoupon = function (event1, event2, that) {
        $.ajax({
            url: '/api/shop/deleteCoupon',
            type: 'delete',
            dataType: 'json',
            data: {
                id: event1
            },
            success: function (res) {
                if (res.code != 200) {
                    toastr.error(res.message);
                } else {
                    drawList();
                    toastr.success(res.message);
                }

            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }

    toastr.options = {
        closeButton: false,
        debug: false,
        progressBar: false,
        positionClass: "toast-top-center",
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "1500",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };

    $(".search-btn").on("click", function () {
        keyword = $(".search-input").val()
        drawList();
        $(".search-input").val("")
    })

    $("body").on("click", ".am-selected-list > li", function () {
        selectStatus = $(this).attr("data-value")
        drawList();
    })

    $(".create-pdd").on("click", function () {
        window.location.href = "/event/coupon/create"
    })

    $(".table-content").on("click", ".table-tr .operating .obtained, .table-tr .operating .shelf", function () {
        var id = $(this).parent().attr("data-id")
        console.log(id)
        var status = $(this).parent().attr("data-status")
        var that = $(this)
        if (status == 'processed') {
            $('#my-confirm').modal({
                relatedTarget: this,
                onConfirm: function(options) {
                    let that = $(this.relatedTarget)
                    let id = that.parent().attr("data-id")
                    changeStatus(id, status, that);
                },
                // closeOnConfirm: false,
                onCancel: function() {}
            });
        } else {
            changeStatus(id, status, that);
        }
    })

    $(".table-content").on("click", ".table-tr .operating .delete", function () {
        var id = $(this).parent().attr("data-id")
        var status = $(this).parent().attr("data-status")
        var that = $(this)
        deleteCoupon(id, status, that);
    })

    $(".table-content").on("click", ".table-tr .operating .modify", function () {
        var id = $(this).parent().attr("data-id")
        window.location.href = '/event/coupon/details?id=' + id
    })

</script>
@endsection
