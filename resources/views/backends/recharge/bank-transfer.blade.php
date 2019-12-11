@extends('backends.master')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
</section>
<section class="content page">
    <div id="bankTransfer">
        <h1 class="text-center font-weight-600">Chuyển khoản ngân hàng</h1>
        <div class="form-group row">
            <label class="col-sm-3">Bật/Tắt</label>
            <div class="col-sm-9 turn-on-off">
                <input type="checkbox" @if($bank_transfer->status == 1) checked="checked" value="1" @else value="0" @endif>
                <span>Bật chuyển khoản ngân hàng</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Tiều đề</label>
            <div class="col-sm-9 title-desc">
                <input class="form-control" type="text" value="{{$bank_transfer->title}}" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Mô tả</label>
            <div class="col-sm-9 description">
            <textarea rows="3" cols="20" class="form-control" type="textarea">{{$bank_transfer->description}}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Hướng dẫn</label>
            <div class="col-sm-9 instruction">
                <textarea rows="3" cols="20" class="form-control" type="textarea">{{$bank_transfer->instruction}}</textarea>
            </div>
        </div>
        <h2 class="text-center">Thông tin tài khoản</h2>
        <div class="text-center">
            <a class="btn btn-primary add-bank-account" title="Thêm tài khoản"> <i class="fa fa-plus fa-fw"></i><b>THÊM TÀI KHOẢN</b></a>
        </div>
        <div>
            <table class="table table-bordered" id="bankTransferTable">
                <thead class="thead-custom">
                    <tr>
                        {{-- <th></th> --}}
                        <th scope="col">Tên tài khoản</th>
                        <th scope="col">Số tài khoản</th>
                        <th scope="col">Ngân hàng</th>
                        <th scope="col">Sửa</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a class="btn btn-primary bank-transfer-button-save" title="Lưu thay đổi"><b>Lưu thay đổi</b></a>
        </div>
        <div class="modal fade" id="addAccountModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600">Thêm tài khoản ngân hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row form-html">
                            <label class="col-sm-3">Tên tài khoản</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" placeholder="">
                            </div>
                            <div class="form-html-validate account_name"></div>
                        </div>
                        <div class="form-group row form-html">
                            <label class="col-sm-3">Số tài khoản</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="account_number" placeholder="">
                            </div>
                            <div class="form-html-validate account_number"></div>
                        </div>
                        <div class="form-group row form-html">
                            <label class="col-sm-3">Tên ngân hàng</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="bank_name" placeholder="">
                            </div>
                            <div class="form-html-validate bank_name"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="addBankAccount""><b>Xác nhận</b></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><b>Hủy bỏ</b></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editAccountModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600">Sửa tài khoản ngân hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row form-html">
                            <label class="col-sm-3">Tên tài khoản</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" placeholder="">
                            </div>
                            <div class="form-html-validate account_name"></div>
                        </div>
                        <div class="form-group row form-html">
                            <label class="col-sm-3">Số tài khoản</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="account_number" placeholder="">
                            </div>
                            <div class="form-html-validate account_number"></div>
                        </div>
                        <div class="form-group row form-html">
                            <label class="col-sm-3">Tên ngân hàng</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="bank_name" placeholder="">
                            </div>
                            <div class="form-html-validate bank_name"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary confirm-edit-account"><b>Xác nhận</b></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><b>Hủy bỏ</b></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
var dataTable = null;
var userCheckList = [];
var current_page = 0;
var old_search = '';
var errorConnect = "Please check your internet connection and try again.";

