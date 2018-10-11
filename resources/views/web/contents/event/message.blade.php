@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/eventMessage.css">

<link rel="stylesheet" type="text/css" media="all" href="/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" media="all" href="/css/bootstrap-datetimepicker.min.css" />
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb event-message">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="请输入手机号查找">
                                <button class="search-btn">搜索</button>
                            </div>
                            <!-- <select data-am-selected>
                                <option value="1" selected>进行中</option>
                                <option value="2">未开始</option>
                                <option value="3">已结束</option>
                            </select> -->
                            <div class="create-message">
                                <span>新建消息通知</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="table">
                            <div class="table">
                                <div class="table-title clear-fix">
                                    <div class="content">推送内容</div>
                                    <div class="user">群发用户</div>
                                    <div class="date">发送时间</div>
                                    <div class="status">状态</div>
                                    <div class="operating">操作</div>
                                </div>
                                <div class="table-content"></div>
                            </div>
                            <div class="pagination">
                                <div class="page-down">
                                    <img src="/img/main/icon_page_left.png" alt="">
                                </div>
                                <div class="page-number">1</div>
                                <div class="page-up">
                                    <img src="/img/main/icon_page_right.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hide">
        <div class="table-tr clear-fix">
            <div class="table-td-content"></div>
            <div class="table-td-object"></div>
            <div class="table-td-sendAt"></div>
            <div class="table-td-status"><p class="status-message"></p></div>
            <div class="table-td-operate"></div>
        </div>
    </div>
@endsection
@section('script')
<script>
    var limit = 8
    var type = 'scan'
    var page = 1
    var pageCount
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/event/message',
            type: 'get',
            dataType: 'json',
            data: {
                type: type,
                limit: limit,
                page: page
            },
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data.data
                console.log(resData)
                let count = res.data.count
                pageCount = Math.ceil(count / limit)
                console.log(pageCount)
                var $tr = $('.hide').html();
                for (let i = 0; i < resData.length; i++) {
                    $('.table-content').append($tr)
                    // if (resData[i].id == null || resData[i].id == '') {
                    //     var id = '——'
                    // } else {
                    //     var id = "+" + resData[i].id.split('@')[1] + " " + resData[i].id.split('@')[0]
                    // }
                    let content = resData[i].content
                    let object = resData[i].object
                    let sendAt = resData[i].sendAt
                    let status = resData[i].status
                    let messageStatus = resData[i].messageStatus

                    // let firstTimeYears = resData[i].firstTime.split(' ')[0]
                    // let firstTimeHours = resData[i].firstTime.split(' ')[1]
                    // let endTimeYears = resData[i].endTime.split(' ')[0]
                    // let endTimeHours = resData[i].endTime.split(' ')[1]
                    // let percent = resData[i].rate
                    // let count = resData[i].scannedCount
                    if (sendAt == null || sendAt == '') {
                        sendAt = '立即发送'
                    }
                    var operate = '';
                    if(messageStatus==0){
                        operate+='<a>修改</a>';
                        operate+='<a>删除</a>';
                    }else if(messageStatus==1){
                        operate+='<a>发送</a>';
                        operate+='<a>删除</a>';
                    }else if(messageStatus==2){
                        operate+='<a>修改</a>';
                        operate+='<a>删除</a>';
                    }
                    else if(messageStatus==3){
                        operate+='--';
                    }
                    // if (nickname == null || nickname == '') {
                    //     nickname = '——'
                    // }
                    $(".table-content .table-tr:eq("+ i +") .table-td-content").text(content)
                    $(".table-content .table-tr:eq("+ i +") .table-td-object").text(object)
                    $(".table-content .table-tr:eq("+ i +") .table-td-sendAt").text(sendAt)
                    $(".table-content .table-tr:eq("+ i +") .table-td-status").text(status)
                    
                    $(".table-content .table-tr:eq("+ i +") .table-td-count").text(count)
                    $(".table-content .table-tr:eq("+ i +") .table-td-operate").html(operate);
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawList();

    $(".page-down").click(function () {
        if (page > 1) {
            page--
            drawList();
            $(".page-number").text(page)
        } else {
            console.log("当前已是第一页")
        }
    })
    $(".page-up").click(function () {
        if (page < pageCount) {
            page++;
            drawList();
            $(".page-number").text(page)
        } else {
            console.log("已无更多数据")
        }
    })
</script>
@endsection
