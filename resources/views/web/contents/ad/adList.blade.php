@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('nav')
<span>广告/广告列表</span>
@endsection('nav')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="am-u-md-12 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title ad-title">
                            <div class="create-ad">
                                <span>新建广告</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="ad-table">
                            <div class="ad-table">
                                <div class="table-title clear-fix">
                                    <div class="title">广告名称</div>
                                    <div class="uv">UV（总查看人数）</div>
                                    <div class="pv">PV（总查看数)</div>
                                    <div class="time">投放时间</div>
                                    <div class="duration">投放时长</div>
                                    <div class="operating">操作</div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    var limit = 8
    var page = 1
    var pageCount
    var drawList = function () {
        $.ajax({
            url: '/api/adv/list',
            type: 'get',
            dataType: 'json',
            data: {
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
                    var $tr = '<div class="table-tr clear-fix"><div class="table-td-title"></div><div class="table-td-uv"></div><div class="table-td-pv"></div><div class="table-td-time"><p class="years"></p><p class="hours"></p></div><div class="table-td-duration"></div><div class="operating"><span class="shelf"></span><span class="obtained"></span><span class="modify">&nbsp;&nbsp;&nbsp;&nbsp;修改</span></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        // let seq = resData[i].user
                        let adTitle = resData[i].title
                        let uv = resData[i].view_cnt
                        let pv = resData[i].view_cnt
                        let startDateYears = resData[i].start_date.split(' ')[0]
                        let startDateHours = resData[i].start_date.split(' ')[1]
                        let duration = resData[i].day
                        let status = resData[i].status
                        let id = resData[i].seq

                        if (status == 0) {
                            $(".table-content .table-tr:eq("+ i +") .operating .obtained").text("下架")
                        }
                        if (status == 1) {
                            $(".table-content .table-tr:eq("+ i +") .operating .shelf").text("上架")
                        }

                        $(".table-content .table-tr:eq("+ i +") .operating").attr({"data-id": id, "data-status": status})
                        $(".table-content .table-tr:eq("+ i +") .table-td-title").text(adTitle)
                        $(".table-content .table-tr:eq("+ i +") .table-td-uv").text(uv)
                        $(".table-content .table-tr:eq("+ i +") .table-td-pv").text(pv)
                        $(".table-content .table-tr:eq("+ i +") .table-td-time .years").text(startDateYears)
                        $(".table-content .table-tr:eq("+ i +") .table-td-time .hours").text(startDateHours)
                        $(".table-content .table-tr:eq("+ i +") .table-td-duration").text(duration)
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

    var changeStatus = function (event1, event2, that) {
        $.ajax({
            url: '/api/adv/adStatus',
            type: 'post',
            dataType: 'json',
            data: {
                seq: event1,
                status: event2
            },
            success: function (res) {
                console.log(res)
                if (res.code != 200) {
                    alert(res.message);
                } else {
                    if (that.parent().attr("data-status") == 0) {
                        that.parent().attr("data-status", 1)
                        that.text("上架")
                    } else {
                        that.parent().attr("data-status", 0)
                        that.text("下架")
                    }
                }
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }

    $(".create-ad").on("click", function () {
        window.location.href = "/ad/create"
    })

    $(".table-content").on("click", ".table-tr .operating .obtained, .table-tr .operating .shelf", function () {
        var id = $(this).parent().attr("data-id")
        var status = $(this).parent().attr("data-status")
        var that = $(this)
        changeStatus(id, status, that);
    })

    // 修改
    $(".table-content").on("click", ".table-tr .operating .modify", function () {
        var id = $(this).parent().attr("data-id")
        window.location.href = '/ad/details?id=' + id
    })
</script>
@endsection
