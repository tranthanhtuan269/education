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
        <button class="btn btn-success" id="addCouponModal"><b>THÊM COUPON</b></button>
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
                                <h3><b>Nhập mã Coupon</b></h3><br>
                                <label>Mã Coupon</label>
                                <input type="text" class="form-control" id="coupon_code" name="name">
                                <br>
                                <label>Nhập số % của Coupon</label>
                                <input type="number" class="form-control" id="coupon_value" min="1" max="100" name="value">
                                <br>
                                <label>Nhập ngày hết hạn của Coupon</label>
                                <input type="text" class="form-control" id="coupon_expired" pattern="\d{1,2}/\d{1,2}/\d{4}" value="" autocomplete="off" onkeydown="return false">
                                <script>
                                    $(function() {
                                    $( "#coupon_expired" ).datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            yearRange: "2019:2050",
                                            dateFormat: 'yy-mm-dd',
                                            minDate: new Date(),
                                        }	
                                    );
                                    });
                                </script>
                            </div>
                            <div class="col-md-8">
                                <h3><b>Chọn khóa học được hưởng COUPON</b></h3><br>
                                <div>
                                    <p><select id="demonstration" name="course[]" style="width: 570px" multiple="multiple">
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select></p>
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
                                <h3><b>Nhập mã Coupon</b></h3><br>
                                <label>Mã Coupon</label>
                                <input type="text" class="form-control" id="editCouponCode" name="name">
                                <br>
                                <label>Nhập số % của Coupon</label>
                                <input type="number" class="form-control" id="editCouponValue" min="1" max="100" name="value">
                                <br>
                                <label>Nhập ngày hết hạn của Coupon</label>
                                <input type="text" class="form-control" id="editCouponExpired" name="expired" pattern="\d{1,2}/\d{1,2}/\d{4}" value="" autocomplete="off" onkeydown="return false">
                                <script>
                                    $(function() {
                                    $( "#editCouponExpired" ).datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            yearRange: "2019:2050",
                                            dateFormat: 'yy-mm-dd',
                                            minDate: new Date(),
                                        }	
                                    );
                                    });
                                </script>
                            </div>
                            <div class="col-md-8">
                                <h3><b>Chọn khóa học được hưởng Coupon</b></h3><br>
                                <label>Các khóa học đang được hưởng COUPON <span  id="addLabel"></span>:</label>
                                {{-- <div id="edit_course_id_view"></div>--}}
                                <br>
                                <div>
                                    <p><select id="demonstrationEdit" name="course[]" style="width: 570px" multiple="multiple">
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select></p>
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

            if(coupon_code == ''){
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn chưa nhập mã Coupon!'
                })
                return;
            }

            if( coupon_code.length >=15 ){
                Swal.fire({
                    type: 'warning',
                    text: 'Mã COUPON quá dài (Yêu cầu <15 ký tự)!'
                })
                return;
            }

            if(coupon_value == ''){
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn chưa nhập số % được giảm!'
                })
                return;
            }

            if( Number(coupon_value) <= 0 ){
                Swal.fire({
                    type: 'warning',
                    text: '% giá giảm không thể <= 0!'
                })
                return;
            }

            if( Number(coupon_value) > 100 ){
                Swal.fire({
                    type: 'warning',
                    text: '% giá giảm không thể >100!'
                })
                return;
            }

            if( !coupon_expired ){
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn chưa chọn ngày hết hạn COUPON!'
                })
                return;
            }

            for (var i = 0; i < asInputs.length; i++) {
                course_id[i] = $(asInputs[i]).data('sol-item').value;
            }

            if (course_id.length == 0) {
                Swal.fire({
                    type: 'warning',
                    text: 'Chưa có khóa học nào được chọn!'
                })
                return;
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
                        Swal.fire({
                            type: 'warning',
                            text: 'Mã giảm giá đã tồn tại!'
                        })
                        return;
                    }
                },
                error: function (response) {
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
                    ajax: "{{ url('/') }}/admincp/coupon/getCouponAjax",
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
        var coupon_value = $('#coupon_value').val()
        var coupon_expired = $('#coupon_expired').val()

        if(coupon_code == ''){
            Swal.fire({
                type: 'warning',
                text: 'Bạn chưa nhập mã Coupon!'
            })
            return;
        }

        if( coupon_code.length >=15 ){
            Swal.fire({
                type: 'warning',
                text: 'Mã COUPON quá dài (Yêu cầu <15 ký tự)!'
            })
            return;
        }

        if(coupon_value == ''){
            Swal.fire({
                type: 'warning',
                text: 'Bạn chưa nhập số % được giảm!'
            })
            return;
        }

        if( Number(coupon_value) <= 0 ){
            Swal.fire({
                type: 'warning',
                text: '% giá giảm không thể <= 0!'
            })
            return;
        }

        if( Number(coupon_value) > 100 ){
            Swal.fire({
                type: 'warning',
                text: '% giá giảm không thể >100!'
            })
            return;
        }

        if( !coupon_expired ){
            Swal.fire({
                type: 'warning',
                text: 'Bạn chưa chọn ngày hết hạn COUPON!'
            })
            return;
        }

        for (var i = 0; i < asInputs.length; i++) {
            course_id[i] = $(asInputs[i]).data('sol-item').value;
        }

        if (course_id.length == 0) {
            Swal.fire({
                type: 'warning',
                text: 'Chưa có khóa học nào được chọn!'
            })
            return;
        }

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
                    Swal.fire({
                        type: 'warning',
                        text: 'Mã giảm giá đã tồn tại!'
                    })
                }
            },
            error: function (response) {
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
@endsection