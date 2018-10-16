@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/eventMessage.css">
<link rel="stylesheet" href="/css/amazeui.datetimepicker.css">
@endsection('css')
@section('nav')
<span>营销/新建消息通知</span>
@endsection('nav')
@section('content')
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-content-wrapper">
        <form id="submit" action="/api/event/message" method="post"  enctype="multipart/form-data">
            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-12">消息推送类型</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-12">
                                    <select name="message_type" id="message_type" data-am-selected>
                                        <option value="1">喜豆APP内消息通知</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">群发对象</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 coupon-modus">
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="object_type1" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-6">
                                            <input type="radio" checked hidden id="object_type1" name="object_type" value="0">
                                            <label for="object_type1" class="time-radio"></label>
                                            <span>输入手机号</span>
                                        </label>
                                        <div class="am-u-lg-10 am-u-md-8 am-u-sm-6">
                                            <input type="text" class="start-hours">
                                            <span class="add-time" onclick="addPhoneNum()">+添加手机号码</span>
                                        </div>
                                        <div class="am-u-lg-12 am-u-md-12 am-u-sm-12 phone-num-box"></div>
                                    </div>
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="object_type2" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-6">
                                            <input type="radio" hidden id="object_type2" name="object_type" value="1">
                                            <label for="object_type2" class="time-radio"></label>
                                            <span>按人群筛选</span>
                                        </label>
                                        <div class="am-u-lg-10 am-u-md-8 am-u-sm-6">
                                            <select name="object_type" id="object_type3" data-am-selected>
                                                <option value="2">沉默用户</option>
                                                <option value="3">拼豆成功未使用用户</option>
                                                <option value="4">领取优惠券未使用用户</option>
                                                <option value="5">拼豆失败用户</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-12">推送内容</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-12 rule-box">
                                    <textarea class="rule-text push-content" name="content" id="" cols="" rows="" placeholder="请输入推送内容" maxlength="300"></textarea>
                                </div>
                            </div>

                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">发送时间</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 coupon-modus">
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="send_at1" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-12">
                                            <input type="radio" checked hidden id="send_at1" name="send_at" value="0">
                                            <label for="send_at1" class="time-radio"></label>
                                            <span>立即发送</span>
                                        </label>
                                        <label for="send_at2" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-6">
                                            <input type="radio" hidden id="send_at2" name="send_at" value="1">
                                            <label for="send_at2" class="time-radio"></label>
                                            <span>定时发送</span>
                                        </label>
                                        <div class="am-u-lg-8 am-u-md-4 am-u-sm-6">
                                            <input type="text" class="effect-time" autocomplete="off" name="send_at" placeholder="请选择日期">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-btn">
                <div class="bottom-submit-btn">提交审核</div>
                <div class="bottom-reset-btn">取消</div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="/js/amazeui.datetimepicker.min.js"></script>
<script>

$("#object_type3, .effect-time").attr("disabled", true)

$('input[type=radio][name=object_type]').change(function() {
    if (this.value == 0) {
        $(this).parent().siblings().children(".start-hours").attr("disabled", false)
        $(this).parent().parent().siblings().find("#object_type3").attr("disabled", true)
        $(this).parent().parent().siblings().find(".am-selected-btn").attr("disabled", true)
        $(".phone-num-box").show()
    } else if (this.value == 1) {
        $(this).parent().siblings().find("#object_type3").attr("disabled", false)
        $(this).parent().parent().siblings().find(".start-hours").attr("disabled", true)
        $(this).parent().siblings().find(".am-selected-btn").attr("disabled", false)
        $(".phone-num-box").hide()
    }
})

$('input[type=radio][name=send_at]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().find(".effect-time").attr("disabled", true)
    } else if (this.value == 1) {
        $(this).parent().parent().find(".effect-time").attr("disabled", false)
    }
})

$("body").on("click", ".pkg .am-selected-list > li", function () {
    let selectedPkg = $(".phone-num-box > div").length
    let liClass = $(this).attr("class")
    let pkgCode = $(this).children('span').text()
    let pkgValue = $(this).attr("data-value")
    if (liClass == null || liClass == "") {
        for (let i = 0; i < selectedPkg; i++) {
            let unselect = $(".phone-num-box .package:eq("+ i +")").attr("data-value")
            if (unselect == pkgValue) {
                $(".phone-num-box .package:eq("+ i +")").remove()
            }
        }
    } else {
        
    }
})

$(".phone-num-box").on("click", ".delete-pkg", function () {
    $(this).parent().remove()
    let optionList = $(".am-selected-list > li").length
    let pkgList = $(".phone-num-box .package").length
    let pkgValue = $(this).parent().attr("data-value")
    let pkgArr = []
    if (!pkgList) {
        $(".phone-num-box").hide()
    }
    for (let j = 0; j < pkgList; j++) {
        pkgArr[j] = $(".phone-num-box .package:eq("+ j +") .package-code").text()
    }
    for (let i = 0; i < optionList; i++) {
        let unselect = $(".am-selected-list > li:eq("+ i +")").attr("data-value")
        let pkgCode = $(".am-selected-list > li:eq("+ i +") span").text()
        if (unselect == pkgValue) {
            $(".pkg .am-selected-list > li:eq("+ i +")").removeClass("am-checked")
            $(".pkg .am-selected-status").text(pkgArr.join(','))
        }
    }
})

var k = 0
function addPhoneNum () {
    let phoneNum = $(".start-hours").val()
    if (phoneNum == '' || phoneNum == null) {
        alert("手机号码不能为空")
        return false
    }
    let phoneName = 'phone_num[' + k + ']'
    k++
    let $pkg = '<div class="package"><div class="delete-pkg"><img src="/img/main/delete.png" alt=""></div><div class="package-code">' + phoneNum + '</div><input name="' + phoneName + '" value="' + phoneNum + '" hidden></div>'
    $(".phone-num-box").append($pkg)
    $(".phone-num-box").show()
    $(".start-hours").val("")
}



$('.effect-time').datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    // autoclose: true,
    todayHighlight: true,
    startView: 'year'
});

$(".bottom-submit-btn").on("click", function () {
    var aa = $("#submit").serialize()
    // $("#submit").submit();
    $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: $("#submit").attr('action'),
        data: $("#submit").serialize(),
        success: function(data, status, x) {
            console.log(data);
            console.log(status);
        }
    });
})

</script>
@endsection