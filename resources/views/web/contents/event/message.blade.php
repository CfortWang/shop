@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/eventMessage.css">

@endsection('css')
@section('nav')
<span>营销/消息通知</span>
@endsection('nav')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb event-message">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="create-message-div">
                                <div class="create-message">
                                    <span>@lang('event/notice.list.new_message')</span>
                                </div>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="table">
                            <div class="table">
                                <div class="table-title clear-fix">
                                    <div class="content">@lang('event/notice.list.push_content')</div>
                                    <div class="user">@lang('event/notice.list.mass_user')</div>
                                    <div class="date">@lang('event/notice.list.send_time')</div>
                                    <div class="status">@lang('event/notice.list.status')</div>
                                    <div class="operate">@lang('event/notice.list.action')</div>
                                </div>
                                <div class="table-content"></div>
                            </div>
                            <div class="no-data">
                                <img src="/img/main/no-data.png" alt="">
                                <div>暂无数据</div>
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
                        <div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
                            <div class="am-modal-dialog">
                                <div class="am-modal-hd">
                                    <img src="/img/main/icon_warning.png" alt="">
                                    <span>确定删除该通知?</span>
                                </div>
                                <div class="am-modal-bd">消息通知删除后无法找回，请谨慎操作。</div>
                                <div class="am-modal-footer">
                                    <span class="am-modal-btn give-up-btn" data-am-modal-cancel>取消</span>
                                    <span class="am-modal-btn ensure-btn" data-am-modal-confirm>确定</span>
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
            <div class="table-td-status">
                <span class="status"></span><br>
                <span class="status-remark"></span>
            </div>
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
            url: '/api/event/message',
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
                let count = res.data.count
                if (count) {
                    $(".no-data").hide()
                    $(".pagination").show()
                    pageCount = Math.ceil(count / limit)
                    var $tr = $('.hide').html();
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        let content = resData[i].content
                        let object = resData[i].object
                        let sendAt = resData[i].sendAt
                        let status = resData[i].status
                        let messageStatus = resData[i].messageStatus
                        let remark = resData[i].remark
                        let id = resData[i].id
                        if (sendAt == null || sendAt == '') {
                            sendAt = '立即发送'
                        }
                        var operate = '';
                        if(messageStatus==0){
                            operate+='<a class="modify">修改</a> ';
                            operate+='<a class="delete">删除</a>';
                        }else if(messageStatus==1){
                            // operate+='<a>发送</a> ';
                            operate+='<a class="delete">删除</a>';
                        }else if(messageStatus==2){
                            operate+='<a class="modify">修改</a> ';
                            operate+='<a class="delete">删除</a>';
                            $(".table-content .table-tr:eq("+ i +") .status-remark").text(remark)
                        }
                        else if(messageStatus==3){
                            operate+='--';
                        }

                        $(".table-content .table-tr:eq("+ i +") .table-td-content").text(content)
                        $(".table-content .table-tr:eq("+ i +") .table-td-object").text(object)
                        $(".table-content .table-tr:eq("+ i +") .table-td-sendAt").text(sendAt)
                        $(".table-content .table-tr:eq("+ i +") .table-td-status .status").text(status)
                        
                        $(".table-content .table-tr:eq("+ i +") .table-td-count").text(count)
                        $(".table-content .table-tr:eq("+ i +") .table-td-operate").html(operate);
                        $(".table-content .table-tr:eq("+ i +") .table-td-operate").attr({"data-id": id, "data-status": messageStatus})
                    }
                } else {
                    $(".no-data").show()
                    $(".pagination").hide()
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawList();

    var deleteMessage = function (event1, that) {
        $.ajax({
            url: '/api/event/deleteMessage/' + event1,
            type: 'put',
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    drawList();
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }

            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }

    $('.create-message').click(function() {
        window.location.href = "/event/message/create"
    })

    $(".table-content").on("click", ".table-tr .table-td-operate .delete", function () {
        var id = $(this).parent().attr("data-id")
        var that = $(this)
        $('#my-confirm').modal({
            relatedTarget: this,
            onConfirm: function(options) {
                let that = $(this.relatedTarget)
                let id = that.parent().attr("data-id")
                deleteMessage(id, that);
            },
            // closeOnConfirm: false,
            onCancel: function() {}
        });
    })

    $(".table-content").on("click", ".table-tr .table-td-operate .modify", function () {
        var id = $(this).parent().attr("data-id")
        window.location.href = '/event/message/details?id=' + id
    })
</script>
@endsection
