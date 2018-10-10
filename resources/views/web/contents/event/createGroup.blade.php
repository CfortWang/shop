@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/amazeui.datetimepicker.css">
@endsection('css')
@section('content')
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-content-wrapper">
        <form id="submit" action="/api/event/groupon" method="post"  enctype="multipart/form-data">
            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-title">拼豆豆基本信息</div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆豆名称</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="name" name="title" placeholder="最多可输入20个字符" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">原价格</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="old-price" id="old-price" name="price" placeholder="输入拼豆商品原价">
                                        <div class="price-unit">元</div>
                                    </div>
                                    <span class="image-remark">请设置大于0的金额数字</span>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆后价格</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="new-price" id="new-price" name="discounted_price" placeholder="输入拼豆商品原价">
                                        <div class="price-unit">元</div>
                                    </div>
                                    <span class="image-remark">请设置大于0的金额数字</span>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆活动时间</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control timepicker" id="pdd-startDate" autocomplete="off" data-am-datepicker name="open_time">
                                    <span>-</span>
                                    <input type="text" class="form-control timepicker" id="pdd-endDate" autocomplete="off" data-am-datepicker name="close_time">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆发起后持续时间</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 continued-time">
                                    <label for="continue-time1" class="label-radio">
                                        <input type="radio" checked hidden id="continue-time1" name="continued_time" value="48">
                                        <label for="continue-time1" class="time-radio"></label>
                                        <span>48小时</span>
                                    </label>
                                    <label for="continue-time2" class="label-radio">
                                        <input type="radio" hidden id="continue-time2" name="continued_time" value="72">
                                        <label for="continue-time2" class="time-radio"></label>
                                        <span>72小时</span>
                                    </label>
                                    <label for="continue-time3" class="label-radio">
                                        <input type="radio" hidden id="continue-time3" name="continued_time" value="120">
                                        <label for="continue-time3" class="time-radio"></label>
                                        <span>120小时</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">成团人数</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="group-size" id="group-size" name="group_size" placeholder="输入成团人数">
                                    </div>
                                    <span class="image-remark">最高设置20个人</span>
                                </div>
                            </div>
                            <div class="form-group image-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">商品图片</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 product">
                                    <a href="javascript:;" class="file">+添加图片
                                        <input type="file" class="" id="product-image" name="image[]" onchange="selectImage(this, '.product')">
                                    </a>
                                    <span class="image-remark">建议尺寸:1204*1204像素,最多上传15张,仅支持gif,jpeg,png,bmp 4种格式,大小不超过3.0M</span>
                                </div>
                            </div>
                            <div class="form-group image-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">列表封面图</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 list">
                                    <a href="javascript:;" class="file">+添加图片
                                        <input type="file" class="" id="product-image" name="image[]" onchange="selectImage(this, '.list')">
                                    </a>
                                    <span class="image-remark">建议尺寸:1204*1204像素,最多上传1张,仅支持gif,jpeg,png,bmp 4种格式,大小不超过3.0M</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-title">拼豆商品包含内容</div>
                        </div>
                        <div class="pdd-table-head clear-fix">
                            <div class="am-u-lg-4 am-u-md-4 am-u-sm-4">套餐内详细内容名称</div>
                            <div class="am-u-lg-2 am-u-md-3 am-u-sm-3">份数</div>
                            <div class="am-u-lg-2 am-u-md-3 am-u-sm-3 am-u-end">所值价格 (元)</div>
                        </div>
                        <div class="package-data"></div>
                        <div class="pdd-table-tr clear-fix">
                            <div class="am-u-lg-4 am-u-md-4 am-u-sm-4">
                                <input type="text" class="form-control" id="package-name">
                            </div>
                            <div class="am-u-lg-2 am-u-md-3 am-u-sm-3">
                                <input type="number" class="form-control" id="package-amount">
                            </div>
                            <div class="am-u-lg-2 am-u-md-3 am-u-sm-3">
                                <input type="number" class="form-control" id="package-price">
                            </div>
                            <div class="am-u-lg-4 am-u-md-2 am-u-sm-2 am-u-end sure-add">
                                <div class="sure-add-btn" onclick="addPackageInfo()">确定添加</div>
                            </div>
                        </div>
                        <div class="remark-title">备注:</div>
                        <div class="remark-data"></div>
                        <div class="am-u-lg-5 am-u-md-5 am-u-sm-6 package-remark">
                            <input type="text" class="form-control" id="package-remark">
                        </div>
                        <div class="am-u-lg-7 am-u-md-7 am-u-sm-6 am-u-end remark-add">
                            <div class="remark-add-btn" onclick="addRemarkInfo()">确定添加</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-title pdd-success-title">拼豆成功后优惠使用须知</div>
                        </div>
                        <div class="dividing"></div>
                        <div class="choose-time">
                            <div class="choose-title">拼豆成功后优惠有效期</div>
                            <div class="fixed-time">
                                <div class="fixed-time-option1">
                                    <label for="effectRadio1" class="label-radio">
                                        <input type="radio" id="effectRadio1" value="1" checked hidden name="is_effective_fixed">
                                        <label for="effectRadio1" class="time-radio"></label>
                                        <span>固定日期</span>
                                    </label>
                                    <span class="time-kind">生效时间：</span>
                                    <input type="text" class="effect-time" autocomplete="off" name="effective_start_at" data-am-datepicker placeholder="请选择日期">
                                    <span class="time-kind">过期时间：</span>
                                    <input type="text" class="expired-time" autocomplete="off" name="effective_end_at" data-am-datepicker placeholder="请选择日期">
                                    
                                </div>
                                <div class="fixed-time-option2">
                                    <label for="effectRadio2" class="label-radio">
                                        <input type="radio" id="effectRadio2" value="0" hidden name="is_effective_fixed">
                                        <label for="effectRadio2" class="time-radio"></label>
                                        <span>拼豆成功后当日开始</span>
                                    </label>
                                    <input type="number" name="effective_days" id="" class="effective-days" placeholder="请输入天数">
                                    <span>天内有效</span>
                                    <span class="effective-remark">(生效天数必须在1-365之间)</span>
                                </div>
                            </div>
                        </div>
                        <div class="dividing"></div>
                        <div class="effective-time">
                            <div class="random-time option-disabled">
                                <label for="timeRadio1" class="label-radio">
                                    <input type="radio" id="timeRadio1" value="0" checked hidden name="is_usetime_limit">
                                    <label for="timeRadio1" class="time-radio"></label>
                                    <span>有效期内任意时间段可用</span>
                                </label>
                            </div>
                            <div class="sectiom-time">
                                <label for="timeRadio2" class="label-radio">
                                    <input type="radio" id="timeRadio2" value="1" hidden name="is_usetime_limit">
                                    <label for="timeRadio2" class="time-radio"></label>
                                    <span>有效期内部分时间段可用</span>
                                </label>
                                <div class="section-time-weekends">
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox1" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox1" value="1" hidden name="days[]">
                                            <label for="weekendCheckbox1" class="weekend-checkbox"></label>
                                            <span>周一</span>
                                        </label>
                                    </div>
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox2" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox2" value="2" hidden name="days[]">
                                            <label for="weekendCheckbox2" class="weekend-checkbox"></label>
                                            <span>周二</span>
                                        </label>
                                    </div>
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox3" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox3" value="3" hidden name="days[]">
                                            <label for="weekendCheckbox3" class="weekend-checkbox"></label>
                                            <span>周三</span>
                                        </label>
                                    </div>
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox4" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox4" value="4" hidden name="days[]">
                                            <label for="weekendCheckbox4" class="weekend-checkbox"></label>
                                            <span>周四</span>
                                        </label>
                                    </div>
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox5" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox5" value="5" hidden name="days[]">
                                            <label for="weekendCheckbox5" class="weekend-checkbox"></label>
                                            <span>周五</span>
                                        </label>
                                    </div>
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox6" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox6" value="1" hidden name="is_weekend">
                                            <label for="weekendCheckbox6" class="weekend-checkbox"></label>
                                            <span>周末</span>
                                        </label>
                                    </div>
                                    <div class="weekends-day">
                                        <label for="weekendCheckbox7" class="label-radio">
                                            <input type="checkbox" id="weekendCheckbox7" value="1" hidden name="is_festival">
                                            <label for="weekendCheckbox7" class="weekend-checkbox"></label>
                                            <span>节假日</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="hours-choose">
                                    <div class="customize"></div>
                                    <input type="text" class="start-hours">
                                    <span>-</span>
                                    <input type="text" class="end-hours">
                                    <span class="add-time" onclick="addCustomize()">+添加时间段</span>
                                    <span class="effective-remark">(请按照24小时制输入可用时段，最多添加三个)</span>
                                </div>
                            </div>
                        </div>

                        <div class="dividing"></div>
                        <div class="use-rule">
                            <div class="am-u-lg-1 am-u-md-2 am-u-sm-3 rule-title">
                            使用规则
                            </div>
                            <div class="am-u-lg-11 am-u-md-10 am-u-sm-9 rule-box">
                                <textarea class="rule-text" name="rule" id="" cols="" rows="" placeholder="多行输入"></textarea>
                            </div>
                        </div>
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

