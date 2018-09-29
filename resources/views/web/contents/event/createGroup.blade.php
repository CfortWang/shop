@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" type="text/css" media="all" href="/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" media="all" href="/css/bootstrap-datetimepicker.min.css" />
@endsection('css')
@section('content')



<!-- <form id="submit" action="/api/event/groupon" method="post"  enctype="multipart/form-data">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="image[]">
    <input type="file" name="imag">
    <input type="text" class="form-control" name="product[1][name]">
    <input type="text" class="form-control" name="product[1][price]">
    <input type="text" class="form-control" name="product[1][quantity]">
    <input type="text" class="form-control" name="product[2][name]">
    <input type="text" class="form-control" name="product[2][price]">
    <input type="text" class="form-control" name="product[2][quantity]">
    <button type="button" class="btn">提交</button>
</form> -->
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
                                    <input type="text" class="form-control" id="name" name="name" placeholder="最多可输入20个字符" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">原价格</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="old-price" id="old-price" name="old-price" placeholder="输入拼豆商品原价">
                                        <div class="price-unit">元</div>
                                    </div>
                                    <span class="image-remark">请设置大于0的金额数字</span>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆后价格</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="new-price" id="new-price" name="new-price" placeholder="输入拼豆商品原价">
                                        <div class="price-unit">元</div>
                                    </div>
                                    <span class="image-remark">请设置大于0的金额数字</span>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆活动时间</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="time" name="time">
                                    <!-- <input type="text" id="config-demo" class="form-control" style="max-width:320px;display:inline-block;margin:4px"> -->
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">成团人数</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="group-size" id="group-size" name="group-size" placeholder="输入成团人数">
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
                                    <span class="image-remark">建议尺寸:1204*1204像素,最多上传15张,仅支持gif,jpeg,png,bmp 4种格式,大小不超过3.0M</span>
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
                        <input type="text" name="package" class="package-obj">
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
                            <div class="form-title">拼豆成功后优惠使用须知</div>
                        </div>
                        <div class="dividing"></div>
                        <div class="choose-time">
                            <div class="choose-title">拼豆成功后优惠有效期</div>
                            <div class="fixed-time">
                                <div class="fixed-time-option1">
                                    <img src="/img/main/unselected.png" alt="">
                                    <span>固定日期</span>
                                </div>
                                <div class="fixed-time-option2">
                                    <img src="/img/main/unselected.png" alt="">
                                    <span>拼豆成功后当日开始</span>
                                    <input type="number" name="" id="" class="effective-days">
                                    <span>天内有效</span>
                                    <span class="effective-remark">(生效天数必须在1-365之间)</span>
                                </div>
                            </div>
                            <div class="period"></div>
                        </div>
                        <div class="dividing"></div>
                        <div class="effective-time">
                            <div class="random-time"></div>
                            <div class="sectiom-time">
                                <div class="section-time-weekends"></div>
                                <div class="hours-choose"></div>
                            </div>
                        </div>

                        <div class="dividing"></div>
                        <div class="use-rule">
                            <div class="am-u-lg-1 am-u-md-1 am-u-sm-3">
                            使用规则
                            </div>
                            <div class="am-u-lg-11 am-u-md-11 am-u-sm-9 rule-box">
                                <textarea class="rule-text" name="rules" id="" cols="" rows=""></textarea>
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
<script src="/js/moment.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<script>
var startDate = moment().subtract(7, 'days').format('YYYY-MM-DD');
var endDate = moment().format('YYYY-MM-DD');
var options = {};
options.locale = {
    format: "YYYY-MM-DD",
    separator: " - ",
    daysOfWeek: ["日","一","二","三","四","五","六"],
    monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
};
options.startDate =  moment().subtract(7, 'days');
options.endDate =  moment();
options.maxDate =  moment();
options.autoApply = true;
$('#config-demo').datetimepicker(options, function(start, end, label) {
    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')'); 
    startDate = start.format('YYYY-MM-DD');
    endDate = end.format('YYYY-MM-DD');
})
$('.btn').click(function(){
    $('#submit').submit();
})

