@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Phản hồi bài giảng</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="commentVideoAll">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Học viên</th>
                            <th scope="col">Phản hồi</th>
                            <th scope="col">Bài giảng</th>
                            <th scope="col">Ngày đăng</th>
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
<style>
    .video-name{
        width: 250px;
    }
    .created-at{
        width: 45px;
    }
</style>
<script type="text/javascript">
var dataTable = null;

$(document).ready(function() {
    
    var dataObject = [
        {
            data: "user_name",
        },
        {
            data: "content",
            render: function(data, type, row){
                return $("<div/>").html(data).text();
            },
            orderable: false
        },
        {
            data: "video_name",
            class: "video-name"
            // render: function(data, type, row){
            //     if(type == "display"){
            //         var html = '';
            //         html += '<a class="" href="/learning-page/'+row.course_id+'/lecture/'+row.action+'" target="_blank"><b>'+data+'</b></a>';
            //         return html;
            //     }
            //     return data;
            // },
        },
        {
            data: "created_at",
            class: "created-at"
        },
        {
            data: "action",
            class: "text-center",
            render: function(data, type, row){
                var html = '';
                html += '<a class="btn btn-danger delete-comment"" data-id="'+data+'"><i class="fa fa-trash fa-fw"></i></a>';
                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#commentVideoAll').DataTable({
        serverSide: false,
        search: {
            smart: false
        },
        aaSorting: [],
        stateSave: true,
        ajax:{
            url: baseURL + "/admincp/comment/get-comment-video-ajax",
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
    $('#commentVideoAll').css('width', '100%');

    function addEventListener(){

        $('.delete-comment').off('click')
        $('.delete-comment').click(function(){
            var id      = $(this).attr('data-id');

            Swal.fire({
                type: 'warning',
                text: 'Bạn có chắc chắn muốn xóa vĩnh viễn bình luận này?',
                showCancelButton: true,
            }).then((result)=>{
                if(result.value){
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseURL+"/admincp/comment/delete-comment-video",
                        data: {
                            id : id,
                        },
                        method: "DELETE",
                        dataType:'json',
                        success: function (response) {
                            if(response.status == 200){
                                // dataTable.ajax.reload();
                                Swal.fire({
                                    type: 'success',
                                    text: response.message
                                }).then(result =>{
                                    location.reload()
                                })
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: response.message
                                })
                            }
                            
                        },
                        error: function (data) {
                            if(data.status == 401){
                            window.location.replace(baseURL);
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: errorConnect
                                })
                            }
                        }
                    });
                }
            })
        });
    }

});
</script>
@endsection