var nowTemp = new Date();
var nowDay = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0).valueOf();
var nowMoth = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), 1, 0, 0, 0, 0).valueOf();
var nowYear = new Date(nowTemp.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
var $startDate = $('#pdd-startDate');

// 拼豆豆活动时间
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
    $('#pdd-endDate')[0].focus();
}).data('amui.datepicker');

var checkout = $('#pdd-endDate').datepicker({
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


// 拼豆豆优惠生效时间
var checkin = $(".effect-time").datepicker({
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
    $('.expired-time')[0].focus();
}).data('amui.datepicker');

var checkout = $('.expired-time').datepicker({
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


// 判定成团人数
$(".group-size").blur(function () {
    if ($(this).val() > 20) {
        alert("成团人数不得超过20人")
    }
})


// 判定拼豆豆有效天数
$(".effective-days").blur(function () {
    if ($(this).val() == null || $(this).val() == '') {
    } else {
        if ($(this).val() > 365 || $(this).val() < 1) {
            alert("生效天数不合法")
        }
    }
})

function selectImage(file, selector) {
    if (!file.files || !file.files[0]) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        var sonNum = $(selector).children().length
        if (selector == '.product' && sonNum > 16) {
            console.log("最多只能选择15张图片")
            return false
        }
        if (selector == '.list' && sonNum > 2) {
            console.log("最多只能选择1张图片")
            return false
        }
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"><input class="img-value" type="text" name="image[]" hidden></div>'
        $(selector).append($imgBox)
        image = evt.target.result;
        let remark = selector + ' .image-remark'
        $(remark).hide()
    }
    reader.readAsDataURL(file.files[0]);
    var fd = new FormData()
    fd.append('file', file.files[0])
    upLoadImage(fd, selector);
}

function upLoadImage (file, kind) {
    $.ajax({
        url: 'http://shop.test/api/event/upload',
        type: 'post',
        dataType: 'json',
        data: file,
        processData: false,
        contentType: false,
        success: function (res) {
            let url = res.data.url
            let selector = kind + ' .selected-image:last-child .img-value'
            if (kind == '.list') {
                $(".list .selected-image input[name='image[]']").attr("name", 'logo')
            }
            $(selector).val(url)
            // console.log($(selector))
        },
        error: function (ex) {
            console.log(ex)
        }
    })
    // console.log(file)
}

$(".product").on("click", ".selected-image .delete-image", function () {
    $(this).parent().remove()
    var sonNum = $(".product").children().length
    if (sonNum == 2) {
        $(".product .image-remark").show()
    }

})
$(".list").on("click", ".selected-image .delete-image", function () {
    $(this).parent().remove()
    var sonNum = $(".list").children().length
    if (sonNum == 2) {
        $(".list .image-remark").show()
    }
})

function modify (that, len) {
    // for (let i = 0; i < len; i++) {
    //     let a = $(that).parent().parent().siblings().children(".package-info")[i]
    //     let b = $(a).text()
    //     let c = $(that).parent().parent().siblings().children(".form-control")[i]
    //     $(c).val(b)
    // }
    $(that).parent().parent().siblings().children(".form-control").show()
    $(that).parent().parent().siblings().children(".package-info").hide()
    $(that).hide()
    $(that).siblings().css('display', 'inline-block')
}

function save (that, len) {
    for (let i = 0; i < len; i++) {
        let c = $(that).parent().parent().siblings().children(".package-info")[i]
        let a = $(that).parent().parent().siblings().children(".form-control")[i]
        let b = $(a).val()
        $(c).text(b)
    }
    $(that).parent().parent().siblings().children(".form-control").hide()
    $(that).parent().parent().siblings().children(".package-info").show()
    $(that).hide()
    $(that).siblings().css('display', 'inline-block')
}

var i = 0
function addPackageInfo () {
    var packageName = $("#package-name").val()
    var packageAmount = $("#package-amount").val()
    var packagePrice = $("#package-price").val()
    if (packageName == '' || packageName == null) {
        alert("套餐内容不能为空")
        return false;
    }
    if (packageAmount == '' || packageAmount == null) {
        alert("套餐数量不能为空")
        return false;
    }
    if (packageAmount < 1) {
        alert("套餐数量必须大于1")
        return false;
    }
    if (packagePrice == '' || packagePrice == null) {
        alert("套餐价格不能为空")
        return false;
    }
    if (packagePrice < 0) {
        alert("套餐价格不能小于0")
        return false;
    }
    let productName = 'product[' + i + '][name]'
    let productPrice = 'product[' + i + '][price]'
    let productQuantity = 'product[' + i + '][quantity]'
    i++
    var $package = '<div class="pdd-table-tr clear-fix"><div class="am-u-lg-4 am-u-md-4 am-u-sm-4"><div class="package-info">'+ packageName +'</div><input type="text" class="form-control" value="'+ packageName +'" name="' + productName + '"></div><div class="am-u-lg-2 am-u-md-3 am-u-sm-3"><div class="package-info">' + packageAmount + '</div><input type="number" class="form-control" value="'+ packageAmount +'" name="' + productQuantity + '"></div><div class="am-u-lg-2 am-u-md-3 am-u-sm-3"><div class="package-info">' + packagePrice + '</div><input type="number" class="form-control" value="'+ packagePrice +'" name="' + productPrice + '"></div><div class="am-u-lg-4 am-u-md-2 am-u-sm-2 am-u-end"><div class="operating"><div class="motify" onclick="modify(this, 3)">修改</div><div class="save" onclick="save(this, 3)">保存</div><div class="delete">删除</div></div></div></div>'
    $(".package-data").append($package)
    $("#package-name").val("")
    $("#package-amount").val("")
    $("#package-price").val("")
}

$(".package-data").on("click", ".pdd-table-tr .operating .delete", function () {
    $(this).parent().parent().parent().remove()
})
$(".remark-data").on("click", ".pdd-table-tr .operating .delete", function () {
    $(this).parent().parent().parent().remove()
})

var j = 0
function addRemarkInfo () {
    let remarkData = $("#package-remark").val()
    if (remarkData == '' || remarkData == null) {
        alert("备注内容不能为空")
        return false;
    }
    let remarkContent = 'remark[' + j + ']'
    var $remark = '<div class="pdd-table-tr clear-fix remark-tr"><div class="am-u-lg-5 am-u-md-5 am-u-sm-6"><div class="package-info">' + remarkData + '</div><input type="text" class="form-control" value="'+ remarkData +'" name="' + remarkContent + '"></div><div class="am-u-lg-7 am-u-md-7 am-u-sm-6 am-u-end"><div class="operating"><div class="motify" onclick="modify(this, 1)">修改</div><div class="save" onclick="save(this, 1)">保存</div><div class="delete">删除</div></div></div></div>'
    $(".remark-data").append($remark)
    $("#package-remark").val("")
}

$('input[type=radio][name=is_effective_fixed]').change(function() {
    if (this.value == 1) {
        $(this).parent().parent().siblings().children(".effective-days").attr("disabled", true)
        $(this).parent().parent().children(".effect-time").attr("disabled", false)
        $(this).parent().parent().children(".expired-time").attr("disabled", false)
    } else if (this.value == 0) {
        $(this).parent().parent().siblings().children(".effect-time").attr("disabled", true)
        $(this).parent().parent().siblings().children(".expired-time").attr("disabled", true)
        $(this).parent().parent().children(".effective-days").attr("disabled", false)
    }
})

$('.fixed-time-option2 .effective-days').attr("disabled", true)
$('.sectiom-time').find("input").attr("disabled", true)
$('.sectiom-time #timeRadio2').attr("disabled", false)

$('input[type=radio][name=is_usetime_limit]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().siblings().find("input").prop({"disabled": true, "checked": false})
        $(this).parent().parent().siblings().find("#timeRadio2").attr("disabled", false)
    } else if (this.value == 1) {
        $(this).parent().parent().find("input").prop({"disabled": false, "checked": true})
    }
})

var k = 0
function addCustomize () {
    let startHours = $(".start-hours").val()
    let endHours = $(".end-hours").val()
    if (startHours == '' || startHours == null) {
        alert("开始时间不能为空")
        return false
    }
    if (endHours == '' || endHours == null) {
        alert("结束时间不能为空")
        return false
    }
    let startTime = 'time_limit[' + k + '][start_at]'
    let endTime = 'time_limit[' + k + '][end_at]'
    k++
    var $customizeTime = '<div class="customize-time"><div class="add-time-text"><span class="customize-time-text">' + startHours + '</span><span>&nbsp;-&nbsp;</span><span class="customize-time-text">' + endHours + '</span></div><div class="add-time-box"><input type="text" class="add-start-hours" value="' + startHours + '" name="' + startTime + '"><span>&nbsp;-&nbsp;</span><input type="text" class="add-end-hours" value="' + endHours + '" name="' + endTime + '"></div><div class="operating"><div class="motify" onclick="modifyCustomize(this)">修改</div><div class="save" onclick="saveCustomize(this)">保存</div><div class="delete">删除</div></div></div>'
    $(".customize").append($customizeTime)
    $(".start-hours").val("")
    $(".end-hours").val("")

    $('.add-start-hours, .add-end-hours').datetimepicker({
        format: 'hh:ii',
        autoclose: true,
        todayHighlight: true,
        startView: 'hour'
    });
}

function modifyCustomize (that) {
    $(that).parent().siblings(".add-time-text").hide()
    $(that).parent().siblings(".add-time-box").css("display", 'inline-block')
    $(that).hide()
    $(that).siblings().css('display', 'inline-block')
}

function saveCustomize (that) {
    for (let i = 0; i < 2; i++) {
        let a = $(that).parent().siblings(".add-time-box").children("input")[i]
        let b = $(that).parent().siblings(".add-time-text").children(".customize-time-text")[i]
        let c = $(a).val()
        $(b).text(c)
    }
    $(that).parent().siblings(".add-time-text").show()
    $(that).parent().siblings(".add-time-box").hide()
    $(that).hide()
    $(that).siblings().css('display', 'inline-block')
}

$(".customize").on("click", ".customize-time .operating .delete", function () {
    $(this).parent().parent().remove()
})

$(".bottom-submit-btn").on("click", function () {
    var aa = $("#submit").serialize()
    console.log(aa)
    $("#submit").submit()
})

$(".bottom-reset-btn").on("click", function () {
    window.location.href = '/event/groupon/create'
})

$('.start-hours, .end-hours').datetimepicker({
    format: 'hh:ii',
    autoclose: true,
    todayHighlight: true,
    startView: 'hour'
});
</script>
@endsection
