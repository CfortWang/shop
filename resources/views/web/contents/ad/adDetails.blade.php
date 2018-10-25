@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/amazeui.datetimepicker.css">
@endsection('css')
@section('nav')
<span>广告/广告详情</span>
@endsection('nav')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <form id="submit" action="/api/ad/createAd" method="post"  enctype="multipart/form-data">
                <div class="tpl-portlet">
                    <div class="row ad-row">
                        <div class="am-u-md-12 am-u-sm-12">
                            <div class="form-container">
                                <div class="form-title">广告信息</div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">广告标题</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="最多可输入20个字符" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group image-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">广告图片</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 product">
                                        <a href="javascript:;" class="file">+添加图片
                                            <input type="file" class="" id="product-image" name="file" onchange="selectImage(this, '.product')">
                                        </a>
                                        <span class="image-remark">建议尺寸:1204*1204像素，仅支持gif,jpeg,png,bmp 4种格式，大小不超过3.0M</span>
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">投放时间</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control timepicker" id="ad-startDate" autocomplete="off" data-am-datepicker name="start_date">
                                        <span>-</span>
                                        <input type="text" class="form-control timepicker" id="ad-endDate" autocomplete="off" data-am-datepicker name="end_date">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">跳转链接</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                        <input type="text" class="form-control" id="landing-url" name="landing_url" placeholder="输入广告的跳转链接，为空则不跳转">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">关联喜豆码</label>
                                    <div class="am-u-lg-4 am-u-md-5 am-u-sm-6 am-u-end">
                                        <select class="pkg-data" name="pkgList[]" multiple data-am-selected="{maxHeight: 100}"></select>
                                    </div>
                                </div>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 am-u-end package-box"></div>
                            </div>
                            <input type="text" hidden name="id" id="id">
                            <input type="text" hidden name="is_code_modify" id="is_code_modify" value="0">
                        </div>
                    </div>
                </div>
                <div class="bottom-btn">
                    <div class="bottom-submit-btn">保存</div>
                    <div class="bottom-reset-btn">取消</div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script src="/js/amazeui.datetimepicker.min.js"></script>
<script>
var args = getArgs();
$("input[type=text][name=id]").val(args['id'])
tim = ''
var drawData = function () {
    $.ajax({
        url: '/api/adv/adDetail',
        type: 'get',
        dataType: 'json',
        data: {
            seq: args['id']
        },
        success: function (res) {
            console.log(res)
            let resData = res.data
            $("input#title").val(resData.title)
            $("input#landing-url").val(resData.landing_url)
            $("#ad-startDate").datepicker('setValue', resData.start_date)
            $("#ad-endDate").datepicker('setValue', resData.end_date)

            // 广告图
            $(".product .image-remark").hide()
            var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' + 'http://' + resData.shop_image_file + '"><input class="img-value" type="text" name="image" hidden value="' + resData.shop_image_file + '"></div>'
            $('.product').append($imgBox)
            $(".product .file").hide()
            isImageModify = 0

            // // 喜豆码
            pkgdata = resData.pkgList
            for (let i = 0; i < pkgdata.length; i++) {
                let $pkg = '<div class="package" data-value="' + pkgdata[i].seq + '"><div class="delete-pkg"><img src="/img/main/delete.png" alt=""></div><div class="package-code">' + pkgdata[i].code + '</div></div>'
                $(".package-box").append($pkg)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}
drawData();

var nowTemp = new Date();
var nowDay = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0).valueOf();
var nowMoth = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), 1, 0, 0, 0, 0).valueOf();
var nowYear = new Date(nowTemp.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
var $startDate = $('#ad-startDate');

// 广告投放时间
var checkin = $startDate.datepicker({
    onRender: function(date, viewMode) {
    // 默认 days 视图，与当前日期比较
    var viewDate = nowDay;
    switch (viewMode) {
        // moths 视图，与当前月份比较
        case 1:
        viewDate = nowMoth;
        break;
        // years 视图，与当前年份比较
        case 2:
        viewDate = nowYear;
        break;
    }

    return date.valueOf() < viewDate ? 'am-disabled' : '';
    }
}).on('changeDate.datepicker.amui', function(ev) {
    if (ev.date.valueOf() > checkout.date.valueOf()) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate() + 1);
        checkout.setValue(newDate);
    }
    checkin.close();
    $('#ad-endDate')[0].focus();
}).data('amui.datepicker');

var checkout = $('#ad-endDate').datepicker({
    onRender: function(date, viewMode) {
    var inTime = checkin.date;
    var inDay = inTime.valueOf();
    var inMoth = new Date(inTime.getFullYear(), inTime.getMonth(), 1, 0, 0, 0, 0).valueOf();
    var inYear = new Date(inTime.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();

    // 默认 days 视图，与当前日期比较
    var viewDate = inDay;

    switch (viewMode) {
        // moths 视图，与当前月份比较
        case 1:
        viewDate = inMoth;
        break;
        // years 视图，与当前年份比较
        case 2:
        viewDate = inYear;
        break;
    }

    return date.valueOf() <= viewDate ? 'am-disabled' : '';
    }
}).on('changeDate.datepicker.amui', function(ev) {
    checkout.close();
}).data('amui.datepicker');


function selectImage(file) {
    if (!file.files || !file.files[0]) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        var sonNum = $('.product').children().length
        if (sonNum > 2) {
            toastr.error("最多只能选择1张图片")
            return false
        }
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"><input class="img-value" type="text" name="image[]" hidden></div>'
        $('.product').append($imgBox)
        image = evt.target.result;
        $('.product .image-remark').hide()
    }
    reader.readAsDataURL(file.files[0]);
    adData = new FormData()
    adData.append('ad_image_file', file.files[0])
    $(".product .file").hide()
}

