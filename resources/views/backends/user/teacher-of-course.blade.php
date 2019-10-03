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
    <h1 class="text-center font-weight-600">Danh sách giảng viên</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="teacher-table">
                    <thead class="thead-custom">
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Tên giảng viên</th>
                            <th scope="col">Chuyên môn</th>
                            <th scope="col">Video giới thiệu</th>
                            <th scope="col">Cập nhật</th>
                            <th scope="col">Duyệt</th>
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
                    return '<input type="checkbox" name="selectCol" class="check-user" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            {
                data: "name",
                class: "name-field",
                render: function(data, type, row){
                if(type == "display"){
                    var html = '';
                    html += '<a class="color-white" href="/teacher/'+row.action+'" target="_blank"><b>'+data+'</b></a>';
                    return html;
                }
                return data;
            },
            },
            {
                data: "expert",
                class: "expert-field"
            },
            {
                data: "video_intro",
                class: "video-item",
                render: function(data, type, row){
                    return '<a class="btn-view mr-2 view-video-intro"><i class="fa fa-video-camera" aria-hidden="true"></i> Video intro</a>';
                },
                orderable: false
            },
            {
                data: "created_at"
            },
            {
                data: "action",
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                    @if (Helper::checkPermissions('users.accept-teacher', $list_roles))
                        if(row['status'] == 1){
                            html += '<a class="btn-accept mr-2 accept-user" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Hủy"> <i class="fa fa-times fa-fw"></i></a>';
                        }else{
                            html += '<a class="btn-accept mr-2 accept-user" data-id="'+data+'" data-title="'+row.title+'" data-content="'+row.content+'" title="Duyệt"> <i class="fa fa-check fa-fw"></i></a>';
                        }

                    @endif
                    return html;
                },
                orderable: false
            },
        ];

        dataTable = $('#teacher-table').DataTable( {
                        serverSide: false,
                        aaSorting: [],
                        stateSave: true,
                        search: {
                            smart: false
                        },
                        ajax: "{{ url('/') }}/admincp/teachers/getTeacherAjax?teacher_id="+ "{{ $_GET['teacher_id']}}",
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
                            $(row).attr('data-cv', data['cv']);
                            console.log(data['video_intro']);
                            var video_intro_link = data['video_intro'];
                            video_intro_link = video_intro_link.replace("https://youtube.com", "https://www.youtube.com")
                            video_intro_link = video_intro_link.replace("watch?v=", "embed/")
                            $(row).attr('data-video', video_intro_link);
                        }
                    });

        $('#teacher-table').css('width', '100%');

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
            $.each($('.check-user'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
        }

        function checkCheckboxChecked(){
            var count_row = 0;
            var listUser = $('.check-user');
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

        $('#showVideoIntroModal').on('hide.bs.modal', function () {
            $("#video-intro").attr('src', '')
        })

        function addEventListener(){
            $('.view-video-intro').off('click')
            $('.view-video-intro').click(function(){
                var curr_video_intro = $(this).parent().parent().attr('data-video')

                $('#showVideoIntroModal').modal('show');
                $("#video-intro").attr('src', curr_video_intro)
            })

            $('.btn-accept').off('click')
            $('.btn-accept').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                var status  = 0;
                var message = "Bạn có chắc chắn muốn duyệt?";
                if(_self.parent().parent().hasClass('blue-row')){
                    status = 3;
                    message = "Bạn có chắc chắn muốn hủy giảng viên bạn chọn?";
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
                            url: baseURL+"/admincp/teachers/accept",
                            data: {
                                teacherId : id,
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
                                    if(status == 0){
                                        Swal.fire({
                                            type: 'success',
                                            text: "Duyệt giảng viên thành công."
                                        })
                                    }
                                    else{
                                        Swal.fire({
                                            type: 'success',
                                            text: "Hủy duyệt giảng viên thành công."
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
                    text: 'Bạn có chắc chắn muốn xóa giảng viên bạn chọn?',
                    showCancelButton: true,
                }).then(result => {
                    if(result.value){
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: baseURL+"/admincp/teachers/delete",
                            data: {
                                teacherId : id
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
        }

        function checkEmptyTable(){
            if ($('#teacher-table tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    });
</script>

@endsection
