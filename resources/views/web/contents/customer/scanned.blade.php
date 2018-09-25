@extends('web.layouts.app')
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')

    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb scan-user">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title center">
                            <div class="center-caption">
                                <span>用户列表</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="tpl-echarts-C">
                            <div class="scan-user-table">
                                <div class="table-title clear-fix">
                                    <div class="ID">用户名id</div>
                                    <div class="nickname">昵称</div>
                                    <div class="sex">性别</div>
                                    <div class="age">年龄</div>
                                    <div class="first-scan">首次扫码时间</div>
                                    <div class="last-scan">	最后一次扫码时间</div>
                                    <div class="frequency">扫码频率(月)</div>
                                    <div class="scan-count">扫码总次数</div>
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
    var limit = 8
    var type = 'scan'
    var page = 1
    var pageCount
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/customer/scannedUserList',
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
                console.log(res)
                // let count = res.data.count
                // pageCount = Math.ceil(count / limit)
                // var $tr = '<div class="table-tr clear-fix"><div class="table-td-id"></div><div class="table-td-nikname"></div><div class="table-td-sex"></div><div class="table-td-age"></div><div class="table-td-first"></div><div class="table-td-last"></div><div class="table-td-frequency"></div><div class="table-td-count"></div></div>'
                // for (let i = 0; i < resData.length; i++) {
                //     $('.table-content').append($tr)
                //     let date = resData[i].date
                //     let count = resData[i].value
                //     let percent = resData[i].rate
                //     $(".table-content .table-tr:eq("+ i +") .table-td-date").text(date)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-count").text(count)
                //     $(".table-content .table-tr:eq("+ i +") .table-td-percent").text(percent)
                // }
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

    $(".table-content").on('click', '.table-tr', function () {
        let type = 'active'
        let time = $(this).children()[0]
        let date = $(time).text()
        let detailLimit = 8
        let detailPage = 1
        // window.location.href = '/statistics/details?type=' + type + '&date=' + date + '&limit=' + detailLimit + '&page=' + detailPage
    })
</script>
@endsection