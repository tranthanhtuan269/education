@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Phản hồi khóa học</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="commentCourseAll">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Học viên</th>
                            <th scope="col">Phản hồi</th>
                            <th scope="col">Khóa học</th>
                            <th scope="col">Ngày đăng</th>
                            <th scope="col">Chi tiết</th>
                            <th scope="col">Xóa</th>
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
            data: "user_name",
        },
        {
            data: "content",
        },
        {
            data: "course_name",
            render: function(data, type, row){
                if(type == "display"){
                    var html = '';
                    html += '<a class="red-row" href="/course/'+row.course_slug+'" target="_blank"><b>'+data+'</b></a>';
                    return html;
                }
                return data;
            },
        },
        {
            data: "created_at",
        },
        {
            data: "action",
            class: "text-center",
            render: function(data, type, row){
                var html = '';
                html += '<button class="btn btn-secondary" data-id="'+data+'"><i class="fa fa-eye fa-fw"></i></button>';
                return html;
            },
            orderable: false
        },
        {
            data: "action",
            class: "text-center",
            render: function(data, type, row){
                var html = '';
                html += '<button class="btn btn-secondary" data-id="'+data+'"><i class="fa fa-trash fa-fw"></i></button>';
                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#commentCourseAll').DataTable({
        serverSide: false,
        aaSorting: [],
        stateSave: true,
        ajax: baseURL + "/admincp/comment/get-comment-course-ajax",
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
            oPaginate: {
                sPrevious: "Trang trước",
                sNext: "Trang sau",

            },
        },
        fnDrawCallback: function( oSettings ) {
            addEventListener();
        },
        createdRow: function( row, data, dataIndex){
            if(data['status'] == 1){
                $(row).addClass('blue-row');
            }else{
                $(row).addClass('red-row');
            }
            
            $(row).attr('data-description', data['description']);
            // $(row).attr('data-video', data['video_intro']);
        }
    });
    $('#commentCourseAll').css('width', '100%');

    function addEventListener(){
        $('.btn-featured-category').off('click')
        $('.btn-featured-category').click(function(){
            
        });
    }

});
</script>
@endsection