$(document).ready(function() {
    $('.turn-on-off span').click(function(){
        $('.turn-on-off input').click()
    })
    $('.turn-on-off input').click(function(){
        var value = $('.turn-on-off input').val()
        if ( value == 0 ){
            $('.turn-on-off input').val(1)
        }else{
            $('.turn-on-off input').val(0)
        }
    })

    var dataObject = [
        // {
        //     data: "action",
        //     class: "text-center",
        //     orderable: false
        // },
        {
            data: "name",
        },
        {
            data: "account_number",
        },
        {
            data: "bank_name",
        },
        {
            data: "action",
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="edit-bank-account" data-id="' + data + '"  title="Sửa"> <i class="fa fa-pencil fa-fw"></i>Sửa</a>';
                return html;
            },
            orderable: false
        },
        {
            data: "action",
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="delete-bank-account" data-id="' + data + '" title="Xóa"><i class="fa fa-trash fa-fw"></i>Xóa</a>';
                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#bankTransferTable').DataTable({
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
            url: baseURL + "/admincp/recharge-bank-transfer/get-bank-account",
            beforeSend: function() {
                $(".ajax_waiting").addClass("loading");
            }
        }, 
        columns: dataObject,
        bLengthChange: true,
        pageLength: 10,
        // columnDefs:[
        //     { 
        //         targets: 0,
        //         searchable: false,
        //         orderable: false,
        //         render: function(data, type, row) {
        //             var html = '';
        //             if(type === 'display'){
        //                 if ( row.status == 1 ){
        //                     html = '<input type="radio" name="id" value="' + data + '" checked="checked">';
        //                 }else{
        //                     html = '<input type="radio" name="id" value="' + data + '">';
        //                 }
        //             }
        //             return html;
        //         },
        //     }
        // ],
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
            $(row).attr('data-name', data['name']);
            $(row).attr('data-account-number', data['account_number']);
            $(row).attr('data-bank-name', data['bank_name']);
        }
    });

    $('#bankTransferTable').css('width', '100%');

    $('.add-bank-account').off('click')
    $('.add-bank-account').click(function() {
        $('#addAccountModal').modal('show');
        clearFormCreate();
    })

    $('#addBankAccount').click(function(){
        var account_name  = $('#addAccountModal input[name=name]').val()
        var account_number = $('#addAccountModal input[name=account_number]').val()
        var bank_name  = $('#addAccountModal input[name=bank_name]').val()
        console.log(account_name)

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var request = $.ajax({
            url: baseURL+"/admincp/recharge-bank-transfer/add-bank-account",
            data: {
                account_name : account_name,
                account_number : account_number,
                bank_name : bank_name,
            },
            method: "POST",
            dataType:'json',
            beforeSend: function(r, a){
                $('.alert-errors').addClass('d-none');
            },
            success: function (response) {
                if(response.status == 200){
                    $('#addAccountModal').modal('hide');
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

    function addEventListener() {
        $('.edit-bank-account').off('click')
        $('.edit-bank-account').click(function() {
            $('#editAccountModal').modal('show');
            clearFormCreate();
            $('.confirm-edit-account').attr('data-id', $(this).attr('data-id'))
            $('input[name=name]').val($(this).parent().parent().attr('data-name'))
            $('input[name=account_number]').val($(this).parent().parent().attr('data-account-number'))
            $('input[name=bank_name]').val($(this).parent().parent().attr('data-bank-name'))
        })

        $('.delete-bank-account').off('click')
        $('.delete-bank-account').click(function(){
            var id = $(this).attr('data-id')

            Swal.fire({
                type: 'warning',
                text: 'Xác nhận xóa tài khoản đã chọn',
                showCancelButton: true,
            }).then(result => {
                if(result.value){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: baseURL+"/admincp/recharge-bank-transfer/delete-bank-account",
                        data: {
                            id : id,
                        },
                        method: "POST",
                        dataType:'json',
                        beforeSend: function(r, a){
                            $('.alert-errors').addClass('d-none');
                        },
                        success: function (response) {
                            if(response.status == 200){
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
                        }
                    })
                }
            })
        })

        $('.confirm-edit-account').off('click')
        $('.confirm-edit-account').click(function(){
            var id = $(this).attr('data-id')
            var account_name  = $('#editAccountModal input[name=name]').val()
            var account_number = $('#editAccountModal input[name=account_number]').val()
            var bank_name  = $('#editAccountModal input[name=bank_name]').val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                url: baseURL+"/admincp/recharge-bank-transfer/edit-bank-account",
                data: {
                    id : id,
                    account_name : account_name,
                    account_number : account_number,
                    bank_name : bank_name,
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
    function clearFormCreate(){
        $('input[name=name]').val('')
        $('input[name=account_number]').val('')
        $('input[name=bank_name]').val('')
        $('.form-html-validate').html('')
    }

    $('.bank-transfer-button-save').click(function(){
        var turn_on_off  = $('.turn-on-off input').val()
        var title_desc = $('.title-desc input').val()
        var description  = $('.description textarea').val()
        var instruction = $('.instruction textarea').val()
        // var account_id = $('#bankTransferTable input[name=id]:checked').val()
        // console.log(account_id);return
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
            }
        });
        var request = $.ajax({
            url: baseURL+"/admincp/recharge-bank-transfer/save-bank-transfer",
            data: {
                turn_on_off : turn_on_off,
                title_desc : title_desc,
                description : description,
                instruction : instruction,
                // account_id : account_id,
            },
            method: "POST",
            dataType:'json',
            beforeSend: function(r, a){
                $('.alert-errors').addClass('d-none');
            },
            success: function (response) {
                if(response.status == 200){
                    $('#addAccountModal').modal('hide');
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
            }
        })
    })
})
</script>
@endsection