@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/amazeui.datetimepicker.css">
@endsection('css')
@section('content')
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-content-wrapper">
        <form id="submit" action="" method="post"  enctype="multipart/form-data">
            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">商家名称</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="最多可输入20个字符" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">电话号码</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="phone_num" name="phone_num" placeholder="">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">营业时间</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control timepicker" id="open_time" autocomplete="off" name="open_time">
                                    <span>-</span>
                                    <input type="text" class="form-control timepicker" id="close_time" autocomplete="off" name="close_time">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">行业分类</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 categories">
                                    <select name="" id="categories" data-am-selected="{maxHeight: 200}"></select>
                                </div>
                            </div>
                            <div class="form-group image-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">商铺头像</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 list">
                                    <a href="javascript:;" class="file">+添加图片
                                        <input type="file" class="" id="list-image" name="image[]" onchange="selectImage(this, '.list')">
                                    </a>
                                    <span class="image-remark">建议尺寸:1204*1204像素,最多上传1张,仅支持gif,jpeg,png,bmp 4种格式,大小不超过3.0M</span>
                                </div>
                            </div>
                            <div class="form-group image-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">商铺详情图</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 product">
                                    <a href="javascript:;" class="file">+添加图片
                                        <input type="file" class="" id="product-image" name="image[]" onchange="selectImage(this, '.product')">
                                    </a>
                                    <span class="image-remark">建议尺寸:1204*1204像素,最多上传15张,仅支持gif,jpeg,png,bmp 4种格式,大小不超过3.0M</span>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">国家</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 country">
                                    <select name="" id="country" data-am-selected="{maxHeight: 200}">
                                        <option value="1">中国</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">详细地址</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 detail-address">
                                    <select name="" id="province" data-am-selected="{maxHeight: 200}"></select>
                                    <select name="" id="city" data-am-selected="{maxHeight: 200}"></select>
                                    <select name="" id="area" data-am-selected="{maxHeight: 200}"></select>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">地点</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <div data-am-widget="map" class="am-map am-map-default" data-name="云适配" data-address="北京市海淀区海淀大街27号亿景大厦3层西区" data-longitude="" data-latitude="" data-scaleControl="" data-zoomControl="true" data-setZoom="17" data-icon="http://amuituku.qiniudn.com/mapicon.png">
                                        <div id="bd-map"></div>
                                    </div>
                                </div>
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

function drawData () {
    $.ajax({
        url: 'http://shop.test/api/shop/info',
        type: 'get',
        dataType: 'json',
        // async: false,
        success: function (res) {
            let resData = res.data
            $("input#shop_name").val(resData.shop_name)
            $("input#phone_num").val(resData.phone_num)
            $("input#open_time").datetimepicker('update', resData.open_time)
            $("input#close_time").datetimepicker('update', resData.close_time)
            country = 1
            province = resData.province
            city = resData.city
            area = resData.area

            $(".detail-address .am-selected-status:eq(0)").text(resData.province_name)
            $(".detail-address .am-selected-status:eq(1)").text(resData.city_name)
            $(".detail-address .am-selected-status:eq(2)").text(resData.area_name)

            // 商铺头像
            $(".product .image-remark").hide()
            for (let i = 0; i < resData.detailImage.length; i++) {
                var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' + resData.detailImage[i].url + '"><input class="img-value" type="text" name="image[]" hidden value="' + resData.detailImage[i].url + '"></div>'
                $('.product').append($imgBox)
            }
            $(".list .image-remark").hide()
            var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' + resData.url + '"><input class="img-value" type="text" name="logo" hidden value="' + resData.logo + '"></div>'
            $('.list').append($imgBox)
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}
drawData();

function getCategory () {
    $.ajax({
        url: 'http://shop.test/api/shop/category',
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $opts = '<option value="' + resData[i].seq + '"> ' + resData[i].name + ' </option>'
                $(".categories #categories").append($opts)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}
getCategory();

function getCountry () {
    $.ajax({
        url: 'http://shop.test/api/common/country',
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $opts = '<option value="' + resData[i].seq + '"> ' + resData[i].name + ' </option>'
                $(".country #country").append($opts)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}

function getProvince () {
    $.ajax({
        url: 'http://shop.test/api/common/province/' + country,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $opts = '<option value="' + resData[i].seq + '"> ' + resData[i].name + ' </option>'
                $(".detail-address #province").append($opts)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}


function getCity () {
    $.ajax({
        url: 'http://shop.test/api/common/city/' + province,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $opts = '<option value="' + resData[i].seq + '"> ' + resData[i].name + ' </option>'
                $(".detail-address #city").append($opts)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}

function getArea () {
    $.ajax({
        url: 'http://shop.test/api/common/area/' + city,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $opts = '<option value="' + resData[i].seq + '"> ' + resData[i].name + ' </option>'
                $(".detail-address #area").append($opts)
            }
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}

$('#open_time, #close_time').datetimepicker({
    format: 'hh:ii',
    autoclose: true,
    todayHighlight: true,
    startView: 'hour'
});

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

// $("body").on("click", ".country .am-selected-btn", function () {
//     getCountry();
// })

$("body").on("click", ".detail-address .am-selected-btn:eq(0)", function () {
    getProvince();
    getCity();
    getArea();
    setTimeout(() => {
        $("select#province").find("option[value = "+province+"]").attr("selected","selected")
        $("select#city").find("option[value = '"+city+"']").attr("selected","selected")
        $("select#area").find("option[value = '"+area+"']").attr("selected","selected")
        
        $(".detail-address .am-selected-list li").removeClass("am-checked")
        $(".detail-address .am-selected-list:eq(0)").find("li[data-value = '" + province + "']").addClass("am-checked")
        let showProvince = $(".detail-address .am-selected-list:eq(0)").find("li[data-value = '" + province + "']").children("span").text()
        $(".detail-address .am-selected-status:eq(0)").text(showProvince)

        $(".detail-address .am-selected-list:eq(1)").find("li[data-value = '" + city + "']").addClass("am-checked")
        let showCity = $(".detail-address .am-selected-list:eq(1)").find("li[data-value = '" + city + "']").children("span").text()
        $(".detail-address .am-selected-status:eq(1)").text(showCity)

        $(".detail-address .am-selected-list:eq(2)").find("li[data-value = '" + area + "']").addClass("am-checked")
        let showArea = $(".detail-address .am-selected-list:eq(2)").find("li[data-value = '" + area + "']").children("span").text()
        $(".detail-address .am-selected-status:eq(2)").text(showArea)
    }, 1000);
})

$("select#province").change(function () {
    console.log($(this).val())
})

$("body").on("click", ".city .am-selected-btn", function () {
    console.log("1")
    getCountry();
})

$(".bottom-submit-btn").on("click", function () {
    var aa = $("#submit").serialize()
    console.log(aa)
    $("#submit").submit()
})

$(".bottom-reset-btn").on("click", function () {
    window.location.href = window.location.href
})

</script>
@endsection
