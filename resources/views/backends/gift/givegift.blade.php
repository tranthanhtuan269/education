@extends('backends.master')

@section('content')

<!-- Begin MultiSelect -->
<link href="https://rawgit.com/pbauerochse/searchable-option-list/master/sol.css" rel="stylesheet" />
<script src="https://rawgit.com/pbauerochse/searchable-option-list/master/sol.js"></script>
<!-- End MultiSelect -->
<!-- <link href="http://loudev.com/css/multi-select.css" rel="stylesheet" /> -->
<!--  -->

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
    <h1 class="text-center font-weight-600">Tặng khóa học</h1>
    <div class="row">
        <div class="col-md-6">
            <h3><b>Số học viên được tặng khóa học</b></h3>
            <br>
            <div class="">
                <span>Nhập số học viên: </span> &nbsp;
                <input type="text" placeholder="10" name="student-number" value="10"> &nbsp;
                <button class="btn btn-success btn-student-number">Xác nhận</button>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="student-table">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">ID</th>
                            <th scope="col">Tên</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h3><b>Chọn khóa học miễn phí</b></h3>
            <br>
            <div class="">
                <!-- <br><br> -->
                <!-- <button class="btn btn-primary choose-course">Chọn khóa học</button> -->
                <!-- <input type="text" placeholder="Nhập số lượng học viên"> -->
            </div>
            <br>
            <div>
                <p><select id="demonstration" name="course[]" style="width: 400px" multiple="multiple">
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select></p>
                <script type="text/javascript">
                
                    var sol = $('#demonstration').searchableOptionList({ 
                                maxHeight: '250px',
                                showSelectAll: true
                            });
                </script>
            </div>
        </div>
    </div>
    <div class="text-center"><button class="btn btn-primary" id="btn-gift">Xác nhận tặng</button></div>
</section>
<!-- <section>
    <div class="modal fade" id="chooseGiftCourse" tabindex="-1">
        <div class="modal-dialog" style="width:900px">
            <div class="modal-content" style="height:450px">
                <div class="modal-header">
                    <h3>Chọn khóa học</h3>
                </div>
                <div class="modal-body">
                    <div class='span12'>
                        <select multiple class="searchable" name="searchable[]">
                        @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                        </select>
                        <br />
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Xác nhận</button>
                        </div>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<script type="text/javascript">
    var dataTable           = null;
    var userCheckList       = [];
    var curr_user_name      = '';
    var curr_user_email     = '';
    var current_page        = 0;
    var old_search          = '';
    var errorConnect        = "Please check your internet connection and try again.";

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
                Swal.fire({
                    type: 'warning',
                    text: 'Chua co hoc vien nao duoc chon!'
                })

                return;
            }

            if (course_id.length == 0) {
                Swal.fire({
                    type: 'warning',
                    text: 'Chua co khoa hoc nao duoc chon!'
                })

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
                data:"name", 
            },
        ];
        $(".btn-student-number").click(function(){
            if (dataTable) {
                dataTable.destroy();  
            }

            dataTable = $('#student-table').DataTable( {
                            searching: false,
                            // paging: false,
                            serverSide: false,
                            aaSorting: [],
                            stateSave: true,
                            ajax: "{{ url('/') }}/admincp/gifts/getGiftStudentAjax?number="  + $('input[name="student-number"]').val(),
                            columns: dataObject,
                            bLengthChange: true,
                            pageLength: 100,
                            // order: [[ 4, "desc" ]],
                            colReorder: {
                                fixedColumnsRight: 1,
                                fixedColumnsLeft: 1
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
                            // createdRow: function( row, data, dataIndex){
                                // if(data['id']%2 == 1){
                                //     $(row).addClass('blue-row');
                                // }else{
                                //     $(row).addClass('red-row');
                                // }
                                
                                // $(row).attr('data-cv', data['cv']);
                                // $(row).attr('data-video', data['video_intro']);
                            // }
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
                // var curr_cv = $(this).parent().parent().attr('data-cv')

                $('#chooseGiftCourse').modal('show');
                // $("#cv").html(curr_cv)
            })
        }

        function checkEmptyTable(){
            if ($('#student-table tr').length <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }

    });
</script>


<!-- <script src="http://loudev.com/js/jquery.quicksearch.js" type="text/javascript"></script> -->
<!-- <script src="http://loudev.com/js/jquery.multi-select.js" type="text/javascript"></script> -->
<!-- <script src="http://loudev.com/js/application.js" type="text/javascript"></script> -->

@endsection