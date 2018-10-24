@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/amazeui.datetimepicker.css">
@endsection('css')
@section('nav')
<span>营销/优惠券详情</span>
@endsection('nav')
@section('content')
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-content-wrapper">
        <form id="submit" action="/api/shop/modifyCoupon" method="post"  enctype="multipart/form-data" target="_self">
            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-title">优惠券基础信息</div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">优惠券名称</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9">
                                    <input type="text" class="form-control" id="coupon_name" name="coupon_name" placeholder="最多可输入10个字符" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">发放总量</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 has-remark">
                                    <div class="input-outer">
                                        <input type="number" class="old-price" id="quantity" name="quantity" placeholder="">
                                        <div class="price-unit">张</div>
                                    </div>
                                    <span class="image-remark">发放数量是一个在0-10000000的整数</span>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">优惠形式</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 coupon-modus">
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="coupon_type1" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-6">
                                            <input type="radio" checked hidden id="coupon_type1" name="coupon_type" value="0">
                                            <label for="coupon_type1" class="time-radio"></label>
                                            <span>指定金额(代金券)</span>
                                        </label>
                                        <div class="am-u-lg-10 am-u-md-8 am-u-sm-6">
                                        <span class="am-u-lg-2 am-u-md-2 am-u-sm-4 chooies">面值</span>
                                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-8 has-remark">
                                                <div class="input-outer">
                                                    <input type="number" class="coupon-input" id="discount_money" name="discount_money" placeholder="">
                                                    <div class="price-unit">元</div>
                                                </div>
                                                <span class="image-remark">优惠券面试必须大于等于0.01元</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="coupon_type2" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-12">
                                            <input type="radio" hidden id="coupon_type2" name="coupon_type" value="1">
                                            <label for="coupon_type2" class="time-radio"></label>
                                            <span>折扣(折扣券)</span>
                                        </label>
                                        <div class="am-u-lg-3 am-u-md-4 am-u-sm-12">
                                            <div class="am-u-lg-12 am-u-md-12 am-u-sm-12 has-remark">
                                                <div class="input-outer">
                                                    <input type="text" class="coupon-input" id="discount_percent" name="discount_percent" placeholder="1.0~9.9">
                                                    <div class="price-unit">折</div>
                                                </div>
                                                <!-- <span class="image-remark">优惠券面试必须大于等于0.01元</span> -->
                                            </div>
                                        </div>
                                        <div class="am-u-lg-7 am-u-md-4 am-u-sm-12">
                                            <span class="am-u-lg-2 am-u-md-2 am-u-sm-4 chooies">最高优惠</span>
                                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-8 has-remark">
                                                <div class="input-outer">
                                                    <input type="number" class="coupon-input" id="max_discount_money" name="max_discount_money" placeholder="">
                                                    <div class="price-unit">元</div>
                                                </div>
                                                <!-- <span class="image-remark">优惠券面试必须大于等于0.01元</span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">使用门槛</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 coupon-modus">
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="limit_type1" class="label-radio am-u-lg-2 am-u-md-4 am-u-sm-6">
                                            <input type="radio" checked hidden id="limit_type1" name="limit_type" value="0">
                                            <label for="limit_type1" class="time-radio"></label>
                                            <span>不限制</span>
                                        </label>
                                        <div class="am-u-lg-10 am-u-md-8 am-u-sm-6">
                                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-8 has-remark">
                                                <span class="image-remark">请谨慎设置无门槛优惠券，避免资金损失</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
                                        <label for="limit_type2" class="label-radio am-u-lg-1 am-u-md-2 am-u-sm-4">
                                            <input type="radio" hidden id="limit_type2" name="limit_type" value="1">
                                            <label for="limit_type2" class="time-radio"></label>
                                            <span>满</span>
                                        </label>
                                        <div class="am-u-lg-11 am-u-md-10 am-u-sm-8">
                                            <div class="am-u-lg-12 am-u-md-12 am-u-sm-12 has-remark">
                                                <div class="input-outer">
                                                    <input type="number" class="coupon-input" id="limit_money" name="limit_money" placeholder="">
                                                    <div class="price-unit">元可使用</div>
                                                </div>
                                                <span class="image-remark">请设置大于0的金额数字</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group image-group clear-fix">
                                <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">商品图片</label>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 product">
                                    <a href="javascript:;" class="file">+添加图片
                                        <input type="file" class="" id="product-image" name="file" onchange="selectImage(this, '.product')">
                                    </a>
                                    <span class="image-remark">建议尺寸:720*280像素,最多上传1张,仅支持gif,jpeg,png,bmp 4种格式,大小不超过3.0M</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tpl-portlet">
                <div class="row coupon-row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="form-container">
                            <div class="form-title">优惠券基本规则</div>
                            <div class="choose-time">
                                <div class="form-group clear-fix">
                                    <div class="am-u-lg-2 am-u-md-4 am-u-sm-6 coupon-title">每人限领</div>
                                    <div class="am-u-lg-10 am-u-md-8 am-u-sm-6 has-remark">
                                        <select name="limit_count" id="limit_count" data-am-selected>
                                            <option value="0">不限张</option>
                                            <option value="1">1张</option>
                                            <option value="2">2张</option>
                                            <option value="5">5张</option>
                                            <option value="-">其他</option>
                                        </select>
                                        <div class="input-outer coupon-account">
                                            <input type="number" class="old-price" id="" placeholder="">
                                            <div class="price-unit">张</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="choose-title">优惠有效期</div>
                                <div class="fixed-time">
                                    <div class="fixed-time-option1">
                                        <label for="effectRadio1" class="label-radio">
                                            <input type="radio" id="effectRadio1" value="0" checked hidden name="coupon_date_type">
                                            <label for="effectRadio1" class="time-radio"></label>
                                            <span>固定日期</span>
                                        </label>
                                        <span class="time-kind">生效时间：</span>
                                        <input type="text" class="effect-time" autocomplete="off" name="start_at" data-am-datepicker placeholder="请选择日期">
                                        <span class="time-kind">过期时间：</span>
                                        <input type="text" class="expired-time" autocomplete="off" name="expired_at" data-am-datepicker placeholder="请选择日期">
                                    </div>
                                    <div class="fixed-time-option2">
                                        <label for="effectRadio2" class="label-radio">
                                            <input type="radio" id="effectRadio2" value="1" hidden name="coupon_date_type">
                                            <label for="effectRadio2" class="time-radio"></label>
                                            <span>领券成功后当日开始</span>
                                        </label>
                                        <input type="number" name="days" id="days" class="effective-days" placeholder="请输入天数">
                                        <span>天内有效</span>
                                        <span class="effective-remark">(生效天数必须在1-365之间)</span>
                                    </div>
                                </div>
                                <div class="dividing"></div>
                                <div class="effective-time">
                                    <div class="random-time">
                                        <label for="timeRadio1" class="label-radio">
                                            <input type="radio" id="timeRadio1" value="0" checked hidden name="available_time_type">
                                            <label for="timeRadio1" class="time-radio"></label>
                                            <span>有效期内任意时间段可用</span>
                                        </label>
                                    </div>
                                    <div class="sectiom-time">
                                        <label for="timeRadio2" class="label-radio">
                                            <input type="radio" id="timeRadio2" value="1" hidden name="available_time_type">
                                            <label for="timeRadio2" class="time-radio"></label>
                                            <span>有效期内部分时间段可用</span>
                                        </label>
                                        <div class="section-time-weekends">
                                            <div class="weekends-day">
                                                <label for="weekendCheckbox1" class="label-radio">
                                                    <input type="checkbox" id="weekendCheckbox1" value="1" hidden name="available_time[]">
                                                    <label for="weekendCheckbox1" class="weekend-checkbox"></label>
                                                    <span>周一</span>
                                                </label>
                                            </div>
                                            <div class="weekends-day">
                                                <label for="weekendCheckbox2" class="label-radio">
                                                    <input type="checkbox" id="weekendCheckbox2" value="2" hidden name="available_time[]">
                                                    <label for="weekendCheckbox2" class="weekend-checkbox"></label>
                                                    <span>周二</span>
                                                </label>
                                            </div>
                                            <div class="weekends-day">
                                                <label for="weekendCheckbox3" class="label-radio">
                                                    <input type="checkbox" id="weekendCheckbox3" value="3" hidden name="available_time[]">
                                                    <label for="weekendCheckbox3" class="weekend-checkbox"></label>
                                                    <span>周三</span>
                                                </label>
                                            </div>
                                            <div class="weekends-day">
                                                <label for="weekendCheckbox4" class="label-radio">
                                                    <input type="checkbox" id="weekendCheckbox4" value="4" hidden name="available_time[]">
                                                    <label for="weekendCheckbox4" class="weekend-checkbox"></label>
                                                    <span>周四</span>
                                                </label>
                                            </div>
                                            <div class="weekends-day">
                                                <label for="weekendCheckbox5" class="label-radio">
                                                    <input type="checkbox" id="weekendCheckbox5" value="5" hidden name="available_time[]">
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

                                <div class="choose-title">优惠使用条件</div>
                                <div class="fixed-time">
                                    <div class="fixed-time-option1">
                                        <label for="is_special_goods1" class="label-radio">
                                            <input type="radio" id="is_special_goods1" value="0" checked hidden name="is_special_goods">
                                            <label for="is_special_goods1" class="time-radio"></label>
                                            <span>全店商品</span>
                                        </label>
                                        <label for="is_special_goods2" class="label-radio">
                                            <input type="radio" id="is_special_goods2" value="1" hidden name="is_special_goods">
                                            <label for="is_special_goods2" class="time-radio"></label>
                                            <span>指定商品</span>
                                        </label>
                                        <input type="text" name="goods_name" id="goods_name" class="effective-days" placeholder="请输入商品名">
                                    </div>
                                    <div class="fixed-time-option2">
                                        <label for="condition1" class="label-radio">
                                            <input type="radio" id="condition1" value="0" checked hidden name="condition">
                                            <label for="condition1" class="time-radio"></label>
                                            <span>仅原价购买商品时可用</span>
                                        </label>
                                        <label for="condition2" class="label-radio">
                                            <input type="radio" id="condition2" value="1" hidden name="condition">
                                            <label for="condition2" class="time-radio"></label>
                                            <span>允许与其他优惠券或优惠叠加使用</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="dividing"></div>
                                <div class="use-rule clear-fix">
                                    <div class="am-u-lg-2 am-u-md-2 am-u-sm-3 rule-title">
                                    优惠使用须知
                                    </div>
                                    <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 rule-box">
                                        <textarea class="rule-text" name="remark" id="" cols="" rows="" placeholder="填写活动详细说明，支持换行（不超过300字符）" maxlength="300"></textarea>
                                    </div>
                                </div>
                                <div class="form-group clear-fix pkg">
                                    <label class="am-u-lg-2 am-u-md-2 am-u-sm-3">关联喜豆码</label>
                                    <div class="am-u-lg-4 am-u-md-5 am-u-sm-6 am-u-end">
                                        <select class="pkg-data" name="pkgList[]" multiple data-am-selected="{maxHeight: 100}"></select>
                                    </div>
                                </div>
                                <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 am-u-end package-box"></div>
                            </div>
                            <input type="text" hidden name="id">
                            <input type="text" hidden name="is_code_changed" value="1">
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
var args = getArgs();
$("input[type=text][name=id]").val(args['id'])
tim = ''
var drawData = function () {
    $.ajax({
        url: '/api/shop/couponDetail?id=' + args['id'],
        type: 'get',
        dataType: 'json',
        success: function (res) {
            console.log(res)
            let resData = res.data
            $("input#coupon_name").val(resData.coupon_name)
            $("input#quantity").val(resData.quantity)

            // 优惠形式
            for (let i = 0; i < 2; i++) {
                if ($("input[type=radio][name=coupon_type]:eq("+ i +")").val() == resData.coupon_type) {
                    $("input[type=radio][name=coupon_type]:eq("+ i +")").attr("checked", 'checked')
                }
            }
            if (resData.coupon_type) {
                $("input[type=text][name=discount_percent]").val(resData.discount_percent)
                $("input[type=number][name=max_discount_money]").val(resData.max_discount_money)
                $('#discount_percent, #max_discount_money').attr("disabled", false)
                $('#discount_money').attr("disabled", true)
            } else {
                $("input[type=number][name=discount_money]").val(resData.discount_money)
                $('#discount_percent, #max_discount_money').attr("disabled", true)
                $('#discount_money').attr("disabled", false)
            }

            // 使用门槛
            for (let i = 0; i < 2; i++) {
                if ($("input[type=radio][name=limit_type]:eq("+ i +")").val() == resData.limit_type) {
                    $("input[type=radio][name=limit_type]:eq("+ i +")").attr("checked", 'checked')
                }
            }
            if (resData.limit_type) {
                $("input[type=number][name=limit_money]").val(resData.limit_money)
                $('#limit_money').attr("disabled", false)
            } else {
                $('#limit_money').attr("disabled", true)
            }
            // 渲染商品图
            $(".product .image-remark").hide()
            var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' + 'http://' + resData.image + '"><input class="img-value" type="text" name="image" hidden value="' + resData.image + '"></div>'
            $('.product').append($imgBox)
            $(".product .file").hide()

            let limitAmount = resData.limit_count
            $("select#limit_count").val(limitAmount)
            if (limitAmount == '0' || limitAmount == '1' || limitAmount == '2' || limitAmount == '5') {
                $("select#limit_count").find("option[value = '"+limitAmount+"']").attr("selected","selected")
                $(".has-remark .am-selected-list > li").removeClass("am-checked")
                for (let i = 0; i < 4; i++) {
                    if ($(".has-remark .am-selected-list > li:eq("+ i +")").attr("data-value") == limitAmount) {
                        let text = $(".has-remark .am-selected-list > li:eq("+ i +") span").text()
                        $(".has-remark .am-selected-status").text(text)
                        $(".has-remark .am-selected-list > li:eq("+ i +")").addClass("am-checked")
                    }
                }
            }

            // 优惠有效期
            if (resData.coupon_date_type) {
                $("input[type=radio][name=coupon_date_type]:eq(1)").attr("checked", 'checked')
                $("input[type=number][name=days]").val(resData.days)
                $('.effect-time, .expired-time').attr("disabled", true)
                $('#days').attr("disabled", false)
            } else {
                $("input[type=radio][name=coupon_date_type]:eq(0)").attr("checked", 'checked')
                $("input[type=text][name=start_at]").datepicker('setValue', resData.start_at)
                $("input[type=text][name=expired_at]").datepicker('setValue', resData.expired_at)
                $('.effect-time, .expired-time').attr("disabled", false)
                $('#days').attr("disabled", true)
            }

            // 优惠有效时段
            for (let i = 0; i < 2; i++) {
                if ($("input[type=radio][name=available_time_type]:eq("+ i +")").val() == resData.available_time_type) {
                    
                }
            }

            tim = resData.time_limit.length
            if (resData.available_time_type) {
                $("input[type=radio][name=available_time_type]:eq(1)").attr("checked", 'checked')
                for (let j = 0; j < 5; j++) {
                    for (let i = 0; i < 5; i++) {
                        if ($("input[type=checkbox][name='available_time[]']:eq("+ i +")").val() == resData.available_time[j]) {
                            $("input[type=checkbox][name='available_time[]']:eq("+ i +")").attr("checked", 'checked')
                        }
                    }
                }
                if (resData.is_weekend) {
                    $("input[type=checkbox][name='is_weekend']").attr("checked", 'checked')
                }
                if (resData.is_festival) {
                    $("input[type=checkbox][name='is_festival']").attr("checked", 'checked')
                }
                for (let i = 0; i < resData.time_limit.length; i++) {
                    let startTime = 'time_limit[' + i + '][start_at]'
                    let endTime = 'time_limit[' + i + '][end_at]'
                    let time = resData.time_limit
                    var $customizeTime = '<div class="customize-time"><div class="add-time-text"><span class="customize-time-text">' + time[i].start_at + '</span><span>&nbsp;-&nbsp;</span><span class="customize-time-text">' + time[i].end_at + '</span></div><div class="add-time-box"><input type="text" class="add-start-hours" value="' + time[i].start_at + '" name="' + startTime + '"><span>&nbsp;-&nbsp;</span><input type="text" class="add-end-hours" value="' + time[i].end_at + '" name="' + endTime + '"></div><div class="operating"><div class="motify" onclick="modifyCustomize(this)">修改</div><div class="save" onclick="saveCustomize(this)">保存</div><div class="delete">删除</div></div></div>'
                    $(".customize").append($customizeTime)
                    $('.add-start-hours, .add-end-hours').datetimepicker({
                        format: 'hh:ii',
                        autoclose: true,
                        todayHighlight: true,
                        startView: 'hour'
                    });
                }
                if ($(".customize-time").length >= 3) {
                    $(".hours-choose .add-time").hide()
                    $(".section-time .start-hours, .section-time .end-hours").attr("disabled", true)
                }
            } else {
                $("input[type=radio][name=available_time_type]:eq(0)").attr("checked", 'checked')
                // $("input[type=text][name=start_at]").val(resData.start_at)
                // $("input[type=text][name=expired_at]").val(resData.expired_at)
                $('.sectiom-time').find("input").attr("disabled", true)
                $('.sectiom-time #timeRadio2').attr("disabled", false)
            }

            // 优惠使用条件
            for (let i = 0; i < 2; i++) {
                if ($("input[type=radio][name=is_special_goods]:eq("+ i +")").val() == resData.is_special_goods) {
                    $("input[type=radio][name=is_special_goods]:eq("+ i +")").attr("checked", 'checked')
                }
            }
            if (resData.is_special_goods) {
                $("#goods_name").attr("disabled", false)
                $("input[type=text][name=goods_name]").val(resData.goods_name)
            } else {
                $("#goods_name").attr("disabled", true)
            }

            for (let i = 0; i < 2; i++) {
                if ($("input[type=radio][name=condition]:eq("+ i +")").val() == resData.condition) {
                    $("input[type=radio][name=condition]:eq("+ i +")").attr("checked", 'checked')
                }
            }

            $(".rule-text").val(resData.remark)

            // 喜豆码
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
        var $imgBox = '<div class="selected-image"><div class="delete-image"><img src="/img/main/close.png" alt=""></div><img class="image" alt="" src="' +evt.target.result + '"><input class="img-value" type="text" name="image" hidden></div>'
        $('.product').append($imgBox)
        image = evt.target.result;
        $('.product .image-remark').hide()
    }
    reader.readAsDataURL(file.files[0]);
    $(".product .file").hide()
    var fd = new FormData()
    fd.append('file', file.files[0])
    upLoadImage(fd);
}

function upLoadImage (file) {
    $.ajax({
        url: '/api/event/upload?type=coupon',
        type: 'post',
        dataType: 'json',
        data: file,
        processData: false,
        contentType: false,
        success: function (res) {
            let url = res.data.url
            $('.product .selected-image:last-child .img-value').val(url)
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
        $(".product .file").show()
    }

})

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
    // console.log(file)
}
getPkgCode();
setTimeout(() => {
    let allPkgList = $(".pkg .am-selected-list > li")
    for (let i = 0; i < pkgdata.length; i++) {
        for (let j = 0; j < allPkgList.length; j++) {
            let pkgSeq = $(".pkg .am-selected-list > li:eq("+ j +")").attr("data-value")
            if (pkgSeq == seqArr[i]) {
                $("select.pkg-data").find("option[value = '"+seqArr[i]+"']").attr("selected","selected")
                $(".pkg .am-selected-list > li:eq("+ j +")").addClass("am-checked")
                // $(".pkg .am-selected-list > li").removeClass("am-checked")
            }
        }
    }
    $(".pkg .am-selected-status").text(codeArr)
}, 1000);

// let pkgli = $(".pkg .am-selected-list > li")


$("body").on("click", ".pkg .am-selected-list > li", function () {
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
        let unselect = $(".pkg .am-selected-list > li:eq("+ i +")").attr("data-value")
        let pkgCode = $(".pkg .am-selected-list > li:eq("+ i +") span").text()
        if (unselect == pkgValue) {
            $(".pkg .am-selected-list > li:eq("+ i +")").removeClass("am-checked")
            $(".pkg select.pkg-data").find("option[value = '" + unselect +"']").removeAttr("selected")
            $(".pkg .am-selected-status").text(pkgArr.join(','))
        }
    }
})

$('input[type=radio][name=coupon_type]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().find("#discount_money").attr("disabled", false)
        $(this).parent().parent().siblings().find("#discount_percent, #max_discount_money").attr("disabled", true)
        // $(this).parent().parent().children(".expired-time").attr("disabled", false)
    } else if (this.value == 1) {
        $(this).parent().parent().siblings().find("#discount_money").attr("disabled", true)
        $(this).parent().parent().find("#discount_percent, #max_discount_money").attr("disabled", false)
    }
})

