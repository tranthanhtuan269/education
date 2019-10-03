@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="{{ url('/') }}/backend/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap-multiselect.css" type="text/css"/>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Các khóa học được yêu cầu sửa</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="course-table">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Tên khóa học</th>
                            <th scope="col">Ảnh</th>
                            <th csope="col">Danh mục</th>
                            <th scope="col">Giá gốc</th>
                            <th csope="col">Giá giảm</th>
                            <th scope="col">Giảng viên</th>
                            <th scope="col">Ngày gửi</th>
                            <th scope="col">Đồng ý</th>
                            <th scope="col">Xóa<br>yêu cầu</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<section>
</section>
<script type="text/javascript">
    var dataTable           = null;

    $(document).ready(function(){

        var dataObject = [
            { 
                data: "name",
                class: "name-field"
            },
            { 
                data: "image",
                class: "text-center",
                render: function(data, type, row) {
                    var html = baseURL +'/frontend/images/' + row.image;
                    return '<img src="'+ html +'" style="width:90px;height:40px;">'
                },
                orderable: false
            },
            { 
                data: "category",
            },
            {
                data:"real_price",
                class: "real_price-field"
            },
            {
                data: "price"
            },
            {
                data: "author"
            },
            {
                data: "created_at"
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                        html += '<a class="btn btn-success button-action" data-course-id="'+row.course_id+'" data-id="'+data+'" data-accept = "1"> <i class="fa fa-check fa-fw"></i></a>';
                    return html;
                },
                orderable: false
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                        html += '<a class="btn btn-danger button-action" data-course-id="'+row.course_id+'" data-id="'+data+'" data-accept = "0"> <i class="fa fa fa-trash fa-fw"></i></a>';
                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#course-table').DataTable( {
                        serverSide: true,
                        aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax: "{{ url('/') }}/admincp/courses/get-edit-course-ajax",
                        columns: dataObject,
                        bLengthChange: true,
                        pageLength: 10,
                        order: [[ 5, "desc" ]],
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
                            sEmptyTable: "Chưa có khóa học được yêu cầu sửa",
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",

                            },
                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                        },
                    });
        
        $('#course-table').css('width', '100%')

        function addEventListener(){

            $('.button-action').off('click')
            $('.button-action').click(function(){
                var id      = $(this).attr('data-id')
                var course_id = $(this).attr('data-course-id')
                var accept  = $(this).attr('data-accept')

                var message = "Bạn có chắc chắn chấp nhận yêu cầu sửa khóa học?";
                if( accept ){
                    message = "Bạn có chắc chắn đồng ý yêu cầu sửa khóa học?";
                }
                Swal.fire({
                    type: "warning",
                    text: message,
                    showCancelButton: true,
                }).then( (result) =>{
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/courses/accept-edit-course",
                            data: {
                                id : id,
                                course_id : course_id,
                                accept : accept
                            },
                            method: "POST",
                            dataType:'json',
                            success: function (response) {
                                if(response.status == 200){
                                    dataTable.ajax.reload(); 
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                }
                                if(response.status == 403){
                                    dataTable.ajax.reload(); 
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
            })
        }
    })
</script>

@endsection