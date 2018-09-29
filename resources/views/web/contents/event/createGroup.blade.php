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
                    <div class="am-u-md-12 am-u-sm-12 row-mb">
                        <div class="form-container">
                            <div class="form-title">拼豆豆基本信息</div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆豆名称</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="最多可输入20个字符" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">原价格</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="old-price" id="old-price" name="old-price" placeholder="输入拼豆商品原价">
                                        <div class="price-unit">元</div>
                                    </div>
                                    <span class="remark">请设置大于0的金额数字</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆后价格</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="new-price" id="new-price" name="new-price" placeholder="输入拼豆商品原价">
                                        <div class="price-unit">元</div>
                                    </div>
                                    <span class="remark">请设置大于0的金额数字</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">拼豆活动时间</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="time" name="time">
                                    <!-- <input type="text" id="config-demo" class="form-control" style="max-width:320px;display:inline-block;margin:4px"> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">成团人数</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="group-size" id="group-size" name="group-size" placeholder="输入成团人数">
                                    </div>
                                    <span class="remark">最高设置20个人</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">商品图片</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <a href="javascript:;" class="file">+添加图片
                                        <input type="file" class="" id="product-image" name="image[]" onchange="selectImage(this)">
                                    </a>
                                    <div class="selected-image">
                                        <img id="image" src="" alt="">
                                    </div>
                                    <span class="remark">最高设置20个人</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">列表封面图</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="time" name="time">
                                    <span class="remark">最高设置20个人</span>
                                </div>
                            </div>
                            <!-- <img src="" alt=""> -->
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

function selectImage(file) {
    console.log(file.files[0]);
    if (!file.files || !file.files[0]) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        document.getElementById('image').src = evt.target.result;
        image = evt.target.result;
    }
    reader.readAsDataURL(file.files[0]);
}
</script>
@endsection
