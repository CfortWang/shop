@extends('web.layouts.app')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/css/app.css">
@endsection('css')
@section('content')
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet code-details">
                <div class="row">
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">喜豆码编码：</label>
                        <div class="info-content" id="coding"></div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">总码数：</label>
                        <div class="info-content" id="amount"></div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">码类型：</label>
                        <div class="info-content" id="code-type">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">已用码数：</label>
                        <div class="info-content" id="used">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">起始编码：</label>
                        <div class="info-content" id="start-code">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">终止编码：</label>
                        <div class="info-content" id="end-code">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">状态：</label>
                        <div class="info-content" id="code-status">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">支付日期：</label>
                        <div class="info-content" id="pay-time">
                        </div>
                    </div>
                    <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 code-info">
                        <label class="info-title">激活日期：</label>
                        <div class="info-content" id="active-time">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tpl-portlet">
                <div class="row">
                    <div class="am-u-md-12 am-u-sm-12 row-mb pdd">
                        <div class="tpl-portlet-title">
                            <!-- <div class="search-box">
                                <input type="text" class="search-input" name="search" placeholder="请输入喜豆码编码查找">
                                <button class="search-btn">搜索</button>
                            </div> -->
                            <div class="status-filter">
                                <select data-am-selected="{btnStyle: 'secondary'}">
                                    <option value="all">所有</option>
                                    <option value="activated">已激活</option>
                                    <option value="used">已使用</option>
                                </select>
                            </div>
                        </div>
                        <div class="tpl-echarts" id="code-table">
                            <div class="code-table">
                                <div class="table-title clear-fix">
                                    <div class="code">喜豆码编码</div>
                                    <div class="active-time">激活日期</div>
                                    <div class="use-time">使用日期</div>
                                    <div class="status">状态</div>
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
    var getArgs = function () {
        var url = location.search
        var args = {}
        if (url.indexOf("?") != -1) {
            var str = url.substr(1)
            var strs = str.split("&")
            for (let i = 0; i < strs.length; i++) {
                args[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1])
            }
        }
        return args
    }
    var args = getArgs();
    var seq = args['id']

    var drawInfo = function () {
        $.ajax({
            url: '/api/packages/my_package/myPackageDetail',
            type: 'get',
            dataType: 'json',
            data: {
                seq: seq
            },
            success: function (res) {
                // $(".info-content").empty()
                console.log(res)
                let resData = res.data
                $("#coding").text(resData.code)
                $("#amount").text(resData.total_cnt)
                $("#code-type").text(resData.type)
                $("#used").text(resData.used_cnt)
                $("#start-code").text(resData.start_q35code)
                $("#end-code").text(resData.end_q35code)
                $("#code-status").text(resData.status)
                $("#pay-time").text(resData.sold_at)
                $("#active-time").text(resData.activated_at)
            },
            error: function (ex) {
                console.log(ex)
            }
        })
    }
    drawInfo();

    var limit = 8
    var page = 1
    var pageCount
    // var keyword = ''
    var selectStatus = ''
    var drawList = function () {
        $.ajax({
            url: '/api/packages/my_package/codeDetailList',
            type: 'get',
            dataType: 'json',
            data: {
                limit: limit,
                page: page,
                seq: seq,
                status: selectStatus
            },
            success: function (res) {
                $(".table-content").empty()
                let resData = res.data.data
                let count = res.data.count
                if (count) {
                    $(".no-data").hide()
                    $(".pagination").show()
                    pageCount = Math.ceil(count / limit)
                    var $tr = '<div class="table-tr clear-fix"><div class="table-td-code"></div><div class="table-td-active"></div><div class="table-td-used"></div><div class="table-td-status"></div></div>'
                    for (let i = 0; i < resData.length; i++) {
                        $('.table-content').append($tr)
                        let code = resData[i].code
                        let activeTime = resData[i].activated_at
                        let status = resData[i].status
                        let id = resData[i].seq

                        if (resData[i].used_at == '' || resData[i].used_at == null) {
                            var useTime = "——"
                        } else {
                            var useTime = resData[i].used_at
                        }

                        $(".table-content .table-tr:eq("+ i +") .table-td-code").text(code)
                        $(".table-content .table-tr:eq("+ i +") .table-td-active").text(activeTime)
                        $(".table-content .table-tr:eq("+ i +") .table-td-used").text(useTime)
                        $(".table-content .table-tr:eq("+ i +") .table-td-status").text(status)
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


    // $(".search-btn").on("click", function () {
    //     keyword = $(".search-input").val()
    //     drawList();
    //     $(".search-input").val("")
    // })

    $("body").on("click", ".am-selected-list > li", function () {
        selectStatus = $(this).attr("data-value")
        if (selectStatus == 'all') {
            selectStatus = ''
        }
        drawList();
    })
</script>
@endsection
