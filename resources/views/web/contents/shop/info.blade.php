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
                                        <input type="file" class="" id="list-image" name="image[]" onchange="selectLogo(this, '.list')">
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
                                    <!-- <select name="" id="province" data-placeholder="请选择省份" data-am-selected="{maxHeight: 200}"></select>
                                    <select name="" id="city" data-placeholder="请选择城市" data-am-selected="{maxHeight: 200}"></select>
                                    <select name="" id="area" data-placeholder="请选择区/县" data-am-selected="{maxHeight: 200}"></select> -->
                                    <div class="am-u-lg-3 am-u-md-4 am-u-sm-12">
                                        <select name="" id="province" placeholder="请选择省份"></select>
                                    </div>
                                    <div class="am-u-lg-3 am-u-md-4 am-u-sm-12">
                                        <select name="" id="city" placeholder="请选择城市"></select>
                                    </div>
                                    <div class="am-u-lg-3 am-u-md-4 am-u-sm-12 am-u-end">
                                        <select name="" id="area" placeholder="请选择区/县"></select>
                                    </div>
                                    <div class="am-u-lg-6 am-u-md-8 am-u-sm-12 am-u-end">
                                        <input type="text" class="form-control" name="address_detail" id="address_detail">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">地点</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <div>
                                        <div id="map" ></div>
                                        <div id="myPageTop">
                                            <div class="search-div">
                                                <span>按关键字搜索：</span>
                                                <input type="text" placeholder="请输入关键字进行搜索" id="tipinput">
                                            </div>
                                            <div class="coordinate">
                                                <span>左击地图选取坐标：</span>
                                                <input type="text" readonly="true" id="lnglat">
                                            </div>
                                        </div>
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
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.6&key=b6f0744f2680a9728fc7fcc2244b0d48&plugin=AMap.Autocomplete"></script> 
<script>
$(document).ready(function(){
    // setPickers();
    var map = new AMap.Map('map',{
        zoom:15,
    });
    var clickEventListener = map.on('click', function(e) {
        document.getElementById("lnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat();
        $('#lat').val(e.lnglat.getLat());
        $('#lng').val(e.lnglat.getLng());
        addMarker(e.lnglat);
    });
    var auto = new AMap.Autocomplete({
        input: "tipinput"
    });
    AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
    function select(e) {
        if (e.poi && e.poi.location) {
            map.setZoom(15);
            map.setCenter(e.poi.location);
        }
    }
    function addMarker(lnglat) {
        if (typeof(marker)!="undefined") {
            marker.setMap(null);
            marker = null;
        }
        marker = new AMap.Marker({
            icon: "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
            position: lnglat
        });
        map.remove(marker);
        marker.setMap(map);
    }
})

function drawData () {
    $.ajax({
        url: 'http://shop.test/api/shop/info',
        type: 'get',
        dataType: 'json',
        async: false,
        success: function (res) {
            let resData = res.data
            $("input#shop_name").val(resData.shop_name)
            $("input#phone_num").val(resData.phone_num)
            $("input#open_time").datetimepicker('update', resData.open_time, 'hh:ii')
            $("input#close_time").datetimepicker('update', resData.close_time)
            $("input#address_detail").val(resData.address_detail)
            country = 1
            province = resData.province
            city = resData.city
            area = resData.area
            categoryID = resData.buyer_category

            // if(resData.lat&&resData.lng){
            //     marker = new AMap.Marker({
            //         position: new AMap.LngLat(resData.lng,resData.lat),
            //     });
            //     map.add(marker);
            //     map.setZoomAndCenter(14, [resData.lng, resData.lat]);
            // }

            // 商铺头像
            $(".product .image-remark").hide()
            $(".list .file").hide()
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

getProvince(country);
getCity(province);
getArea(city);
setTimeout(() => {
    $("select#province").find("option[value = "+province+"]").attr("selected","selected")
    $("select#city").find("option[value = '"+city+"']").attr("selected","selected")
    $("select#area").find("option[value = '"+area+"']").attr("selected","selected")
    $("select#categories").find("option[value = "+categoryID+"]").attr("selected","selected")

    $(".categories .am-selected-list li").removeClass("am-checked")
    $(".categories .am-selected-list:eq(0)").find("li[data-value = '" + categoryID + "']").addClass("am-checked")
    let cc = $(".categories .am-selected-list").find("li[data-value = '" + categoryID + "']").children("span").text()
    $(".categories .am-selected-status:eq(0)").text(cc)

}, 1000);

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

function getProvince (id) {
    $.ajax({
        url: 'http://shop.test/api/common/province/' + id,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            $("select#province").empty()
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


function getCity (id) {
    $.ajax({
        url: 'http://shop.test/api/common/city/' + id,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function (res) {
            $("select#city").empty()
            let resData = res.data
            for (let i = 0; i < resData.length; i++) {
                let $opts = '<option value="' + resData[i].seq + '"> ' + resData[i].name + ' </option>'
                $(".detail-address #city").append($opts)
            }
            cid = $("select#city").val()
            console.log("=======" + cid)
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}

function getArea (id) {
    $.ajax({
        url: 'http://shop.test/api/common/area/' + id,
        type: 'get',
        dataType: 'json',
        success: function (res) {
            $("select#area").empty()
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
    keyboardNavigation: true,
    maxView: 'days',
    startView: 'hour'
});

function selectLogo(file) {
    if (!file.files || !file.files[0]) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        var sonNum = $('.list').children().length
        if (sonNum > 2) {
            console.log("最多只能选择1张图片")
            return false
        }
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"><input class="img-value" type="text" name="image[]" hidden></div>'
        $('.list').append($imgBox)
        image = evt.target.result;
        $('.list .image-remark').hide()
    }
    reader.readAsDataURL(file.files[0]);
    shopData = new FormData()
    shopData.append('cropped_logo_image', file.files[0])
    $(".list .file").hide()
}

function selectImage(file) {
    if (!file.files || !file.files[0]) {
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        var sonNum = $('.product').children().length
        if (sonNum > 5) {
            $(".product .file").hide()
            console.log("最多只能选择张图片")
            // return false
        }
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"><input class="img-value" type="text" name="image[]" hidden></div>'
        $('.product').append($imgBox)
        image = evt.target.result;
        $('.product .image-remark').hide()
    }
    reader.readAsDataURL(file.files[0]);
    shopData = new FormData()
    shopData.append('cropped_logo_image', file.files[0])
}

$(".product").on("click", ".selected-image .delete-image", function () {
    $(this).parent().remove()
    var sonNum = $(".product").children().length
    if (sonNum == 2) {
        $(".product .image-remark").show()
    }
    $(".product .file").show()
})
$(".list").on("click", ".selected-image .delete-image", function () {
    $(this).parent().remove()
    var sonNum = $(".list").children().length
    if (sonNum == 2) {
        $(".list .image-remark").show()
    }
    $(".list .file").show()
})

$("select#province").change(function () {
    getCity($(this).val());
    getArea(cid);
})

$("select#city").change(function () {
    getArea($(this).val());
})

function modifyInfo (adInfo) {
    $.ajax({
        url: 'http://shop.test/api/shop/modify',
        type: 'post',
        dataType: 'json',
        data: adInfo,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res)
        },
        error: function (ex) {
            console.log(ex)
        }
    })
}


$(".bottom-submit-btn").on("click", function () {
    let shopName = $("#shop_name").val()
    let phoneNum = $("#phone_num").val()
    let openTime = $("#open_time").val()
    let closeTime = $("#close_time").val()
    let category = $("#categories").val()
    let countryID = $("#country").val()
    let provinceID = $("#province").val()
    let cityID = $("#city").val()
    let areaID = $("#area").val()
    let addressDetail = $("#address_detail").val()
    let lat = $("#lnglat").val().split(',')[0]
    let lng = $("#lnglat").val().split(',')[1]

    if (shopName == '' || shopName == null) {
        alert("商家名称不能为空")
        return false
    }
    if (phoneNum == '' || phoneNum == null) {
        alert("电话号码不能为空")
        return false
    }
    if (openTime == '' || openTime == null) {
        alert("开始营业时间不能为空")
        return false
    }
    if (closeTime == '' || closeTime == null) {
        alert("结束营业时间不能为空")
        return false
    }
    if (lat == '' || lat == null) {
        alert("地点不能为空")
        return false
    }

    shopData = new FormData()
    shopData.append("name", shopName)
    shopData.append("phone_num", phoneNum)
    shopData.append("open_time", openTime)
    shopData.append("close_time", closeTime)
    shopData.append("buyer_category", category)
    shopData.append("country", countryID)
    shopData.append("province", provinceID)
    shopData.append("city", cityID)
    shopData.append("area", areaID)
    shopData.append("address_detail", addressDetail)
    shopData.append("lat", lat)
    shopData.append("lng", lng)

    console.log(shopData)

    modifyInfo(shopData)
    shopData = new FormData()
})

$(".bottom-reset-btn").on("click", function () {
    window.location.href = window.location.href
})

</script>
@endsection