function selectImage(file, selector) {
    if (!file.files || !file.files[0]) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        var sonNum = $(selector).children().length
        console.log(sonNum)
        if (sonNum > 16) {
            console.log("最多只能选择15张图片")
            return false
        }
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"></div>'
        $(selector).append($imgBox)
        // $(".image").attr("src", evt.target.result)
        image = evt.target.result;
        let remark = selector + ' .image-remark'
        $(remark).hide()
    }
    reader.readAsDataURL(file.files[0]);
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
    for (let i = 0; i < len; i++) {
        let a = $(that).parent().parent().siblings().children(".package-info")[i]
        let b = $(a).text().replace(/¥/g, '')
        let c = $(that).parent().parent().siblings().children(".form-control")[i]
        $(c).val(b)
    }
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
    getPackageData()
}

function getPackageData () {
    var package = []
    let pLength = $(".package-data > .pdd-table-tr").length
    for (let i = 0; i < pLength; i++) {
        var pdata = {}
        // for (let j = 0; j < 3; j++) {
        pdata.name = $(".package-data > .pdd-table-tr:eq("+ i +") .package-info:eq("+ 0 +")").text()
        pdata.amount = $(".package-data > .pdd-table-tr:eq("+ i +") .package-info:eq("+ 1 +")").text()
        pdata.price = $(".package-data > .pdd-table-tr:eq("+ i +") .package-info:eq("+ 2 +")").text()
        // }
        package[i] = pdata
    }
}

function getRemarkData () {
    var package = []
    let pLength = $(".package-data > .pdd-table-tr").length
    for (let i = 0; i < pLength; i++) {
        var pdata = {}
        // for (let j = 0; j < 3; j++) {
        pdata.name = $(".package-data > .pdd-table-tr:eq("+ i +") .package-info:eq("+ 0 +")").text()
        pdata.amount = $(".package-data > .pdd-table-tr:eq("+ i +") .package-info:eq("+ 1 +")").text()
        pdata.price = $(".package-data > .pdd-table-tr:eq("+ i +") .package-info:eq("+ 2 +")").text()
        // }
        package[i] = pdata
    }
}

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
    var $package = '<div class="pdd-table-tr clear-fix"><div class="am-u-lg-4 am-u-md-4 am-u-sm-4"><div class="package-info">'+ packageName +'</div><input type="text" class="form-control" id="" name=""></div><div class="am-u-lg-2 am-u-md-3 am-u-sm-3"><div class="package-info">' + packageAmount + '</div><input type="number" class="form-control" id="" name=""></div><div class="am-u-lg-2 am-u-md-3 am-u-sm-3"><div class="package-info">' + packagePrice + '</div><input type="number" class="form-control" id="" name=""></div><div class="am-u-lg-4 am-u-md-2 am-u-sm-2 am-u-end"><div class="operating"><div class="motify" onclick="modify(this, 3)">修改</div><div class="save" onclick="save(this, 3)">保存</div><div class="delete">删除</div></div></div></div>'
    $(".package-data").append($package)
    $("#package-name").val("")
    $("#package-amount").val("")
    $("#package-price").val("")
    getPackageData()
}

$(".package-data").on("click", ".pdd-table-tr .operating .delete", function () {
    $(this).parent().parent().parent().remove()
    getPackageData()
})

function addRemarkInfo () {
    let remarkData = $("#package-remark").val()
    if (remarkData == '' || remarkData == null) {
        alert("备注内容不能为空")
        return false;
    }
    var $remark = '<div class="pdd-table-tr clear-fix remark-tr"><div class="am-u-lg-5 am-u-md-5 am-u-sm-6"><div class="package-info">' + remarkData + '</div><input type="text" class="form-control" id="" name=""></div><div class="am-u-lg-7 am-u-md-7 am-u-sm-6 am-u-end"><div class="operating"><div class="motify" onclick="modify(this, 1)">修改</div><div class="save" onclick="save(this, 1)">保存</div><div class="delete">删除</div></div></div></div>'
    $(".remark-data").append($remark)
    $("#package-remark").val("")
}
</script>
@endsection
