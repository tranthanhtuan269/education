@extends('backends.master')
@section('content')

<!-- Begin MultiSelect -->
<link href="{{ asset('backend/css/sol.css') }}" rel="stylesheet" />
<script src="{{ asset('backend/js/sol.js') }}"></script>
<!-- End MultiSelect -->

{{-- Datatable --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Danh sách Mã giảm giá</h1>
    <div class="text-center">
        <button class="btn btn-primary" id="addCouponModal"><i class="fa fa-plus fa-fw"></i><b>THÊM COUPON</b></button>
    </div>

    <div class="modal fade" id="showAddCouponModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Thêm COUPON</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <h3><b>Nhập mã Coupon</b></h3>
                                {{-- <label>Mã Coupon</label>
                                <input type="text" class="form-control" id="coupon_code" name="name"> --}}
                                {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Mã Coupon', '', 'coupon_code', 'id="coupon_code"') !!}
                                {{-- <label>Nhập số % của Coupon</label>
                                <input type="number" class="form-control" id="coupon_value" min="1" max="100" name="value"> --}}
                                {!! \App\Helper\Helper::insertInputForm('number', 'value', 'Nhập số % của Coupon', '', 'coupon_value', 'id="coupon_value" min="1" max="100"') !!}
                                <div class="form-group form-html">
                                    <label>Nhập ngày hết hạn của Coupon</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="coupon_expired" pattern="\d{1,2}/\d{1,2}/\d{4}" value="" autocomplete="off" onkeydown="return false">
                                    </div>
                                    <div class="form-html-validate coupon_expired"></div>
                                </div>
                                <script src="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
                                <script>
                                $('#coupon_expired').datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    startDate: new Date(),
                                    assumeNearbyYear: true
                                })
                                    // $(function() {
                                    // $( "#coupon_expired" ).datepicker({
                                    //         changeMonth: true,
                                    //         changeYear: true,
                                    //         yearRange: "2019:2050",
                                    //         dateFormat: 'yy-mm-dd',
                                    //         minDate: new Date(),
                                    //     }	
                                    // );
                                    // });
                                </script>
                            </div>
                            <div class="col-md-8">
                                <h3><b>Chọn khóa học được hưởng COUPON</b></h3><br>
                                <div class="form-html">
                                    <p><select id="demonstration" name="course[]" style="width: 570px" multiple="multiple">
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select></p>
                                    <div class="form-html-validate course_id"></div>
                                </div>
                            </div>
                        </div>
                        <input type="reset" id="resetFormCoupon" style="display:none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnConfirm"><b>Xác nhận</b></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><b>Hủy bỏ</b></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showEditCouponModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Sửa COUPON</h5>
                    <input type="hidden" id="couponIdUpdate" value="">
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <h3><b>Nhập mã Coupon</b></h3>
                                {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Mã Coupon', '', 'coupon_code', 'id="editCouponCode"') !!}
                                {!! \App\Helper\Helper::insertInputForm('number', 'value', 'Nhập số % của Coupon', '', 'coupon_value', 'id="editCouponValue" min="1" max="100"') !!}
                                <div class="form-group form-html">
                                    <label>Nhập ngày hết hạn của Coupon</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="editCouponExpired" name="expired" pattern="\d{1,2}/\d{1,2}/\d{4}" value="" autocomplete="off" onkeydown="return false">
                                    </div>
                                    <div class="form-html-validate coupon_expired"></div>
                                </div>
                                <script src="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
                                <script>
                                    $('#editCouponExpired').datepicker({
                                        autoclose: true,
                                        format: 'yyyy-mm-dd',
                                        startDate: new Date(),
                                        assumeNearbyYear: true
                                    })
                                </script>
                            </div>
                            <div class="col-md-8">
                                <h3><b>Chọn khóa học được hưởng Coupon</b></h3><br>
                                <label>Các khóa học đang được hưởng COUPON <span  id="addLabel"></span>:</label>
                                {{-- <div id="edit_course_id_view"></div>--}}
                                <br>
                                <div class="form-html">
                                    <select id="demonstrationEdit" name="course[]" style="width: 570px" multiple="multiple">
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-html-validate course_id"></div>
                                </div>
                            </div>
                        </div>
                        <input type="reset" id="resetEditCoupon" style="display:none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-edit-coupon" id="btnConfirmEdit"><b>Xác nhận</b></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><b>Hủy bỏ</b></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered" id="coupon-table">
                <thead class="thead-custom">
                    <tr>
                        <th>ID</th>
                        <th scope="col">Mã COUPON</th>
                        <th scope="col">Giá trị (%)</th>
                        <th scope="col">ID<br> Khóa học</th>
                        <th scope="col">Ngày hết hạn</th>
                        <th scope="col">Sửa</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    <br>
    
</section>
<script>
var dataTable           = null;
var solTemp = null;

$(document).ready(function(){

    var positive_number = document.getElementById('coupon_value')
    positive_number.onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
            return false;
        }
    }

    document.getElementById('editCouponValue').onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
            return false;
        }
    }

    function addEventListener() {

        $('.edit-coupon').off('click')
        $('.edit-coupon').click(function() {
            $('#showEditCouponModal').modal('show')
            var coupon_id           = $(this).attr('data-id')
            var coupon_code         = $(this).parent().parent().attr('data-code')
            var coupon_value        = $(this).parent().parent().attr('data-value')
            var coupon_course_id    = $(this).parent().parent().attr('data-course-id')
            var coupon_expired      = $(this).parent().parent().attr('data-expired')

            $("#couponIdUpdate").val(coupon_id)
            $("#editCouponCode").val(coupon_code)
            $("#editCouponValue").val(coupon_value)
            $("#editCouponExpired").val(coupon_expired)
            $("#edit_course_id_view").text(coupon_course_id)
            $("label #addLabel").text('"'+coupon_code+'"')

            var arr_course_id = coupon_course_id.split(',')

            $('#demonstrationEdit option').prop( "selected", null )

            $.each(arr_course_id, function(index, course_id){
                $('#demonstrationEdit option[value="'+course_id+'"]').attr('selected', true)
            })

            // $('#showEditCouponModal .sol-container').remove();
            // $('#resetEditCoupon').click()
            var solEdit = $('#demonstrationEdit').searchableOptionList({ 
                maxHeight: '250px',
                showSelectAll: true
            })

            solTemp = solEdit;
        })

        $('#showEditCouponModal').on('hidden.bs.modal', function () {
            location.reload();
        });

        $('.delete-coupon').off('click')
        $('.delete-coupon').click(function(e) {
            var coupon_id = $(this).attr('data-id')
            
            Swal.fire({
                type: 'warning',
                text : 'Bạn có chắc chắn muốn xoá COUPON này?',
                showCancelButton: true,
            }).then( result => {
                if(result.value){
                    $.ajax({
                        method: 'DELETE',
                        url: "{{ url('/') }}/admincp/coupon/delete",
                        data: {
                            coupon_id : coupon_id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if(response.status == '200'){
                                Swal.fire({
                                    type: 'success',
                                    text : 'Xóa COUPON thành công!',
                                })
                                dataTable.ajax.reload()
                            }
                        },
                    })                        
                }
            })
        });

        $('.confirm-edit-coupon').off('click')
        $('.confirm-edit-coupon').click(function(){
            var asInputs = solTemp.getSelection(), course_id = [];
            var coupon_id = $('#couponIdUpdate').val()
            var coupon_code = ($('#editCouponCode').val()).trim()
            var coupon_value = $('#editCouponValue').val()
            var coupon_expired = $('#editCouponExpired').val()

            for (var i = 0; i < asInputs.length; i++) {
                course_id[i] = $(asInputs[i]).data('sol-item').value;
            }
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/coupon/update",
                data: {
                    coupon_id      : coupon_id,
                    coupon_code    : coupon_code,
                    coupon_value   : coupon_value,
                    course_id      : course_id,
                    coupon_expired : coupon_expired
                },
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    
                },
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            text: 'Sửa mã giảm giá thành công!'
                        }).then( result => {
                            dataTable.ajax.reload();
                            $('#showEditCouponModal').modal('hide')
                        })
                    }
                    if(response.status == 403){
                        alertValidate('Mã giảm giá đã tồn tại!', 'coupon_code')
                        return;
                    }
                },
                error: function (response) {
                    var obj_errors = response.responseJSON.errors;
                    $('.form-html-validate').css('display', 'block')
                    $('.form-html-validate').html('')
                    $.each(obj_errors, function( index, value ) {
                        var content = '<i class="fa fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                        $('.form-html-validate.' + index).html(content);
                    })
                }
            })
        })
    }

    $('#addCouponModal').click(function(){
        $('#showAddCouponModal').modal('toggle')
        $('#resetFormCoupon').click()
    })

    // Begin Datatable
    var dataObject = [
        { 
            data: "id",
        },
        { 
            data: "name",
        },
        { 
            data: "value",
        },
        {
            data:"course_id",
            class: "coupon-course-id",
            orderable: false
        },
        { 
            data: "expired",
        },
        { 
            data: "action", 
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="edit-coupon" data-id="' + data + '" title="Sửa"> <i class="fa fa-pencil fa-fw"></i>Sửa</a>';
                return html;
            },
            orderable: false
        },
        { 
            data: "action", 
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="delete-coupon" data-id="' + data + '" title="Xóa"><i class="fa fa-trash fa-fw"></i>Xóa</a>';
                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#coupon-table').DataTable( {
                    serverSide: false,
                    aaSorting: [],
                    stateSave: true,
                    search: {
                        smart: false
                    },
                    ajax:{
                        url: "{{ url('/') }}/admincp/coupon/getCouponAjax",
                        beforeSend: function() {
                            $(".ajax_waiting").addClass("loading");
                        }
                    },  
                    columns: dataObject,
                    // bLengthChange: false,
                    // pageLength: 10,
                    order: [[ 1, "desc" ]],
                    colReorder: {
                        fixedColumnsRight: 0,
                        fixedColumnsLeft: 0
                    },
                    oLanguage: {
                        sSearch: "Tìm kiếm",
                        sLengthMenu: "Hiển thị _MENU_ bản ghi",
                        // zeroRecords: "Không tìm thấy bản ghi",
                        sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
                        sInfoFiltered: "",
                        sInfoEmpty: "",
                        sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                        sEmptyTable: "Chưa có mã giảm giá",
                        oPaginate: {
                            sPrevious: "Trang trước",
                            sNext: "Trang sau",

                        },
                    },
                    fnDrawCallback: function(oSettings) {
                        addEventListener();
                    },
                    createdRow: function( row, data, dataIndex){
                        $(row).attr('data-id', data['id']);
                        $(row).attr('data-code', data['name']);
                        $(row).attr('data-value', data['value']);
                        $(row).attr('data-course-id', data['course_id']);
                        $(row).attr('data-expired', data['expired']);
                    }
                });

    $('#coupon-table').css('width', '100%');
    // End Datatable

    $("#btnConfirm").click(function(){
        var asInputs = sol.getSelection(), course_id = []
        var coupon_code = ($('#coupon_code').val()).trim()
        var coupon_value = $('#coupon_value').val().trim()
        var coupon_expired = $('#coupon_expired').val().trim()

        // var flag = 7;
        // if(coupon_code == ''){
        //     alertValidate2('Bạn chưa nhập mã Coupon!', 'coupon_code')
        // }else{ flag-- }
        // if( coupon_code.length >=15 ){
        //     alertValidate2('Mã COUPON quá dài (Yêu cầu <15 ký tự)!', 'coupon_code')
        // }else{ flag-- }
        // if(coupon_value == ''){
        //     alertValidate2('Bạn chưa nhập số % được giảm!', 'coupon_value')
        // }else{ flag-- }
        // if( Number(coupon_value) <= 0 ){
        //     alertValidate2('% giá giảm không thể <= 0!', 'coupon_value')
        // }else{ flag-- }
        // if( Number(coupon_value) > 100 ){
        //     alertValidate2('% giá giảm không thể >100!', 'coupon_value')
        // }else{ flag-- }
        // if( !coupon_expired ){
        //     alertValidate2('Bạn chưa chọn ngày hết hạn COUPON!', 'coupon_expired')
        // }else{ flag-- }
        for (var i = 0; i < asInputs.length; i++) {
            course_id[i] = $(asInputs[i]).data('sol-item').value;
        }
        // if (course_id.length == 0) {
        //     alertValidate2('Chưa có khóa học nào được chọn!', 'course_id')
        // }else{ flag-- }
        // if ( flag != 0 ){
        //     return
        // }

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: baseURL+"/admincp/add-coupon",
            data: {
                coupon_code  : coupon_code,
                coupon_value : coupon_value,
                course_id    : course_id,
                coupon_expired : coupon_expired
            },
            method: "POST",
            dataType:'json',
            beforeSend: function(r, a){
                
            },
            success: function (response) {
                if(response.status == 200){
                    $('#showAddCouponModal').modal('hide')
                    Swal.fire({
                        type: 'success',
                        text: 'Thêm mã giảm giá thành công!'
                    })
                    dataTable.ajax.reload();
                }
                if(response.status == 403){
                    alertValidate('Mã giảm giá đã tồn tại!', 'coupon_code')
                }
            },
            error: function (response) {
                var obj_errors = response.responseJSON.errors;
                $('.form-html-validate').css('display', 'block')
                $('.form-html-validate').html('')
                $.each(obj_errors, function( index, value ) {
                    var content = '<i class="fa fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                    $('.form-html-validate.' + index).html(content);
                })
            }
        });
    });

    function checkEmptyTable(){
        if ($('#coupon-table').DataTable().data().count() <= 1 && current_page > 0) {
            current_page = current_page - 1;
        }
        return current_page;
    }
});

var sol = $('#demonstration').searchableOptionList({ 
    maxHeight: '230px',
    showSelectAll: true,
});

// var solEdit = $('#demonstrationEdit').searchableOptionList({ 
//     maxHeight: '250px',
//     showSelectAll: true
// });

</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<style>
    .sol-inner-container {
       position: absolute;
       width: 100%;
       top: 0px;
    }
    .sol-container{
       position: relative;
    }  
    .sol-current-selection{
       top:35px;
       position: relative;
       z-index: 0;
       padding-bottom: 20px;
    }
</style>
@endsection