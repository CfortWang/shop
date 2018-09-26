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
                        <div class="tpl-portlet-title">
                            <!-- <div class="center-caption">
                                <span>用户列表</span>
                            </div> -->
                            <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="请输入手机号查找">
                                <button class="search-btn">搜索</button>
                            </div>

                        </div>
                        <div class="tpl-echarts" id="tpl-echarts-C">
                            <div class="scan-user-table">
                                <div class="table-title clear-fix">
                                    <div class="ID">手机号</div>
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
                let resData = res.data.scanUserList
                console.log(resData)
                let count = res.data.count
                pageCount = Math.ceil(count / limit)
                console.log(pageCount)
                var $tr = '<div class="table-tr clear-fix"><div class="table-td-id"></div><div class="table-td-nickname"></div><div class="table-td-sex"></div><div class="table-td-age"></div><div class="table-td-first"><p class="years"></p><p class="hours"></p></div><div class="table-td-last"><p class="years"></p><p class="hours"></p></div><div class="table-td-frequency"></div><div class="table-td-count"></div><div class="see-more">查看更多</div></div>'
                for (let i = 0; i < resData.length; i++) {
                    $('.table-content').append($tr)
                    if (resData[i].id == null || resData[i].id == '') {
                        var id = '——'
                    } else {
                        var id = "+" + resData[i].id.split('@')[1] + " " + resData[i].id.split('@')[0]
                    }
                    let seq = resData[i].user
                    let nickname = resData[i].nickname
                    let gender = resData[i].gender
                    let age = resData[i].age
                    let firstTimeYears = resData[i].firstTime.split(' ')[0]
                    let firstTimeHours = resData[i].firstTime.split(' ')[1]
                    let endTimeYears = resData[i].endTime.split(' ')[0]
                    let endTimeHours = resData[i].endTime.split(' ')[1]
                    let percent = resData[i].rate
                    let count = resData[i].scannedCount
                    if (gender == null || gender == '') {
                        gender = '——'
                    }
                    if (nickname == null || nickname == '') {
                        nickname = '——'
                    }
                    $(".table-content .table-tr:eq("+ i +")").attr('data-seq', seq)
                    $(".table-content .table-tr:eq("+ i +") .table-td-id").text(id)
                    $(".table-content .table-tr:eq("+ i +") .table-td-nickname").text(nickname)
                    $(".table-content .table-tr:eq("+ i +") .table-td-sex").text(gender)
                    $(".table-content .table-tr:eq("+ i +") .table-td-age").text(age)
                    $(".table-content .table-tr:eq("+ i +") .table-td-first .years").text(firstTimeYears)
                    $(".table-content .table-tr:eq("+ i +") .table-td-first .hours").text(firstTimeHours)
                    $(".table-content .table-tr:eq("+ i +") .table-td-last .years").text(endTimeYears)
                    $(".table-content .table-tr:eq("+ i +") .table-td-last .hours").text(endTimeHours)
                    $(".table-content .table-tr:eq("+ i +") .table-td-frequency").text(percent)
                    $(".table-content .table-tr:eq("+ i +") .table-td-count").text(count)
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

    $(".table-content").on('click', '.table-tr .see-more', function () {
        let seq = $(this).parent().attr('data-seq')
        console.log(typeof(seq))
        let detailLimit = 8
        let detailPage = 1
        window.location.href = '/customer/scanned/details?seq=' + seq + '&limit=' + detailLimit + '&page=' + detailPage
    })
</script>
@endsection