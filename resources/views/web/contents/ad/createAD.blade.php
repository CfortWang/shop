@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/amazeui.datetimepicker.css">
@endsection('css')
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
                                        <input type="text" class="form-control" id="name" name="title" placeholder="最多可输入20个字符" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group image-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">广告图片</label>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 product">
                                        <a href="javascript:;" class="file">+添加图片
                                            <input type="file" class="" id="product-image" name="image[]" onchange="selectImage(this, '.product')">
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
                                        <input type="text" class="form-control" id="new-price" name="landing_url" placeholder="输入广告的跳转链接，为空则不跳转">
                                    </div>
                                </div>
                                <div class="form-group clear-fix">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">关联喜豆码</label>
                                    <div class="am-u-lg-4 am-u-md-5 am-u-sm-6 am-u-end">
                                        <select class="pkg-data" data-am-selected></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script src="/js/amazeui.datetimepicker.min.js"></script>
<script>

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
            console.log("最多只能选择1张图片")
            return false
        }
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"><input class="img-value" type="text" name="image[]" hidden></div>'
        $('.product').append($imgBox)
        image = evt.target.result;
        $('.product .image-remark').hide()
    }
    reader.readAsDataURL(file.files[0]);
    var fd = new FormData()
    fd.append('file', file.files[0])
    upLoadImage(fd);
    $(".product .file").hide()
}

function upLoadImage (file) {
    $.ajax({
        url: 'http://shop.test/api/event/upload',
        type: 'post',
        dataType: 'json',
        data: file,
        processData: false,
        contentType: false,
        success: function (res) {
            let url = res.data.url
            $('.product .selected-image:last-child .img-value').val(url)
            // console.log($('.product .selected-image:last-child .img-value'))
        },
        error: function (ex) {
            console.log(ex)
        }
    })
    // console.log(file)
}



function getPkgCode (file) {
    $.ajax({
        url: 'http://shop.test/api/ad/pkgList',
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < res.data.length; i++) {
                let $pkgData = '<option value="' + resData[i].pkg_seq + '">' + resData[i].pkg_code + '</option>'
                $(".pkg-data").append($pkgData)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
    // console.log(file)
}
getPkgCode();

$(".product").on("click", ".selected-image .delete-image", function () {
    $(this).parent().remove()
    var sonNum = $(".product").children().length
    if (sonNum == 2) {
        $(".product .image-remark").show()
        $(".product .file").show()
    }

})

</script>
@endsection
