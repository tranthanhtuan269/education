@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Yêu cầu duyệt khóa học</h1>
    <div class="comment">
        <div class="stop-sell"><button class="btn btn-success"></button> Khoá học đang được bán</div>
        <div class="stop-sell"><button class="btn btn-warning"></button> Khóa học đã ngừng bán </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="acceptedCourseTable">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Tên khóa học</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Giảng viên</th>
                            <th scope="col">Tóm tắt</th>
                            <th csope="col">Giá gốc</th>
                            <th csope="col">Giá giảm</th>
                            <th scope="col">Cập nhật</th>
                            <th scope="col">Ngừng bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<style>
    .comment{
        margin-left: 40%;
    }
    .name-field{
        width: 180px;
    }
    .short-description-field{
        /* width: 300px; */
    }
    .price-field{
        width: 60px;
    }
    .updated-field{
        width: 45px;
    }
    .action-field{
        width: 40px;
    }
</style>
<script type="text/javascript">
    var dataTable           = null;
    var userCheckList       = [];
    var curr_user_name      = '';
    var curr_user_email     = '';
    var current_page        = 0;
    var old_search          = '';
    var errorConnect        = "Please check your internet connection and try again.";

    $(document).ready(function(){
        window.onbeforeunload = function() {
            if($('#edit_user_modal').hasClass('show') && ( 
                $('#userName_upd').val() != curr_user_name ||
                $('#userEmail_upd').val() != curr_user_email ||
                $('#userPassword_upd').val() != 'not_change' || 
                $('#passConfirm_upd').val() != 'not_change' )
                ){
                return "Bye now!";
            }
        };

        var dataObject = [
            { 
                data: "name",
                class: "name-field",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '';
                        html += '<a class="color-white" href="/course/'+row.action+'/'+row.slug+'" target="_blank"><b>'+data+'</b></a>';
                        return html;
                    }
                    return data;
                }
            },
            { 
                data: "category",
                class: "category-field"
            },
            { 
                data: "teacher",
                class: "category-field"
            },
            { 
                data: "short_description",
                class: "short-description-field"
            },
            {
                data:"real_price",
                class: "price-field",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '';
                        html += '<div style="float: right"><b>'
                            html += numberFormat(data, 0, '.', '.') + ' đ';
                        html += '</b></div>'
                        return html;
                    }
                    return data;
                },
                orderable: false
            },
            {
                data:"price",
                class: "price-field",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '';
                        html += '<div style="float: right"><b>'
                            html += numberFormat(data, 0, '.', '.') + ' đ';
                        html += '</b></div>'
                        return html;
                    }
                    return data;
                },
                orderable: false
            },
            {
                data: "updated_at",
                class: "updated-field"
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                    @if (Helper::checkPermissions('courses.accept-course', $list_roles))
                    if ( row.status == 1 ){
                        html += '<a class="color-white stop-selling-course" data-id="'+data+'" data-status="1" title="Ngừng bán khóa học"> <i class="fa fa-times fa-fw"></i></a>';
                    }
                    if ( row.status == -1 ){
                        html += '<a class="color-white stop-selling-course" data-id="'+data+'" data-status="-1" title="Tiếp tục bán khóa học"> <i class="fa fa-check fa-fw"></i></a>';
                    }
                    @endif
                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#acceptedCourseTable').DataTable( {
                        serverSide: false,
                        aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax:{
                            url: "{{ url('/') }}/admincp/courses/get-accepted-courses-ajax",
                            beforeSend: function() {
                                $(".ajax_waiting").addClass("loading");
                            }
                        }, 
                        columns: dataObject,
                        bLengthChange: true,
                        pageLength: 10,
                        order: [[ 6, "desc" ]],
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
                            sEmptyTable: "Chưa có khóa học",
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",

                            },
                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                        },
                        createdRow: function( row, data, dataIndex){
                            if ( data.status == 1 ){
                                $(row).addClass('btn-success');
                            }else{
                                $(row).addClass('btn-warning');                                
                            }
                        }
                    });
        
        $('#acceptedCourseTable').css('width', '100%');

        function addEventListener(){

            $('.stop-selling-course').off('click')
            $('.stop-selling-course').click(function(){
                var id      = $(this).attr('data-id')
                var status  = $(this).attr('data-status')
                if ( status == 1 ){
                    var message = 'Bạn có chắc chắn muốn ngừng bán khóa học này?'
                }else if ( status == -1 ){
                    var message = 'Bạn có chắc chắn muốn tiếp tục bán khóa học này?'
                }else{
                    return
                }
                Swal.fire({
                    type: 'warning',
                    text: message,
                    showCancelButton: true,
               }).then(result => {
                    if(result.value){
                    $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/courses/stop-selling-course",
                            data: {
                                course_id : id,
                                status : status
                            },
                            method: "PUT",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    dataTable.ajax.reload()
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                }else{
                                    Swal.fire({
                                        type: 'warning',
                                        html: response.message
                                    })
                                }
                            },
                            error: function (data) {
                                if(data.status == 401){
                                window.location.replace(baseURL);
                                }else{
                                $().toastmessage('showErrorToast', errorConnect);
                                }
                            }
                        });
                   }
               })
            });
        }

        function checkEmptyTable(){
            if ($('#acceptedCourseTable tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    });
</script>

@endsection