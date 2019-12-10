@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Lịch sử nạp tiền</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="stripeRecharge">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Kiểu nạp tiền</th>
                            <th scope="col">Số tiền đã nạp</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
var dataTable = null;

$(document).ready(function() {
    
    var dataObject = [
        {
            data: "user_id",
            class: "text-center",
        },
        {
            data: "user_name",
            class: "text-center",
        },
        {
            data: "payments_name",
            class: "text-center",
        },
        {
            data: "amount",
            class: "text-center",
        },
        
    ];

    dataTable = $('#stripeRecharge').DataTable({
        serverSide: false,
        search: {
            smart: false
        },
        aaSorting: [],
        stateSave: true,
        ajax:{
            url: baseURL + "/admincp/history/getDataAjax",
            beforeSend: function() {
                $(".ajax_waiting").addClass("loading");
            }
        }, 
        columns: dataObject,
        bLengthChange: true,
        pageLength: 10,
        order: [[ 0, "DESC" ]],
        colReorder: {
            fixedColumnsRight: 1,
            fixedColumnsLeft: 1
        },
        oLanguage: {
            sSearch: "Tìm kiếm",
            sLengthMenu: "Hiển thị _MENU_ bản ghi",
            sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
            sInfoFiltered: "",
            sInfoEmpty: "",
            sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
            sEmptyTable: "Chưa có phản hồi",
            oPaginate: {
                sPrevious: "Trang trước",
                sNext: "Trang sau",

            },
        },
        fnDrawCallback: function( oSettings ) {
            addEventListener();
        },
    });
    $('#stripeRecharge').css('width', '100%');

    function addEventListener(){

        
    }

});
</script>
@endsection