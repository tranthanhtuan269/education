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
    <h1 class="text-center font-weight-600">Danh mục</h1>
    <div class="add-item text-center">
            <!-- <button id="create_user" data-toggle="modal" data-target="#add_user_modal" class="btn btn-success add-category" title="Thêm danh mục"><i class="fa fa-plus fa-fw"></i> Danh mục</button> -->
            <a class="btn btn-success mr-2 add-category" data-id="' + data + '" data-title="' + row.title + '" data-content="' + row.content + '" title="Sửa"> <i class="fa fa-plus fa-fw"></i> Danh mục</a>
        </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="category-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Danh mục cha</th>
                            <th scope="col">Nổi bật</th>
                            <th scope="col">Image</th>
                            <th scope="col">Sửa, Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <!-- @if (Helper::checkPermissions('users.email', $list_roles))  -->
                    <!-- <p class="action-selected-rows"> -->
                        <!-- <span >Hành động trên các hàng đã chọn:</span> -->
                        <!-- <span class="btn btn-info ml-2" id="deleteAllApplied">Xóa</span> -->
                        <!-- <span class="btn btn-info ml-2" id="inacceptAllApplied">Hủy</span> -->
                    <!-- </p>   -->
                <!-- @endif -->
            </div>
        </div>
    </div>
</section>
<section>
    <div class="modal fade" id="showAddModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Thêm Danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Tên Danh mục</label>
                            <input type="text" class="form-control" name="name" id="categoryName_id">
                        </div>
                        <div class="form-group">
                            <label>Danh mục cha</label>
                            <!-- <input type="text" class="form-control" name="categoryParent"> -->
                            <select class="form-control" name="parent_id" id="categoryParent_id">
                                <option value="0">--</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nổi bật</label><br>
                            <label class="radio-inline"><input type="radio" name="featured" checked value="1">Có</label>
                            <label class="radio-inline"><input type="radio" name="featured" value="0">Không</label>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input type="text" class="form-control" name="icon" id="categoryIcon_id">
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <input type="file" class="form-control" name="image" id="files" onchange="preview_image(event)"><br>
                            <img id="preview_category_img" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-128.png" style="max-width:570px"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addCategory">Thêm mới</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showEditModal" tabindex="-1">
    <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600">Sửa Danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <input type="hidden" id="userIdUpdate" value="">
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Tên Danh mục</label>
                            <input type="text" class="form-control" name="name" id="editName" value="">
                        </div>
                        <div class="form-group">
                            <label>Danh mục cha</label>
                            <!-- <input type="text" class="form-control" name="categoryParent"> -->
                            <select class="form-control" name="parent_id" id="editParentId">
                                <option value="0">--</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nổi bật</label><br>
                            <label class="radio-inline"><input type="radio" name="editFeatured" value="1">Có</label>
                            <label class="radio-inline"><input type="radio" name="editFeatured" value="0">Không</label>
                        </div>
                        <div class="form-group">
                            <label class="label-icon-category">Icon:</label>
                            <input type="text" class="form-control" name="icon" id="editIcon">
                        </div>
                        <div class="form-group">
                            <label style="display:block">Ảnh đại diện</label>
                            {{-- <input type="file" class="form-control" name="image" id="editImage"><br> --}}
                            <img id="editCategoryImg" src="" style="max-width:570px"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editCategory">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
var dataTable = null;
var userCheckList = [];
var curr_user_name = '';
var curr_user_email = '';
var current_page = 0;
var old_search = '';
var errorConnect = "Please check your internet connection and try again.";

