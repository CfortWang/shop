@extends('web.layouts.app')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@lang('cash/list.header.title')</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">@lang('cash/list.header.depth1')</a>
            </li>
            <li>
                <a href="{{ url('/cash/list') }}">@lang('cash/list.header.depth2')</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>@lang('cash/list.contents.title')</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="form1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover cash-list-table">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('cash/list.table.title.Amount')</th>
                                    <th class="text-center">@lang('cash/list.table.title.BuyerID')</th>
                                    <th class="text-center">@lang('cash/list.table.title.Bank')</th>
                                    <th class="text-center">@lang('cash/list.table.title.Holder')</th>
                                    <th class="text-center">@lang('cash/list.table.title.Account')</th>  
                                    <th class="text-center">@lang('cash/list.table.title.Register_Date')</th>
                                    <th class="text-center">@lang('cash/list.table.title.status')</th>    
                                </tr>
                            </thead>                      
                        </table>
                    </div>            
                    </form>  
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a class="btn btn-w-m btn-warning request-btn" href="" data-toggle="modal">@lang('cash/list.button.Cash_out')</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">@lang('cash/list.modal.title1')</h4>
            </div>
            <div class="modal-body">
                <div>
                @lang('cash/list.modal.msg1')
                    <input name="reject" id="cash-reject" class="form-control" disabled/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('cash/list.modal.cancel')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="request-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">@lang('cash/list.modal.title2')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>@lang('cash/list.modal.availablePoint')</label>
                    <input type="text" id="available-point" class="form-control" disabled>
                    <input type="hidden" id="available-point-number" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>@lang('cash/list.modal.amount')</label>
                    <input type="number" id="modal-amount" class="form-control">
                </div>
                <div class="form-group">
                    <label>@lang('cash/list.modal.bankName')</label>
                    <input type="text" id="bank-name" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>@lang('cash/list.modal.bankAccount')</label>
                    <input type="text" id="bank-account" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>@lang('cash/list.modal.bankAccountOwner')</label>
                    <input type="text" id="bank-account-owner" class="form-control" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-cash-request" class="btn btn-primary">@lang('cash/list.modal.cashRequest')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('cash/list.modal.cancel')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
