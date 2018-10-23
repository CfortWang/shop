@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('nav')
<span>我的用户/扫码用户详情</span>
@endsection('nav')

@section('content')
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-content-wrapper">
        <div class="row">
            <div class="am-u-md-12 am-u-sm-12 row-mb active-user">
                <div class="tpl-portlet">
                    <div class="tpl-portlet-title center">
                        <div class="center-caption">
                            <span>扫码用户详情</span>
                        </div>
                    </div>
                    <div class="detail-page" id="tpl-echarts-C">
                        <div class="active-table">
                            <div class="table-title clear-fix">
                                <div class="user-id">用户ID</div>
                                <div class="user-name">用户昵称</div>
                                <div class="scan-time">上次扫码时间</div>
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
@endsection

@section('script')
<script>
    var args = getArgs()
    var seq = args['seq']
    var limit = args['limit']
    var page = args['page']
    var pageCount
    var drawList = function () {
        $.ajax({
            url: '/api/customer/scannedUserDetail',
            type: 'get',
            dataType: 'json',
            data: {
                seq: seq,
                limit: limit,
                page: page
            },
            success: function (res) {
                console.log(res)
                $(".table-content").empty()
                let resData = res.data.list
                console.log(resData)
                let count = res.data.count
                pageCount = Math.ceil(count / limit)
                var $tr = '<div class="table-tr clear-fix"><div class="table-td-id"></div><div class="table-td-name"></div><div class="table-td-time"></div></div>'
                for (let i = 0; i < resData.length; i++) {
                    $('.table-content').append($tr)
                    let userID = resData[i].seq
                    let userName = resData[i].nickname
                    let scanTime = resData[i].created_at
                    if (userID == null || userID == '') {
                        userID = '——'
                    }
                    if (userName == null || userName == '') {
                        userName = '——'
                    }
                    if (scanTime == null || scanTime == '') {
                        scanTime = '——'
                    }
                    $(".table-content .table-tr:eq("+ i +") .table-td-id").text(userID)
                    $(".table-content .table-tr:eq("+ i +") .table-td-name").text(userName)
                    $(".table-content .table-tr:eq("+ i +") .table-td-time").text(scanTime)
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawList();
</script>
@endsection