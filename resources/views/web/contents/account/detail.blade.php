@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('nav')
<span>账号信息/账户详情</span>
@endsection('nav')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <form id="submit" action="/api/ad/createAd" method="post"  enctype="multipart/form-data">
                <div class="tpl-portlet">
                    <div class="row">
                        <div class="am-u-md-12 am-u-sm-12">
                            <div class="form-container">
                                <div class="form-title">账户信息</div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">手机号</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="rep_phone_num" name="rep_phone_num" placeholder="最多可输入20个字符" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">姓名</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="rep_name" name="rep_name" placeholder="最多可输入20个字符" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">销售合伙人</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="partner_id" name="partner_id" placeholder="最多可输入20个字符" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">银行</label>
                                    <div class="am-u-lg-4 am-u-md-5 am-u-sm-6 am-u-end bank">
                                        <select class="pkg-data" id="bank_seq" name="bank_seq" data-am-selected="{maxHeight: 100}"></select>
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">银行卡号</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="bank_account" name="bank_account" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">账户名</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="bank_account_owner" name="bank_account_owner" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modify-btn">保存修改</div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script>

var drawData = function () {
    $.ajax({
        url: '/api/account/detail',
        type: 'get',
        async: false,
        dataType: 'json',
            success: function (res) {
            console.log(res)
            let resData = res.data
            $("#rep_phone_num").val(resData.rep_phone_num)
            $("#rep_name").val(resData.rep_name)
            $("#partner_id").val(resData.partner_id)
            $("#bank_seq").val(resData.bank)
            $("#bank_account").val(resData.bank_account)
            $("#bank_account_owner").val(resData.bank_account_owner)
            bankId = resData.bank
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}
drawData();

var getBank = function () {
    $.ajax({
        url: '/api/account/bank-list',
        type: 'get',
        dataType: 'json',
            success: function (res) {
            console.log(res)
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $bank = '<option value="'+ resData[i].seq +'">'+resData[i].name+'</option>'
                $(".pkg-data").append($bank)
            }
            $("select").find("option[value = "+bankId+"]").attr("selected","selected")
            $(".bank .am-selected-list li").removeClass("am-checked")
            $(".bank .am-selected-list").find("li[data-value = '" + bankId + "']").addClass("am-checked")
            let bb = $(".bank .am-selected-list").find("li[data-value = '" + bankId + "']").children("span").text()
            $(".bank .am-selected-status").text(bb)
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}
getBank();

var modifyInfo = function () {
    $.ajax({
        url: '/api/account/modify',
        type: 'post',
        dataType: 'json',
        data: {
            rep_name: $("#rep_name").val(),
            bank_account_owner: $("#bank_account_owner").val(),
            bank_seq: $("#bank_seq").val(),
            bank_account: $("#bank_account").val()
        },
        success: function (res) {
            console.log(res)
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}

$("input#rep_phone_num, input#partner_id").attr("disabled", true)

$(".modify-btn").on("click", function () {
    modifyInfo();
})

</script>
@endsection
