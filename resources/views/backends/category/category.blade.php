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
    <h1 class="text-center font-weight-600">Danh mục</h1>
    <div class="add-item text-center">
            <!-- <button id="create_user" data-toggle="modal" data-target="#add_user_modal" class="btn btn-success add-category" title="Thêm danh mục"><i class="fa fa-plus fa-fw"></i> Danh mục</button> -->
            <a class="btn btn-primary mr-2 add-category" data-id="' + data + '" data-title="' + row.title + '" data-content="' + row.content + '" title="Sửa"> <i class="fa fa-plus fa-fw"></i><b>THÊM DANH MỤC</b></a>
        </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="category-table">
                    <thead class="thead-custom">
                        <tr>
                            <th>ID</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Danh mục cha</th>
                            <th scope="col">Nổi bật</th>
                            <th scope="col">Image</th>
                            <th scope="col">Sửa</th>
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
                    <form autocomplete="off">
                        {{-- <div class="form-group">
                            <label>Tên Danh mục: (Tối đa 25 ký tự)</label>
                            <input type="text" class="form-control" name="name" id="categoryName_id">
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Tên Danh mục: (Tối đa 25 ký tự)', '', 'name', 'id="categoryName_id"') !!}
                        <div class="form-group">
                            <label>Danh mục cha:</label>
                            <!-- <input type="text" class="form-control" name="categoryParent"> -->
                            <select class="form-control" name="parent_id" id="categoryParent_id">
                                <option value="0">--</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>Mô tả:</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="2" cols="50" name="description"></textarea>
                            </div>
                        </div> --}}
                        {!! \App\Helper\Helper::insertTextareaForm('Mô tả:', 2, 50, 'description', '', 'description') !!}
                        <div class="form-group">
                            <label>Nổi bật:</label><br>
                            <label class="radio-inline"><input type="radio" name="featured" value="0">Không</label>
                            <label class="radio-inline"><input type="radio" name="featured" value="1">Có</label>
                        </div>
                        {{-- <div class="form-group">
                            <label>Icon:</label>
                            <input type="text" class="form-control" name="icon" id="categoryIcon_id">
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'icon', 'Icon:', '', 'icon', 'id="categoryIcon_id"') !!}
                        <div class="form-group form-html">
                            <label>Ảnh đại diện Danh mục: (Kích thước chuẩn: 440x190)</label>
                            <input type="file" class="form-control" name="image" id="files" onchange="preview_image(event)" style="display:none"><br>
                            <div class="text-center">
                                <div class="btn btn-primary select-image-btn" id="btnViewUpload"><i class="fa fa-picture-o fa-fw"></i> Tải lên ảnh Danh mục</div>
                            </div><br>
                            <div class="text-center">
                                <img id="preview_category_img" style="width:300px;height:auto" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-128.png"/>
                            </div>
                            <div class="form-html-validate image"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addCategory"><b>Xác nhận</b></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelAdd"><b>Hủy bỏ</b></button>
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
                        {{-- <div class="form-group">
                            <label>Tên Danh mục: (Tối đa 25 ký tự)</label>
                            <input type="text" class="form-control" name="name" id="editName" value="">
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Tên Danh mục: (Tối đa 25 ký tự)', '', 'name', 'id="editName"') !!}
                        <div class="form-group">
                            <label>Danh mục cha:</label>
                            <!-- <input type="text" class="form-control" name="categoryParent"> -->
                        <select class="form-control" name="parent_id" id="editParentId">
                                @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>Mô tả:</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="2" cols="50" name="descriptionEdit">{{$cat->description}}</textarea>
                            </div>
                        </div> --}}
                        {!! \App\Helper\Helper::insertTextareaForm('Mô tả:', 2, 50, 'descriptionEdit', $cat->description, 'description') !!}
                        <div class="form-group">
                            <label>Nổi bật:</label><br>
                            <label class="radio-inline"><input type="radio" name="editFeatured" value="0" checked>Không</label>
                            <label class="radio-inline"><input type="radio" name="editFeatured" value="1">Có</label>
                        </div>
                        {{-- <div class="form-group">
                            <label class="label-icon-category">Icon:</label>
                            <input type="text" class="form-control" name="icon" id="editIcon">
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'icon', 'Icon:', '', 'icon', 'id="editIcon"') !!}
                        <div class="form-group form-html">
                            <label style="display:block">Ảnh đại diện Danh mục: (Kích thước chuẩn: 440x190)</label>
                            <input type="file" class="form-control" name="image" id="editImage" onchange="preview_edit_image(event)" style="display:none">
                            <div class="text-center">
                                <div class="btn btn-primary select-image-btn" id="btnViewEditUpload"><i class="fa fa-picture-o fa-fw"></i> Tải lên ảnh Danh mục</div>
                            </div>
                            <br>
                            <div class="text-center box-preview-edit">
                                <img id="previewEditCategoryImg" src="" style="width:300px;height:auto"/>
                            </div>
                            <div class="form-html-validate image"></div>
                        </div>
                        {{-- <input type="reset" id="resetEditCategory" style="display:none"> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editCategory"><b>Xác nhận</b></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><b>Hủy bỏ</b></button>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
var dataTable = null;
var userCheckList = [];
var current_page = 0;
var old_search = '';
var errorConnect = "Please check your internet connection and try again.";

$(document).ready(function() {

    $('#btnViewEditUpload').click(function(){
        $('#editImage').click()
    })
    $('#btnViewUpload').click(function(){
        $('#files').click()
    })
    var _URL = window.URL || window.webkitURL;
    $("#editImage").change(function(e) {
        var fileInput = $('#editImage').val();
        var allowedExtensions = /(\.gif|\.png|\.jpeg|\.jpg)$/i;
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onerror = function() {
                Swal.fire({
                    type: 'warning',
                    text: 'Tập tin không hợp lệ.',
                    allowOutsideClick: false,
                })
                $("#editImage").val('') 
                
            };
            img.src = _URL.createObjectURL(file);
        }
        if(allowedExtensions.exec(fileInput) == null){
            Swal.fire({
                type: 'warning',
                text: 'Chỉ hỗ trợ file png, jpg, jpeg',
                allowOutsideClick: false,
            })
            $("#editImage").val('') 
        }
    })
    $("#files").change(function(e) {
        var fileInput = $('#files').val();
        var allowedExtensions = /(\.gif|\.png|\.jpeg|\.jpg)$/i;
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onerror = function() {
                Swal.fire({
                    type: 'warning',
                    text: 'Tập tin không hợp lệ.',
                    allowOutsideClick: false,
                })
                $("#files").val('') 
                
            };
            img.src = _URL.createObjectURL(file);
        }
        if(allowedExtensions.exec(fileInput) == null){
            Swal.fire({
                type: 'warning',
                text: 'Chỉ hỗ trợ file png, jpg, jpeg',
                allowOutsideClick: false,
            })
            $("#files").val('') 
        }
    })
    
    link_image_base64 = '';
    function handleFileSelect(evt) {
        var f = evt.target.files[0]; // FileList object
        if (f.size > 0) {
            var fileType = f["type"];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#files').val('');
                Swal.fire({
                    type: 'warning',
                    html: 'Tập tin không hợp lệ.',
                })
                $('#showAddModal #files').val('')
                $('#showEditModal #editImage').val('')
                // $('.box-preview-edit').css('display', 'none')
                return false;
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
                html: 'Tập tin không hợp lệ.',
            })
        }
    }

    if (window.File && window.FileReader && window.FileList && window.Blob) {
        document.getElementById('files').addEventListener('change', handleFileSelect, false);
    }

    $('#addCategory').click(function(){
        var parent_id = $('#categoryParent_id').val()
        var feature = 0
        if( parent_id != 0 ){
            feature = $('input[name=featured]:checked').val()
        }

        var data    = {
            name             : $('#categoryName_id').val().trim(),
            parent_id        : $('#categoryParent_id').val(),
            featured         : $('input[name=featured]:checked').val(),
            icon             : $('#categoryIcon_id').val().trim(),
            image            : link_image_base64,
            description      : $('textarea[name=description]').val().trim(),
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var request = $.ajax({
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
                    // $('#preview_category_img').attr('src','https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-128.png')
                    $('#showAddModal').modal('hide');
                    Swal.fire({
                        type: 'success',
                        text: "Thêm mới danh mục thành công!"
                    }).then( result => {
                        location.reload()
                        // dataTable.ajax.reload()
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
            }
        });
    });

    // $('#editCategory').click(function(){
    //     var id      = $("input[id=userIdUpdate]").val();
    //     var data    = {
    //         id               : id,
    //         name             : $('#editName').val(),
    //         parent_id        : $('#editParentId').val(),
    //         featured         : $('input[name=editFeatured]').val(),
    //         icon             : $('#editIcon').val(),
    //         // image            : link_image_base64,
    //     };
    //     // alert(1);
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
        
    //     $.ajax({
    //         url: baseURL+"/admincp/categories/editCategory",
    //         data: data,
    //         method: "POST",
    //         dataType:'json',
    //         beforeSend: function(r, a){
    //             $('.alert-errors').addClass('d-none');
    //         },
    //         success: function (response) {
    //             var html_data = '';
    //             if(response.status == 200){
    //                 clearFormCreate();
    //                 $('#showEditModal').modal('toggle');
    //                 dataTable.ajax.reload();
    //                 Swal.fire({
    //                     type: 'success',
    //                     text: response.Message
    //                 })
                        
    //             } else {
    //                 Swal.fire({
    //                     type: 'warning',
    //                     text: response.Message
    //                 })
    //             }
    //         },
    //         error: function (error) {
    //             var obj_errors = error.responseJSON.errors;
    //             var txt_errors = '';
    //             for (k of Object.keys(obj_errors)) {
    //                 txt_errors += obj_errors[k][0] + '</br>';
    //             }
    //             Swal.fire({
    //                 type: 'warning',
    //                 html: txt_errors,
    //             })
    //         }
    //     });
    // });

    function clearFormCreate(){
        $('input[name=name]').val('');
        $('select[name=parent_id]').val('0');
        $('input:radio[name="featured"]').filter('[value="0"]').attr('checked', true);
        $('input[name=icon]').val('');
        $('input[type=file]').val('');
        $('select option[value="0"]').attr("selected",true);
        $('#preview_category_img').attr("src","https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-128.png");
        $('textarea[name=description]').val('');
        $('textarea[name=descriptionEdit]').val('');
    }

    $('#edit_user_modal').on('shown.bs.modal', function() {
        // var id      = $('#userID_upd').val();
    })

    var dataObject = [
        {
            data: "action",
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
            orderable: false
        },
        {
            data: "image",
            class: "text-center",
            render: function(data, type, row) {
                var html = baseURL +'/frontend/images/' + row.image;
                return '<img src="'+ html +'" style="width:90px;height:40px;">'
                // alert(row.image)
            },
            orderable: false
        },
        {
            data: "action",
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="edit-category" data-id="' + data + '"  title="Sửa"> <i class="fa fa-pencil fa-fw"></i>Sửa</a>';
                return html;
            },
            orderable: false
        },
        {
            data: "action",
            class: "action-field",
            render: function(data, type, row) {
                var html = '';
                html += '<a class="delete-category" data-id="' + data + '" title="Xóa"><i class="fa fa-trash fa-fw"></i>Xóa</a>';

                return html;
            },
            orderable: false
        },
    ];

    dataTable = $('#category-table').DataTable({
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
            url: baseURL + "/admincp/categories/getCategoryAjax",
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
            sEmptyTable: "Chưa có danh mục",
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
            $(row).attr('data-description', data['description']);
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
        $('.edit-category').off()
        $('.edit-category').click(function() {
            $('#showEditModal').modal('show');
            clearFormCreate();
            var curr_name       = $(this).parent().parent().attr('data-name');
            var curr_parent_id  = $(this).parent().parent().attr('data-parent-id');
            var curr_featured   = $(this).parent().parent().attr('data-featured');
            var curr_icon       = $(this).parent().parent().attr('data-icon');
            var curr_image      = $(this).parent().parent().attr('data-image');
            var id              = $(this).attr('data-id');
            var description     = $(this).parent().parent().attr('data-description');
            $("input[name='name']").val(curr_name);
            if( !curr_parent_id ){
                curr_parent_id = 0
            }
            $("select[id=editParentId]").val(curr_parent_id);
            if( curr_parent_id == 0 ){
                $("select[id=editParentId]").attr('disabled',true)
                $("input[name=editFeatured]").attr('disabled', true)
            }else{
                $("select[id=editParentId]").attr('disabled',false)
                $("input[name=editFeatured]").attr('disabled', false)
            }
            if( curr_featured == 1 ){
                $('input[name=editFeatured][value=0]').removeAttr('checked','checked');
                $('input[name=editFeatured][value=1]').attr('checked','checked');
            }else{
                $('input[name=editFeatured][value=1]').removeAttr('checked','checked');
                $('input[name=editFeatured][value=0]').attr('checked','checked');
            }

            $("input[name='icon']").val(curr_icon);
            $("input[id=userIdUpdate]").val(id);
            $("img[id=previewEditCategoryImg]").attr("src", baseURL +'/frontend/images/' + curr_image);
            $("textarea[name=descriptionEdit]").val(description)
        })

        $('.add-category').off('click')
        $('.add-category').click(function() {
            $('#showAddModal').modal('show');
            clearFormCreate();
        })

        $('.delete-category').off('click')
        $('.delete-category').click(function(e) {
            var id = $(this).attr('data-id');

            Swal.fire({
                type: 'warning',
                text : 'Bạn có chắc chắn muốn xóa?',
                showCancelButton: true,
            }).then( result => {
                if(result.value){
                    $.ajax({
                        method: 'DELETE',
                        url: "{{ url('/') }}/admincp/categories/delete",
                        data: {
                            category_id : id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if(response.status == '200'){
                                Swal.fire({
                                    type: 'success',
                                    text : response.message,
                                }).then( result =>{
                                    location.reload()
                                })
                            }
                            if(response.status == '403'){
                                Swal.fire({
                                    type: 'warning',
                                    text : response.message,
                                })
                            }
                        },
                    })                        
                }
            })
        });

        function checkEmptyTable() {
            if ($('#category-table tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

        $('#editCategory').off()
        $('#editCategory').click(function(){
            // alert(link_image_base64)
            image_base64 = $('#previewEditCategoryImg').attr('src');
            image_base64 = image_base64.replace("data:image/png;base64,", "");
            image_base64 = image_base64.replace("data:image/jpg;base64,", "");
            image_base64 = image_base64.replace("data:image/jpeg;base64,", "");
            image_base64 = image_base64.replace("data:image/gif;base64,", "");
            if(image_base64.indexOf("http") > -1) {
                image_base64 = "";
            }
            var id      = $("input[id=userIdUpdate]").val();

            var data    = {
                id               : id,
                name             : $('#editName').val().trim(),
                parent_id        : Number($('#editParentId').val()),
                featured         : $('input[name="editFeatured"]:checked').val(),
                icon             : $('#editIcon').val().trim(),
                image            : image_base64,
                description      : $('textarea[name=descriptionEdit]').val().trim(),
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request =$.ajax({
                url: baseURL+"/admincp/categories/editCategory/"+id,
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
                        $('#showEditModal').modal('hide');
+                        Swal.fire({
                            type: 'success',
                            text: response.Message
                        }).then( result => {
                            location.reload()
                            // dataTable.ajax.reload()
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
});
</script>

<script type='text/javascript'>
    function preview_image(event){
        var reader = new FileReader();
        // $('input[name=image]').append('<img id="preview_category_img" src="#" max-width="570"/>');
        reader.onload = function()
        {
            var fileInput = $('#files').val();
            var fileSize = document.getElementById('files').files[0].size;
            var allowedExtensions = /(\.gif|\.png|\.jpeg|\.jpg)$/i;
            if (allowedExtensions.exec(fileInput) && fileSize !=0){
                var output = document.getElementById('preview_category_img');
                output.src = reader.result;
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function preview_edit_image(event){
        var reader = new FileReader();
        reader.onload = function(){
            var fileInput = $('#editImage').val();
            var fileSize = document.getElementById('editImage').files[0].size;
            var allowedExtensions = /(\.gif|\.png|\.jpeg|\.jpg)$/i;
            if (allowedExtensions.exec(fileInput) && fileSize !=0){
                var output = document.getElementById('previewEditCategoryImg');
                output.src = reader.result;
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script type="text/javascript">
    $('#cancelAdd').click(function(){
        $('#preview_category_img').attr("src","https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-image-128.png");
    })
</script>

@endsection