$(document).ready(function() {
    link_image_base64 = '';
    function handleFileSelect(evt) {
        var f = evt.target.files[0]; // FileList object
        if (f.size > 0) {
            var fileType = f["type"];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                Swal.fire({
                    type: 'warning',
                    html: 'Ảnh không hợp lệ!',
                })
            } else {
                var reader = new FileReader();
                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    return function(e) {
                    var binaryData = e.target.result;
                    //Converting Binary Data to base 64
                    link_image_base64 = window.btoa(binaryData);
                    };
                })(f);
                // Read in the image file as a data URL.
                reader.readAsBinaryString(f);
            }
        } else {
            Swal.fire({
                type: 'warning',
                html: 'Ảnh không hợp lệ!',
            })
        }
    }

    if (window.File && window.FileReader && window.FileList && window.Blob) {
        document.getElementById('files').addEventListener('change', handleFileSelect, false);
    }

    $('#addCategory').click(function(){
        if (link_image_base64 == '') {
            Swal.fire({
                type: 'warning',
                html: 'Xin vui lòng chọn ảnh!',
            })
            return;
        } 
        var data    = {
            name             : $('#categoryName_id').val(),
            parent_id        : $('#categoryParent_id').val(),
            featured         : $('input[name=featured]').val(),
            icon             : $('#categoryIcon_id').val(),
            image            : link_image_base64,
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url: baseURL+"/admincp/categories/addCategory",
            data: data,
            method: "POST",
            dataType:'json',
            beforeSend: function(r, a){
                $('.alert-errors').addClass('d-none');
            },
            success: function (response) {
                var html_data = '';
                if(response.status == 200){
                    clearFormCreate();
                    $('#showAddModal').modal('toggle');
                    dataTable.ajax.reload();
                    Swal.fire({
                        type: 'success',
                        text: response.Message
                    })
                        
                } else {
                    Swal.fire({
                        type: 'warning',
                        text: response.Message
                    })
                }
            },
            error: function (error) {
                var obj_errors = error.responseJSON.errors;
                // console.log(obj_errors)
                var txt_errors = '';
                for (k of Object.keys(obj_errors)) {
                    txt_errors += obj_errors[k][0] + '</br>';
                }
                Swal.fire({
                    type: 'warning',
                    html: txt_errors,
                })
            }
        });
    });

    $('#editCategory').click(function(){
        var id      = $("input[id=userIdUpdate]").val();
        var data    = {
            id               : id,
            name             : $('#editName').val(),
            parent_id        : $('#editParentId').val(),
            featured         : $('input[name=editFeatured]').val(),
            icon             : $('#editIcon').val(),
            // image            : link_image_base64,
        };
        // alert(1);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url: baseURL+"/admincp/categories/editCategory",
            data: data,
            method: "POST",
            dataType:'json',
            beforeSend: function(r, a){
                $('.alert-errors').addClass('d-none');
            },
            success: function (response) {
                var html_data = '';
                if(response.status == 200){
                    clearFormCreate();
                    $('#showEditModal').modal('toggle');
                    dataTable.ajax.reload();
                    Swal.fire({
                        type: 'success',
                        text: response.Message
                    })
                        
                } else {
                    Swal.fire({
                        type: 'warning',
                        text: response.Message
                    })
                }
            },
            error: function (error) {
                var obj_errors = error.responseJSON.errors;
                // console.log(obj_errors)
                var txt_errors = '';
                for (k of Object.keys(obj_errors)) {
                    txt_errors += obj_errors[k][0] + '</br>';
                }
                Swal.fire({
                    type: 'warning',
                    html: txt_errors,
                })
            }
        });
    });

    function clearFormCreate(){
        $('input[name=name]').val('');
        $('select[name=parent_id]').val('0');
        $('input:radio[name="featured"]').filter('[value="1"]').attr('checked', true);
        $('input[name=icon]').val('');
        $('input[type=file]').val('');
        $('select option[value="0"]').attr("selected",true);
        $('#preview_category_img').src = "";
    }

    window.onbeforeunload = function() {
        if ($('#edit_user_modal').hasClass('show') && (
                $('#userName_upd').val() != curr_user_name ||
                $('#userEmail_upd').val() != curr_user_email ||
                $('#userPassword_upd').val() != 'not_change' ||
                $('#passConfirm_upd').val() != 'not_change')) {
            return "Bye now!";
        }
    };

    $('#edit_user_modal').on('shown.bs.modal', function() {
        // var id      = $('#userID_upd').val();
    })

    var dataObject = [{
            data: "rows",
            class: "rows-item",
            render: function(data, type, row) {
                return '<input type="checkbox" name="selectCol" class="check-category" value="' + data + '" data-column="' + data + '">';
            },
            orderable: false
        },
        {
            data: "name",
            class: "name-field"
        },
        {
            data: "parent-name",
        },
        {
            data: "featured",
            class: "text-center",
        },
        {
            data: "image",
            class: "text-center",
            render: function(data, type, row) {
                var html = baseURL +'/frontend/images/' + row.image;
                return '<img src="'+ html +'" style="width:75px;height:40px;">'
                // alert(row.image)
            },
            orderable: false
        },
        {
            data: "action",
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="edit-category" data-id="' + data + '" data-title="' + row.title + '" data-content="' + row.content + '" title="Sửa"> <i class="fa fa-pencil fa-fw"></i>Edit</a>';
                html += '<br>';
                // html += '&nbsp';
                html += '<a class="delete-category" data-id="' + data + '" title="Xóa"><i class="fa fa-trash fa-fw" aria-hidden="true"></i>Del</a>';

                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#category-table').DataTable({
        serverSide: false,
        aaSorting: [],
        stateSave: true,
        ajax: baseURL + "/admincp/categories/getCategoryAjax",
        columns: dataObject,
        bLengthChange: true,
        pageLength: 10,
        // order: [[ 4, "desc" ]],
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
            oPaginate: {
                sPrevious: "Trang trước",
                sNext: "Trang sau",

            },
        },
        fnServerParams: function(aoData) {

        },
        fnDrawCallback: function(oSettings) {
            addEventListener();
            checkCheckboxChecked();
        },
        createdRow: function( row, data, dataIndex){
            $(row).attr('data-name', data['name']);
            $(row).attr('data-parent-id', data['parent-id']);
            $(row).attr('data-featured', data['featured']);
            $(row).attr('data-icon', data['icon']);
            $(row).attr('data-image', data['image']);
        }
    });

    $('#category-table').css('width', '100%');

    //select all checkboxes
    $("#select-all-btn").change(function() {
        $('.page table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
        // save localstore
        setCheckboxChecked();
    });

    $('body').on('click', '.page table tbody input[type="checkbox"]', function() {
        if (false == $(this).prop("checked")) {
            $("#select-all-btn").prop('checked', false);
        }
        if ($('.page table tbody input[type="checkbox"]:checked').length == $('.page table tbody input[type="checkbox"]').length) {
            $("#select-all-btn").prop('checked', true);
        }

        // save localstore
        setCheckboxChecked();
    });

    function setCheckboxChecked() {
        userCheckList = [];
        $.each($('.check-category'), function(index, value) {
            if ($(this).prop('checked')) {
                userCheckList.push($(this).val());
            }
        });
    }

    function checkCheckboxChecked() {
        var count_row = 0;
        var listUser = $('.check-category');
        if (listUser.length > 0) {
            $.each(listUser, function(index, value) {
                if (containsObject($(this).val(), userCheckList)) {
                    $(this).prop('checked', 'true');
                    count_row++;
                }
            });

            if (count_row == listUser.length) {
                $('#select-all-btn').prop('checked', true);
            } else {
                $('#select-all-btn').prop('checked', false);
            }
        } else {
            $('#select-all-btn').prop('checked', false);
        }
    }

    function containsObject(obj, list) {
        var i;
        for (i = 0; i < list.length; i++) {
            if (list[i] === obj) {
                return true;
            }
        }
        return false;
    }

    function addEventListener() {
        $('.edit-category').off('click')
        $('.edit-category').click(function() {
            $('#showEditModal').modal('show');
            var curr_name       = $(this).parent().parent().attr('data-name');
            var curr_parent_id  = $(this).parent().parent().attr('data-parent-id');
            var curr_featured   = $(this).parent().parent().attr('data-featured');
            var curr_icon       = $(this).parent().parent().attr('data-icon');
            var curr_image      = $(this).parent().parent().attr('data-image');
            var id              = $(this).attr('data-id');

            $("input[name='name']").val(curr_name);
            $("select[name='parent_id']").val(curr_parent_id);
            $("input[name='editFeatured'][value='"+curr_featured+"']").prop('checked', true);
            $("input[name='icon']").val(curr_icon);
            $("input[id=userIdUpdate]").val(id);
            $("img[id=editCategoryImg]").attr("src", baseURL +'/frontend/images/' + curr_image);
        })

        $('.add-category').off('click')
        $('.add-category').click(function() {
            $('#showAddModal').modal('show');
            clearFormCreate();
        })

        $('.delete-category').off('click')
        $('.delete-category').click(function(e) {
            var _self = $(this);
            var id = $(this).attr('data-id');
            var row = $(e.currentTarget).closest("tr");
            $.ajsrConfirm({
                message: "Xóa danh mục sẽ ảnh hưởng tới khóa học và các danh mục con. Bạn có chắc chắn muốn xóa?",
                okButton: "Đồng ý",
                onConfirm: function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: baseURL + "/admincp/categories/delete",
                        data: {
                            category_id: id
                        },
                        method: "POST",
                        dataType: 'json',
                        beforeSend: function(r, a) {
                            current_page = dataTable.page.info().page;
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({
                                    type: 'success',
                                    text: response.message
                                })
                                dataTable.row(row).remove().draw(true);
                                dataTable.page(checkEmptyTable()).draw(false);
                            } else {
                                Swal.fire({
                                    type: 'warning',
                                    text: response.message
                                })
                            }
                        },
                        error: function(data) {
                            if (data.status == 401) {
                                window.location.replace(baseURL);
                            } else {
                                $().toastmessage('showErrorToast', errorConnect);
                            }
                        }
                    });
                },
                nineCorners: false,
            });
        });

        function checkEmptyTable() {
            if ($('#category-table tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    }
});
</script>

<script type='text/javascript'>
function preview_image(event) 
    {
        var reader = new FileReader();
        // $('input[name=image]').append('<img id="preview_category_img" src="#" max-width="570"/>');
        reader.onload = function()
        {
            var output = document.getElementById('preview_category_img');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection