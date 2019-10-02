@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Danh mục tiêu biểu</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="featuredCategoryTable">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Danh mục cha</th>
                            <th scope="col">Image</th>
                            <th scope="col">Nổi bật</th>
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
            data: "name",
        },
        {
            data: "parent-name",
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
            data: "action",
            class: "text-center",
            render: function(data, type, row){
                var html = '';
                    if(row['featured'] == 0){
                        html += '<button class="btn btn-secondary btn-featured-category featured" data-id="'+data+'"><i class="fa fa-times fa-fw"></i></button>';
                    }else{
                        html += '<button class="btn btn-success btn-featured-category not-featured" data-id="'+data+'"><i class="fa fa-check fa-fw"></i></button>';
                    }
                return html;
            },
            orderable: false
        }
    ];

    dataTable = $('#featuredCategoryTable').DataTable({
        serverSide: true,
        aaSorting: [],
        stateSave: true,
        ajax: baseURL + "/admincp/featured-category/get-featured-category-ajax",
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
    });

    function addEventListener(){
        $('.btn-featured-category').off('click')
        $('.btn-featured-category').click(function(){
            var id      = $(this).attr('data-id');
            var message = "Xác nhận chọn danh mục nổi bật.";
            var featured  = 0
            if($(this).hasClass('not-featured')){
                featured  = 1;
                message = "Xác nhận bỏ chọn danh mục nổi bật";
            }
    
            Swal.fire({
                type: 'warning',
                text: message,
                showCancelButton: true,
            }).then(function (result) {
                if(result.value){
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseURL+"/admincp/featured-category/set-feature-category-ajax",
                        data: {
                            category_id : id,
                            featured : 1- featured
                        },
                        method: "POST",
                        dataType:'json',
                        success: function (response) {
                            if(response.status == 200){
                                if (featured == 0){
                                    Swal.fire({
                                        type: 'success',
                                        text: "Đã đổi danh mục thành nổi bật."
                                    }).then( result => {
                                    location.reload()
                                    // dataTable.ajax.reload()
                                    })
                                }
                                else {
                                    Swal.fire({
                                        type: 'success',
                                        text:"Đã hủy danh mục nổi bật."
                                    }).then( result => {
                                    location.reload()
                                    // dataTable.ajax.reload()
                                    })
                                }
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: response.message
                                })
                            }
                        },
                        error: function (data) {
                            if(data.status == 404){
                            window.location.replace(baseURL);
                            }else{
                                Swal.fire({
                                    type: 'warning',
                                    text: 'Lỗi! Danh mục không tồn tại.'
                                })
                            }
                        }
                    });
                }
            });
        });
    }

});
</script>
@endsection