$('input[type=radio][name=limit_type]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().siblings().find("#limit_money").attr("disabled", true)
    } else if (this.value == 1) {
        $(this).parent().parent().find("#limit_money").attr("disabled", false)
    }
})

$('input[type=radio][name=is_special_goods]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().find("#goods_name").attr("disabled", true)
    } else if (this.value == 1) {
        $(this).parent().parent().find("#goods_name").attr("disabled", false)
    }
})

$('input[type=radio][name=coupon_date_type]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().siblings().children(".effective-days").attr("disabled", true)
        $(this).parent().parent().children(".effect-time").attr("disabled", false)
        $(this).parent().parent().children(".expired-time").attr("disabled", false)
    } else if (this.value == 1) {
        $(this).parent().parent().siblings().children(".effect-time").attr("disabled", true)
        $(this).parent().parent().siblings().children(".expired-time").attr("disabled", true)
        $(this).parent().parent().children(".effective-days").attr("disabled", false)
    }
})


// $('#discount_percent, #max_discount_money, #limit_money').attr("disabled", true)
// $('.fixed-time-option2 .effective-days').attr("disabled", true)
// $('.sectiom-time').find("input").attr("disabled", true)
// $('.sectiom-time #timeRadio2').attr("disabled", false)


$('input[type=radio][name=available_time_type]').change(function() {
    if (this.value == 0) {
        $(this).parent().parent().siblings().find("input").prop({"disabled": true, "checked": false})
        $(this).parent().parent().siblings().find("#timeRadio2").attr("disabled", false)
    } else if (this.value == 1) {
        $(this).parent().parent().find("input").prop({"disabled": false, "checked": true})
    }
})

setTimeout(() => {
    k = tim
}, 1000);
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
    $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: $("#submit").attr('action'),
        data: $("#submit").serialize(),
        success: function(data, status, x) {
            if(data.code == 200){
                toastr.success("修改成功")
                setTimeout(() => {
                    window.location.href = '/event/coupon'
                }, 1500);
            } else {
                toastr.error(data.message);
            }
            console.log(status);
        }
    });
})

$(".bottom-reset-btn").on("click", function () {
    window.location.href = window.location.href
})

$('.start-hours, .end-hours').datetimepicker({
    format: 'hh:ii',
    autoclose: true,
    todayHighlight: true,
    startView: 'hour'
});

$("body").on("click", ".has-remark .am-selected-list > li", function () {
    let a = $(this).attr("data-value")
    if (a == '-') {
        $(".coupon-account").show()
        $(".coupon-account").attr("name", "limit_count")
    } else {
        $(".coupon-account").hide()
        $(".coupon-account").attr("name", "limit_count_hide")
    }
})
</script>
@endsection
