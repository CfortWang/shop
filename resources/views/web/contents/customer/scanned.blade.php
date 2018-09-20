@extends('web.layouts.app')
@section('content')

    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-content-wrapper">
            <div class="row">
                <div class="note note-info">
                    <h3>@lang('customer/scannedList.title.title1')
                        <span class="close" data-close="note"></span>
                    </h3>
                    <p>@lang('customer/scannedList.title.title2')</p>
                </div>
            </div>
            <div class="row">
                    <div class="dashboard-stat">
                    @lang('customer/scannedList.title.title3')
                    </div>
            </div>
            <div class="row"> 
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                        <div class="tpl-caption font-green ">
                             <span><button type="button" class="am-btn am-btn-danger">搜索</button></span>
                        </div>
                        <div class="tpl-portlet-input">
                                <div class="portlet-input input-small input-inline">
                                    <div class="">
                                        <input type="text" class="form-control form-control-solid" placeholder="输入手机号查找">
                                    </div>
                                </div>
                        </div>   
                    </div>  
                    <div class="dashboard-stat">
                    用户列表
                    </div>  
                    <div class="table-responsive">
                    <table class="am-table am-table-striped am-table-hover scanned-list-table">
                        <thead>
                            <tr>
                                <th>用户名id</th>
                                <th>昵称</th>
                                <th>性别</th>
                                <th>年龄</th>
                                <th>首次扫码时间</th>
                                <th>最后一次扫码时间</th>
                                <th>扫码频率(月)</th>
                                <th>扫码总次数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>Amaze UI</td>
                                <td>http://amazeui.org</td>
                                <td>2012-10-01</td>
                                <td>Amaze UI</td>
                                <td>http://amazeui.org</td>
                                <td>2012-10-01</td>
                                <td>http://amazeui.org</td>
                                <td>2012-10-01</td>
                            </tr>
                            <tr>
                                <td>Amaze UI</td>
                                <td>http://amazeui.org</td>
                                <td>2012-10-01</td>
                                <td>Amaze UI</td>
                                <td>http://amazeui.org</td>
                                <td>2012-10-01</td>
                                <td>http://amazeui.org</td>
                                <td>2012-10-01</td>
                            </tr>
                            </tr> -->
                            </tbody>
                        </table>
                       </div>
            </div> 
        </div>
   </div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    console.log(2)
    $('.scanned-list-table').DataTable({
        pageLength: 10,
        responsive: true,
        dom: 'f<"row"t>p',
        order: [[ 3, "desc" ]],
        language: {
            "zeroRecords": "@lang('client/list.table.pagination.no_data')",
            "info": "_PAGE_ / _PAGES_ ",
            "search": "@lang('client/list.table.pagination.search') :",
            "paginate": {
                "next":       "@lang('client/list.table.pagination.next')",
                "previous":   "@lang('client/list.table.pagination.prev')"
            },
        },
        deferRender: true,
        processing:true,
        serverSide:true,
        ajax: {
            url: "{{ url('/api/client/list')}}",
            dataType:'json',
            dataFilter: function(data){
                var json = jQuery.parseJSON( data );
                return JSON.stringify( json.data ); // return JSON string
            }
        },
        columns:[
            {
                data: "user_name",
                className: "text-center",
            },
            {
                data: "user_phone_num",
                className: "text-center",
            },
            {
                data: "q35code_code",
                className: "text-center",
            },
            {
                data: "q35package_code",
                className: "text-center",
            },
            {
                data: "created_at",
                className: "text-center",
                render: function(data, type, row) {
                    var utcDate = row.created_at;
                    var chinaDate = moment(utcDate).add(8, 'hours').format('YYYY-MM-DD HH:mm:ss')
                    return chinaDate;
                }
            },
        ]
    });
});
</script>
@endsection