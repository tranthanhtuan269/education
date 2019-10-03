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
    <h1 class="text-center font-weight-600">Danh sách khóa học</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="course-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên khóa học</th>
                            <th scope="col">Tóm tắt</th>
                            <th scope="col">Thời lượng</th>
                            <th csope="col">Giá</th>
                            <th scope="col">Cập nhật</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                @if (Helper::checkPermissions('users.email', $list_roles)) 
                    <p class="action-selected-rows">
                        <span >Hành động trên các hàng đã chọn:</span>
                        {{-- <span class="btn btn-info ml-2" id="deleteAllApplied">Xóa</span> --}}
                        <span class="btn btn-info ml-2" id="acceptAllApplied">Duyệt</span>
                        <span class="btn btn-info ml-2" id="inacceptAllApplied">Hủy</span>
                    </p>  
                @endif
            </div>
        </div>
    </div>
</section>
<section>
    <div class="modal fade" id="showDescriptionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h3>Description</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12" id="cv">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"  id="close">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="showVideoIntroModal" tabindex="-1">
        <div class="modal-content" >
            <div class="modal-header">
                <h3>Video Intro</h3>
            </div>
            <div class="modal-body">
                <div class="form-group row text-center">
                    <iframe id="video-intro" src="" frameborder="0" width="545" height="280" allowscriptaccess="always" allowfullscreen="true"></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-11">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</section>
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

        $('#edit_user_modal').on('shown.bs.modal', function () {
            // var id      = $('#userID_upd').val();
        })

        var dataObject = [
            { 
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-course" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
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
                data: "short_description",
                class: "short_description-field"
            },
            { 
                data: "duration",
                class: "text-center",
                render: function(data, type, row){
                    var html = '';
                    var h = Math.floor(data/3600);
                    var m = Math.floor((data - h*3600)/60);
                    html += h+" giờ "+m+" phút";
                    return html;
                }
            },
            {
                data:"real_price",
                class: "real_price-field",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '';
                        html += '<div style="float: right"><b>'
                            html += numberFormat(row.real_price, 0, '.', '.') + ' đ';
                        html += '</b></div>'
                        return html;
                    }
                }
            },
            {
                data: "updated_at"
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                    
                    @if (Helper::checkPermissions('courses.view', $list_roles)) 
                        html += '<a class="btn-view mr-2 view-description" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Xem"> <i class="fa fa-eye fa-fw"></i></a>';
                    @endif
                    
                    @if (Helper::checkPermissions('courses.accept-course', $list_roles)) 
                        if(row['status'] == 1){
                            html += '<a class="btn-accept mr-2 accept-course" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Hủy"> <i class="fa fa-times fa-fw"></i></a>';
                        }else{
                            html += '<a class="btn-accept mr-2 accept-course" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Duyệt"> <i class="fa fa-check fa-fw"></i></a>';
                        }
                        
                    @endif

                    // @if (Helper::checkPermissions('courses.delete', $list_roles)) 
                    //     html += '<a class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>';
                    // @endif

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
                        ajax: "{{ url('/') }}/admincp/courses/getCourseAjax",
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
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",

                            },
                        },
    
                        fnServerParams: function ( aoData ) {

                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            checkCheckboxChecked();
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
        
        $('#course-table').css('width', '100%');

        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('.page table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '.page table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('.page table tbody input[type="checkbox"]:checked').length == $('.page table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-course'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
        }

        function checkCheckboxChecked(){
            var count_row = 0;
            var listUser = $('.check-course');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), userCheckList)){
                        $(this).prop('checked', 'true');
                        count_row++;
                    }
                });

                if(count_row == listUser.length){
                    $('#select-all-btn').prop('checked', true);
                }else{
                    $('#select-all-btn').prop('checked', false);
                }
            }else{
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

        // $('#showVideoIntroModal').on('hide.bs.modal', function () {
        //     $("#video-intro").attr('src', '')
        // })
        
        function addEventListener(){
            $('.view-description').off('click')
            $('.view-description').click(function(){
                var curr_cv = ($(this).parent().parent().attr('data-description'))
                // curr_cv = JSON.parse(curr_cv)
                // console.log(curr_cv.data)
                $('#showDescriptionModal').modal('show');
                $("#cv").append(curr_cv);
            })

            // $('.view-video-intro').off('click')
            // $('.view-video-intro').click(function(){
            //     var curr_video_intro = $(this).parent().parent().attr('data-video')

            //     $('#showVideoIntroModal').modal('show');
            //     $("#video-intro").attr('src', curr_video_intro)
            // })

            $('.btn-accept').off('click')
            $('.btn-accept').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                // alert(id)
                var status  = 0;
                var message = "Bạn có chắc chắn muốn duyệt khóa học bạn chọn?";
                if(_self.parent().parent().hasClass('blue-row')){
                    status = 1;
                    message = "Bạn có chắc chắn muốn hủy?";
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
                            url: baseURL+"/admincp/courses/accept",
                            data: {
                                course_id : id,
                                status : 1 - status
                            },
                            method: "PUT",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    if(_self.parent().parent().hasClass('blue-row')){
                                        $(_self).prop('title', 'Duyệt');
                                    } else {
                                        $(_self).prop('title', 'Hủy');
                                    }

                                    if(_self.parent().parent().hasClass('red-row')){
                                        _self.find('i').removeClass('fa-check').addClass('fa-times');
                                        _self.parent().parent().removeClass('red-row').addClass('blue-row');
                                    }else{
                                        _self.find('i').removeClass('fa-times').addClass('fa-check');
                                        _self.parent().parent().addClass('red-row').removeClass('blue-row');
                                    }

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

            $('.btn-delete').off('click')
            $('.btn-delete').click(function(e){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                var row = $(e.currentTarget).closest("tr");
                Swal.fire({
                    type: 'warning',
                   text: 'Bạn có chắc chắn muốn xóa khóa học bạn chọn?',
                   showCancelButton: true,
               }).then(result => {
                   if(result.value){
                    $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/courses/delete",
                            data: {
                                course_id : id
                            },
                            method: "DELETE",
                            dataType:'json',
                            beforeSend: function(r, a){
                                current_page = dataTable.page.info().page;
                            },
                            success: function (response) {
                                if(response.status == 200){
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                    dataTable.row( row ).remove().draw(true);
                                    dataTable.page( checkEmptyTable() ).draw( false );
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
                                 $().toastmessage('showErrorToast', errorConnect);
                                }
                            }
                        });
                   }
               })
            });
            
            $('#deleteAllApplied').off('click')
            $('#deleteAllApplied').click(function (){
                var check = false;
                $.each($('.check-course'), function (key, value){
                    if($(this).prop('checked') == true) {
                        check = true;
                    }
                });
                if(!check){
                    Swal.fire({
                        type: 'warning',
                        text: 'Bạn phải chọn ít nhất 1 khóa học.',
                    })
                    return false;
                }
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn có chắc chắn xóa tất cả những khóa học bạn chọn?',
                    showCancelButton: true,
                })
                .then(function (result) {
                    if(result.value){
                        var course_id_list = []
                        $.each($('.check-course'), function (key, value){
                            if($(this).prop('checked') == true) {
                                // id_list += $(this).attr("data-column") + ',';
                                course_id_list.push($(this).attr("data-column"))
                            }
                        });
                        if(course_id_list.length > 0){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                method: "DELETE",
                                url: baseURL+"/admincp/courses/delete-multiple-course",
                                data: {
                                    id_list: course_id_list
                                },
                                dataType: 'json',
                                beforeSend: function(r, a){
                                    current_page = dataTable.page.info().page;
                                },
                                success: function (response) {
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                    // dataTable.ajax.reload();
                                    $.each($('.check-course'), function (key, value){
                                        if($(this).prop('checked') == true) {
                                            dataTable.row( $(this).parent().parent() ).remove().draw(true);
                                        }
                                    });

                                    // dataTable.page( checkEmptyTable() ).draw( false );
                                },
                                error: function (response) {
                                    Swal.fire({
                                        type: 'warning',
                                        text: response.message
                                    })
                                }
                            })
                        }
                        
                    }
                })
            })

            $('#acceptAllApplied').off('click')
            $('#acceptAllApplied').click(function (){
                var check = false;
                $.each($('.check-course'), function (key, value){
                    if($(this).prop('checked') == true) {
                        check = true;
                    }
                });
                if(!check){
                    Swal.fire({
                        type: 'warning',
                        text: 'Bạn phải chọn ít nhất 1 khóa học',
                    })
                    return false;
                }
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn có chắc chắn duyệt tất cả những khóa học bạn chọn?',
                    showCancelButton: true,
                })
                .then(function (result) {
                    if(result.value){
                        var course_id_list = []
                        $.each($('.check-course'), function (key, value){
                            if($(this).prop('checked') == true) {
                                // id_list += $(this).attr("data-column") + ',';
                                course_id_list.push($(this).attr("data-column"))
                            }
                        });
                        if(course_id_list.length > 0){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                method: "PUT",
                                url: baseURL+"/admincp/courses/accept-multiple-course",
                                data: {
                                    id_list: course_id_list
                                },
                                dataType: 'json',
                                beforeSend: function(r, a){
                                    current_page = dataTable.page.info().page;
                                },
                                success: function (response) {
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                    // dataTable.ajax.reload();
                                    $.each($('.check-course'), function (key, value){
                                        if($(this).prop('checked') == true) {
                                            $(this).parent().parent().removeClass('red-row').addClass('blue-row');
                                            $(this).attr('checked', false)
                                            // $(this).parent().parent().addClass('red-row').removeClass('blue-row');
                                        }
                                    });
                                    userCheckList = [];
                                    dataTable.page( checkEmptyTable() ).draw( false );
                                    $('.check-user').prop('checked', false)
                                },
                                error: function (response) {
                                    Swal.fire({
                                        type: 'warning',
                                        text: response.message
                                    })
                                }
                            })
                        }
                        
                    }
                })
            })

            $('#inacceptAllApplied').off('click')
            $('#inacceptAllApplied').click(function (){
                var check = false;
                $.each($('.check-course'), function (key, value){
                    if($(this).prop('checked') == true) {
                        check = true;
                    }
                });
                if(!check){
                    Swal.fire({
                        type: 'warning',
                        text: 'Bạn phải chọn ít nhất 1 khóa học',
                    })
                    return false;
                }
                Swal.fire({
                    type: 'warning',
                    text: 'Bạn có chắc chắn hủy tất cả những khóa học bạn chọn?',
                    showCancelButton: true,
                })
                .then(function (result) {
                    if(result.value){
                        var course_id_list = []
                        $.each($('.check-course'), function (key, value){
                            if($(this).prop('checked') == true) {
                                // id_list += $(this).attr("data-column") + ',';
                                course_id_list.push($(this).attr("data-column"))
                            }
                        });
                        if(course_id_list.length > 0){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                method: "PUT",
                                url: baseURL+"/admincp/courses/inaccept-multiple-course",
                                data: {
                                    id_list: course_id_list
                                },
                                dataType: 'json',
                                beforeSend: function(r, a){
                                    current_page = dataTable.page.info().page;
                                },
                                success: function (response) {
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message
                                    })
                                    $.each($('.check-course'), function (key, value){
                                        if($(this).prop('checked') == true) {
                                            // $(this).parent().parent().removeClass('red-row').addClass('blue-row');
                                            $(this).parent().parent().addClass('red-row').removeClass('blue-row');
                                        }
                                    });
                                    userCheckList = [];
                                    dataTable.page(checkEmptyTable()).draw( false );
                                    $('.check-user').prop('checked', false)
                                },
                                error: function (response) {
                                    Swal.fire({
                                        type: 'warning',
                                        text: response.message
                                    })
                                }
                            })
                        }
                        
                    }
                })
            })
        }

        function checkEmptyTable(){
            if ($('#course-table tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
        
        $("#editEmail").click(function () {
            var id = $(this).attr("data-id")
            var title = $("#edit_subject_Ins").val()
            var content = edit_content_Ins.getData()

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var request = $.ajax({
                method : "PUT",
                url : "edit-email",
                data : {
                    id : id,
                    title: title,
                    content: content
                },
                dataType: "json"
            })
            request.done( function (response) {
                $("#edit_subject_Ins").val("")
                edit_content_Ins.setData("")
                Swal.fire({
                    text: response.message
                })
                if(response.status == 200){
                    $("#editEmailModal").modal("hide")
                    dataTable.ajax.reload();
                }
            })
        })

        $('#close').click(function(){
            $('#cv').html('');
        })

    });
</script>

@endsection