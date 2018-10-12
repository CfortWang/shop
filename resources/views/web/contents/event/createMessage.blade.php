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
        <form id="submit" action="/api/event/groupon" method="post"  enctype="multipart/form-data">
            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12">
                        <div class="create-message-title">
                            <div class="am-u-lg-2 am-u-md-2 am-u-sm-3 title">
                            消息推送类型
                            </div>
                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 rule-box">
                                <select>
                                    <option>喜豆APP内推送</option>
                                </select>
                            </div>
                        </div>
                        <div class="create-message-title">
                            <div class="am-u-lg-2 am-u-md-2 am-u-sm-3 title">
                            群发对象
                            </div>
                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 rule-box">
                                <label class="message-label sendTypePhone">
                                    <input type="radio" name="object_type" value="0">输入手机号
                                </label>                                
                                <label class="message-label sendType">
                                    <input type="radio" name="object_type" value="1">按人群筛选
                                </label>
                                <div>
                                    <select>
                                        <option>沉默用户</option>
                                        <option>拼豆成功未使用用户</option>
                                        <option>领取优惠券未使用用户</option>
                                        <option>拼豆失败用户</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="create-message-title">
                            <div class="am-u-lg-2 am-u-md-2 am-u-sm-3 title">
                            推送内容
                            </div>
                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 rule-box">
                                <textarea class="rule-text" name="rule" id="" cols="" rows="" placeholder="多行输入"></textarea>
                            </div>
                        </div>
                        <div class="create-message-title am-form">
                            <div class="am-u-lg-2 am-u-md-2 am-u-sm-3 title">
                            发送时间
                            </div>
                            <div class="am-u-lg-10 am-u-md-10 am-u-sm-9 rule-box">
                                <p>
                                    <label class="message-label">
                                        <input type="radio" name="send_at" value="0">立即发送
                                    </label>
                                </p>
                                <p>
                                    <label class="message-label">
                                        <input type="radio" name="send_at" value="">定时发送
                                        <input type="text" name="send_at" class="am-form-field am-input-sm" id="send_at_text">
                                    </label>
                                </p>
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

</script>
@endsection
