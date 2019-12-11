@extends('backends.master')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
</section>
<section class="content page">
    <div id="userAmount">
        <h1 class="text-center font-weight-600">Số tiền trong tài khoản người dùng</h1>
        <div>
            <table class="table table-bordered" id="userAmountTable">
                <thead class="thead-custom">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Số tiền</th>
                        <th scope="col">Nạp tiền</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="addAmountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Nạp tiền qua tài khoản ngân hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3">ID</label>
                        <div class="col-sm-9">
                            <div class="user-id"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Tên tài khoản</label>
                        <div class="col-sm-9">
                            <div class="user-name"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Số tiền (VND)</label>
                        <div class="col-sm-9">
                            <input class="form-control user-amount" type="number" name="user_amount" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Số tiền nạp (VND)</label>
                        <div class="col-sm-9">
                            <input class="form-control recharge-amount" type="number" min=0 name="recharge_amount" placeholder="" id="rechargeCoin">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-add-user-amount"><b>Xác nhận</b></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><b>Hủy bỏ</b></button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
document.getElementById('rechargeCoin').onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58)
        || e.keyCode == 8)) {
            return false;
        }
    }
var dataTable = null;
var userCheckList = [];
var current_page = 0;
var old_search = '';
var errorConnect = "Please check your internet connection and try again.";
$(document).ready(function(){
    var dataObject = [
        {
            data: "id",
            class: 'text-center'
        },
        {
            data: "name",
        },
        {
            data: "coins",
            render: function(data, type, row){
                if(type == "display"){
                    var html = '<div style="text-align: right">';
                        html += numberFormat(data, 0, '.', '.') + ' đ';
                        html += '</div>'
                    return html;
                }
                return data;
            },
        },
        {
            data: "action",
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="add-amount-user" data-id="' + data + '"  title="Nạp tiền"> <i class="fa fa-plus fa-fw"></i>Nạp tiền</a>';
                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#userAmountTable').DataTable({
        serverSide: false,
        search: {
            smart: false
        },
        aaSorting: [],
        stateSave: true,
        search: {
            smart: false
        },
        ajax:{
            url: baseURL + "/admincp/user-amount/get-user-amount",
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
            // zeroRecords: "Không tìm thấy bản ghi",
            sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
            sInfoFiltered: "",
            sInfoEmpty: "",
            sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
            sEmptyTable: "Chưa có tài khoản",
            oPaginate: {
                sPrevious: "Trang trước",
                sNext: "Trang sau",

            },
        },
        fnServerParams: function(aoData) {

        },
        fnDrawCallback: function(oSettings) {
            addEventListener();
        },
        createdRow: function( row, data, dataIndex){
            $(row).attr('data-id', data['id']);
            $(row).attr('data-name', data['name']);
            $(row).attr('data-amount', data['coins']);
        }
    });
    $('#userAmountTable').css('width', '100%');
    $('.dataTables_filter input').unbind().bind('keyup', function() {
       var searchTerm = this.value.toLowerCase(),
           regex = '\\b' + searchTerm + '\\b';
       dataTable.rows().search(regex, true, false).draw();
    })

    function addEventListener(){
        $('.add-amount-user').off('click')
        $('.add-amount-user').click(function(){
            $('#addAmountModal').modal('show');
            $('.user-id').html($(this).parent().parent().attr('data-id'))
            $('.user-name').html($(this).parent().parent().attr('data-name'))
            $('input[name=user_amount]').val($(this).parent().parent().attr('data-amount'))
            $('.btn-add-user-amount').attr('data-id', $(this).parent().parent().attr('data-id'))
        })

        $('.btn-add-user-amount').off('click')
        $('.btn-add-user-amount').click(function(){
            var user_id = $(this).attr('data-id')
            var recharge_coins  =$('input[name=recharge_amount]').val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                url: baseURL+"/admincp/user-amount/edit-user-amount",
                data: {
                    id : user_id,
                    recharge_coins : recharge_coins
                },
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').addClass('d-none');
                },
                success: function (response) {
                    if(response.status == 200){
                        $('#editAccountModal').modal('hide');
                        Swal.fire({
                            type: 'success',
                            text: response.message
                        }).then( result => {
                            location.reload()
                        })
                    } else {
                        Swal.fire({
                            type: 'warning',
                            text: response.message
                        })
                    }
                },
                error: function (error) {
                    var obj_errors = error.responseJSON.errors;
                    $('.form-html-validate').css('display', 'block')
                    $('.form-html-validate').html('')
                    $.each(obj_errors, function( index, value ) {
                        var content = '<i class="fa fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                        $('.form-html-validate.' + index).html(content);
                    })
                    $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                }
            })
        })
    }
})
</script>
@endsection