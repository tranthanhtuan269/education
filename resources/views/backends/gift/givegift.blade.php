@extends('backends.master')

@section('content')

<!-- Begin MultiSelect -->
<link href="{{ asset('backend/css/sol.css') }}" rel="stylesheet" />
<script src="{{ asset('backend/js/sol.js') }}"></script>
<!-- End MultiSelect -->

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
<section class="content page" id="giftPage">
    <h1 class="text-center font-weight-600">Tặng khóa học</h1>
    <div class="row">
        <div class="col-md-6">
            <h3><b>Số học viên được tặng khóa học</b></h3>
            <br>
            <div class="gift-student-number text-center">
                <span>Nhập số học viên: </span> &nbsp;
                <input type="number" min="0" step="1" name="student-number" class="form-html"> &nbsp;
                <button class="btn btn-success btn-student-number">Xác nhận</button>
                <div class="form-html-validate student_id"></div>
            </div>
            <br>
            <div class="table-responsive" style="display:none">
                <table class="table table-bordered" id="student-table">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">ID</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div><br>
            <div class="text-center"><button class="btn btn-primary" id="btn-gift"><b>Xác nhận tặng</b></button></div>
        </div>
        <div class="col-md-6 arr-courses">
            <h3><b>Chọn khóa học miễn phí</b></h3>
            <br>
            <div class="form-html">
                <select id="demonstration" name="course[]" style="width: 400px" multiple="multiple">
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                <div class="form-html-validate course_id"></div>
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
    var errorConnect        = "Kiểm tra kết nối Internet và thử lại!";

    $(document).ready(function(){
        $("#btn-gift").click(function(){
            var student_id = [];

            if (dataTable) {
                $('#student-table tbody tr td.user-role-id').each(function(){
                    student_id.push($(this).text());
                });
            }

            var asInputs = sol.getSelection(),
                course_id = [];

            for (var i = 0; i < asInputs.length; i++) {
                course_id[i] = $(asInputs[i]).data('sol-item').value;
            }

            if (student_id.length == 0) {
                alertValidate('Chưa có học viên nào được chọn!', 'student_id')
                return;
            }

            if (course_id.length == 0) {
                alertValidate('Chưa có khóa học nào được chọn!', 'course_id')
                return;
            }

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/gifts/handling-gift-ajax",
                data: {
                    student_id : student_id,
                    course_id : course_id
                },
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $("#pre_ajax_loading").show();
                },
                complete: function() {
                    $("#pre_ajax_loading").hide();
                },
                success: function (response) {
                    if(response.status == 200){

                        Swal.fire({
                            type: 'success',
                            text: response.message
                        })
                    }
                },
                error: function (data) {
                }
            });
        });
        
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
                data: "id",
                orderable: false
            },
            { 
                data: "id",
                class:"user-role-id"
            },
            { 
                data:"email", 
            },
            // { 
            //     data:"course_id", 
            // },
        ];
        $(".btn-student-number").click(function(){
            var student_numb = $('input[name=student-number]').val()
            if( student_numb == '' ){
                alertValidate('Bạn chưa nhập số học viên.', 'student_id')
                return
            }

            if( Number(student_numb) <= 0 ){
                alertValidate('Số học viên không thể < 1.', 'student_id')
                return
            }

            $('.table-responsive').css('display', 'block')
            if (dataTable) {
                dataTable.destroy();  
            }

            dataTable = $('#student-table').DataTable( {
                            searching: false,
                            // paging: false,
                            serverSide: false,
                            aaSorting: [],
                            stateSave: true,
                            search: {
                                smart: false
                            },
                            ajax:{
                                url: "{{ url('/') }}/admincp/gifts/getGiftStudentAjax?number="  + $('input[name="student-number"]').val(),
                                beforeSend: function() {
                                    $(".ajax_waiting").addClass("loading");
                                }
                            },  
                            columns: dataObject,
                            bLengthChange: true,
                            pageLength: 10,
                            // order: [[ 4, "desc" ]],
                            colReorder: {
                                fixedColumnsRight: 0,
                                fixedColumnsLeft: 0
                            },
                            oLanguage: {
                                sSearch: "Tìm",
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
                        });

            dataTable.on('order.dt search.dt', function () {
                dataTable.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                    dataTable.cell(cell).invalidate('dom');
                });
            }).draw();
        });

        $('#student-table').css('width', '100%');

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
            $('.choose-course').off('click')
            $('.choose-course').click(function(){
                $('#chooseGiftCourse').modal('show');
            })
        }
    });

    var sol = $('#demonstration').searchableOptionList({ 
        maxHeight: '250px',
        showSelectAll: true
    });
</script>
@endsection