function getPkgCode (file) {
    $.ajax({
        url: '/api/adv/pkgList',
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < res.data.length; i++) {
                let $pkgData = '<option value="' + resData[i].pkg_seq + '">' + resData[i].pkg_code + '</option>'
                $(".pkg-data").append($pkgData)
            }
            if (pkgdata != null || pkgdata != '') {
                codeArr = []
                seqArr = []
                for (let i = 0; i < pkgdata.length; i++) {
                    let $pkgData = '<option value="' + pkgdata[i].seq + '">' + pkgdata[i].code + '</option>'
                    $(".pkg-data").append($pkgData)
                    codeArr[i] = pkgdata[i].code
                    seqArr[i] = pkgdata[i].seq
                }
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}
getPkgCode();
setTimeout(() => {
    let allPkgList = $(".am-selected-list > li")
    for (let i = 0; i < pkgdata.length; i++) {
        for (let j = 0; j < allPkgList.length; j++) {
            let pkgSeq = $(".am-selected-list > li:eq("+ j +")").attr("data-value")
            if (pkgSeq == seqArr[i]) {
                $("select.pkg-data").find("option[value = '"+seqArr[i]+"']").attr("selected","selected")
                $(".am-selected-list > li:eq("+ j +")").addClass("am-checked")
            }
        }
    }
    $(".am-selected-status").text(codeArr)
}, 1000);

$(".product").on("click", ".selected-image .delete-image", function () {
    $(this).parent().remove()
    var sonNum = $(".product").children().length
    if (sonNum == 2) {
        $(".product .image-remark").show()
        $(".product .file").show()
    }
    isImageModify = 1
})

$("body").on("click", ".am-selected-list > li", function () {
    let selectedPkg = $(".package-box > div").length
    let liClass = $(this).attr("class")
    let pkgCode = $(this).children('span').text()
    let pkgValue = $(this).attr("data-value")
    if (liClass == null || liClass == "") {
        for (let i = 0; i < selectedPkg; i++) {
            let unselect = $(".package-box .package:eq("+ i +")").attr("data-value")
            if (unselect == pkgValue) {
                $(".package-box .package:eq("+ i +")").remove()
            }
        }
    } else {
        let $pkg = '<div class="package" data-value="' + pkgValue + '"><div class="delete-pkg"><img src="/img/main/delete.png" alt=""></div><div class="package-code">' + pkgCode + '</div></div>'
        $(".package-box").append($pkg)
    }
    $("#is_code_modify").val("1")
})

$(".package-box").on("click", ".delete-pkg", function () {
    $(this).parent().remove()
    let optionList = $(".am-selected-list > li").length
    let pkgList = $(".package-box .package").length
    let pkgValue = $(this).parent().attr("data-value")
    let pkgArr = []
    for (let j = 0; j < pkgList; j++) {
        pkgArr[j] = $(".package-box .package:eq("+ j +") .package-code").text()
    }
    for (let i = 0; i < optionList; i++) {
        let unselect = $(".am-selected-list > li:eq("+ i +")").attr("data-value")
        let pkgCode = $(".am-selected-list > li:eq("+ i +") span").text()
        if (unselect == pkgValue) {
            $(".am-selected-list > li:eq("+ i +")").removeClass("am-checked")
            $(".am-selected-status").text(pkgArr.join(','))
        }
    }
    $("#is_code_modify").val("1")
})

function modifyAD (adInfo) {
    $.ajax({
        url: '/api/adv/modifyAd',
        type: 'post',
        dataType: 'json',
        data: adInfo,
        processData: false,
        contentType: false,
        success: function (res) {
            toastr.success("修改成功")
            setTimeout(() => {
                window.location.href = '/ad/adList'
            }, 1500);
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}


$(".bottom-submit-btn").on("click", function () {
    let adName = $("#title").val()
    let adStartDate = $("#ad-startDate").val()
    let adEndDate = $("#ad-endDate").val()
    let adLandingUrl = $("#landing-url").val()
    let id = $("#id").val()
    let isCodeModify = $("#is_code_modify").val()
    let pkgList = $(".package-box .package").length
    let pkgArr = []
    for (let j = 0; j < pkgList; j++) {
        pkgArr[j] = $(".package-box .package:eq("+ j +")").attr("data-value")
    }

    if (adName == '' || adName == null) {
        toastr.error("广告标题不能为空")
        return false
    }
    if (adStartDate == '' || adStartDate == null) {
        toastr.error("广告投放开始时间不能为空")
        return false
    }
    if (adEndDate == '' || adEndDate == null) {
        toastr.error("广告投放结束时间不能为空")
        return false
    }
    // if (adLandingUrl == '' || adLandingUrl == null) {
    //     toastr.error("广告跳转链接不能为空")
    //     return false
    // }
    if (isImageModify == 0) {
        adData = new FormData()
    }
    adData.append("title", adName)
    adData.append("start_date", adStartDate)
    adData.append("end_date", adEndDate)
    adData.append("landing_url", adLandingUrl)
    adData.append("id", id)
    adData.append("is_code_modify", isCodeModify)

    for (let i = 0; i < pkgArr.length; i++) {
        adData.append("pkg_list[]", pkgArr[i])
    }

    modifyAD(adData)
    adData = new FormData()
})

$(".bottom-reset-btn").on("click", function () {
    window.location.href = window.location.href
})

</script>
@endsection