@section('scripts')
<script>
    var noBankInfo = '{{ __("cash/list.message.noBankInfo") }}';
    var wrongRequest = '{{ __("cash/list.message.wrongRequest") }}';
    var pointValidation = '{{ __("cash/list.message.pointValidation") }}';
    var minPoint = '{{ __("cash/list.message.minPoint") }}';
    var notEnoughPoint = '{{ __("cash/list.message.notEnoughPoint") }}';
    var requestSuccess = '{{ __("cash/list.message.requestSuccess") }}';
    var serverErr = '{{ __("cash/list.message.serverErr") }}';

    $(document).ready(function(){
        var CashOutListTable = $('.cash-list-table').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"row"<"#status-box.col-lg-6 text-left"><"col-lg-6 text-right"f>><"row"t>p',
            order: [[ 5, "desc" ]],
            language: {
                "zeroRecords": "@lang('cash/list.table.pagination.no_data')",
                "info": "_PAGE_ / _PAGES_ ",
                "search": "@lang('cash/list.table.pagination.search') :",
                "paginate": {
                    "next":       "@lang('cash/list.table.pagination.next')",
                    "previous":   "@lang('cash/list.table.pagination.prev')"
                },
            },
            deferRender: true,
            processing:true,
            serverSide:true,
            ajax: {
                url: "{{ url('api/cash/list/')}}",
                dataType:'json',
                dataFilter: function(data){
                    var json = jQuery.parseJSON( data );
                    return JSON.stringify( json.data ); // return JSON string
                },
                data: function(d) {
                    d.status = $('.table-responsive #status-box #status').val() || '';
                }
            },
            initComplete: function(settings) {
                var statusSelectStr = "";
                
                statusSelectStr += "<select id='status' class='form-control input-sm'>";
                statusSelectStr += "    <option value=''>@lang('cash/list.status.all')</option>";
                statusSelectStr += "    <option value='requested'>@lang('cash/list.status.request')</option>";
                statusSelectStr += "    <option value='deposited'>@lang('cash/list.status.deposite')</option>";
                statusSelectStr += "    <option value='rejected'>@lang('cash/list.status.reject')</option>";
                statusSelectStr += "</select>";

                $('.table-responsive #status-box').append(statusSelectStr);
                
                $('.table-responsive #status-box #status').change(function() {
                    CashOutListTable.ajax.reload();
                });
                $('.rejected-btn').click(function(){
                    $('#cash-reject').val($(this).data('msg'));
                })
            },
            columns:[
                {
                    data: "",
                    className: "text-center",
                    render: function(data, type, row) {
                        return Number(row.amount).toLocaleString('en');
                    }
                },
                
                {
                    data: "",
                    className: "text-center",
                    render: function(data, type, row) {
                        return row.id;
                    }
                },
                {
                    data: "",
                    className: "text-center",
                    render: function(data, type, row) {
                        return row.bank_name;
                    }
                },
                {
                    data: "",
                    className: "text-center",
                    render: function(data, type, row) {
                        return row.account_holder;
                    }
                },
                {
                    data: "",
                    className: "text-center",
                    render: function(data, type, row) {
                        return row.account_number;
                    }
                },
                {
                    data: "",
                    className: "text-center",
                    render: function(data, type, row) {
                        var utcDate = row.created_at;
                        var chinaDate = moment(utcDate).add(8, 'hours').format('YYYY-MM-DD HH:mm:ss')
                        return chinaDate;
                    }
                },
                {
                    data: "",
                    className: "text-center",
                    render: function(data,type,row) {
                        var status=row.status;
                        if(status=='rejected'){
                            var details = '<a href="javascript:;" class="rejected-btn" data-msg="'+row.remark+'"  data-toggle="modal" data-target="#myModal1">rejected</a>';
                        }else{
                            var details = row.status;
                        }
                        return details;
                    }
                },
            ],
        });
        $('.request-btn').click(function () {
            $.ajax({
                url: "{{ url('/api/cash/validation') }}", 
                dataType: 'json',
                type: 'GET',
            }).done(function(res) {
                //console.log(res);
                $('#available-point').val(Number(res.data[0].point).toLocaleString('en'));
                $('#available-point-number').val(res.data[0].point);
                $('#modal-amount').val(0);
                $('#bank-name').val(res.data[1].bank_name);
                $('#bank-account').val(res.data[0].bank_account);
                $('#bank-account-owner').val(res.data[0].bank_account_owner);
                $('#request-modal').modal('show');
            }).fail(function(res) {
                var httpStatus = res.status;
                var detailStatus = res.responseJSON.status;
                if (httpStatus === 404 && detailStatus === 401) {
                    bootbox.alert(wrongRequest); 
                } else if (httpStatus === 400 && detailStatus === 401) {
                    bootbox.alert(noBankInfo);
                } else {
                    bootbox.alert(serverErr); 
                }
                console.log(e);
            });
        });
        $('#modal-cash-request').click(function () {
            var modalAmount = $('#modal-amount').val();
            var availablePoint = $('#available-point-number').val();

            if (modalAmount === '') {
                bootbox.alert(pointValidation);
                return false;
            }

            if (parseInt(modalAmount) < 20000) {
                bootbox.alert(minPoint);
                return false;
            }

            if (parseInt(modalAmount) > parseInt(availablePoint)) {
                bootbox.alert(notEnoughPoint);
                return false;
            }
            $.ajax({
                url: "{{ url('/api/cash/request') }}", 
                dataType: 'json',
                data: {
                    'modal_amount' : modalAmount
                },
                type: 'POST',
            }).done(function(res) {
                bootbox.alert(requestSuccess, function(){
                    location.reload();
                });
            }).fail(function(res) {
                var httpStatus = res.status;
                var detailStatus = res.responseJSON.status;
                if (httpStatus === 404 && detailStatus === 401) {
                    bootbox.alert(wrongRequest); 
                } else if (httpStatus === 400 && detailStatus === 401) {
                    bootbox.alert(noBankInfo);
                } else {
                    bootbox.alert(serverErr); 
                }
                console.log(e);
            });
        });
    });

</script>
@endsection
@section('scripts')
    <script src="js/echarts.min.js"></script>
@endsection

