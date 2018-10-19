@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
        <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12 row-mb pdd">
                        <div class="tpl-portlet-title">
                            <!-- <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="请输入喜豆码编码查找">
                                <button class="search-btn">搜索</button>
                            </div> -->

                            <div class="center-caption">
                                <span>积分列表</span>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="code-table">
                            <div class="code-table">
                                <div class="table-title clear-fix">
                                    <div class="details">详情描述</div>
                                    <div class="integral">积分</div>
                                    <div class="remainder">剩余积分</div>
                                    <div class="create-time">创建时间</div>
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
    var page = 1
    var limit = 8
    var pageCount
    var drawList = function () {
        $.ajax({
            url: 'http://shop.test/api/account/scoreList',
            type: 'get',
            dataType: 'json',
            data: {
                limit: limit,
                page: page
            },
            success: function (res) {
                console.log(res)
                $(".table-content").empty()
                let resData = res.data.data
                let count = res.data.count
                pageCount = Math.ceil(count / limit)
                var $tr = '<div class="table-tr"><div class="table-td-details"></div><div class="table-td-integral"></div><div class="table-td-remainder"></div><div class="table-td-create"></div></div>'
                for (let i = 0; i < resData.length; i++) {
                    $(".code-table .table-content").append($tr)
                    let details = resData[i].description
                    let usedPoint = resData[i].signed_point
                    let leftPoint = resData[i].remain_point
                    let createTime = resData[i].created_at
                    let id = resData[i].seq

                    // $(".code-table .table-content .table-tr:eq("+ i +") .table-td-code").attr("data-seq", id)
                    $(".code-table .table-content .table-tr:eq("+ i +") .table-td-details").text(details)
                    $(".code-table .table-content .table-tr:eq("+ i +") .table-td-integral").text(usedPoint)
                    $(".code-table .table-content .table-tr:eq("+ i +") .table-td-remainder").text(leftPoint)
                    $(".code-table .table-content .table-tr:eq("+ i +") .table-td-create ").text(createTime)
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
