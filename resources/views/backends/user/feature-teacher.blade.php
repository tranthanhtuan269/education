@extends('backends.master')

@section('content')
<!-- Select Course -->
<link href="{{ url('/') }}/backend/css/select2.css" rel="stylesheet" />
<script src="{{ url('/') }}/backend/js/select2.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <div class="feature-teacher">
        <h1 class="text-center font-weight-600">Giảng viên tiêu biểu</h1>
        <div class="header form-check">
            <input class="form-check-input" type="radio" name="buttonRadios" id="buttonRadios1" value="option1" checked>
            <label class="form-check-label" for="buttonRadios1">Tự hiển thị 4 giảng viên có nhiều học viên theo học nhất</label>
        </div>
        <div class="auto-choose">
            <div class="row">
                <div class="col-xs-12">
                    <div class="listed">
                        @foreach ($auto_teacher as $key=>$teacher)
                    <div id="autoTeacher{{$key}}" data-id="{{$teacher->id}}"><b>- {{$teacher->userRole->user->name}}</b></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center"><button class="btn btn-primary" id="confirmAutoTeacher"><b>Xác nhận</b></button></div>
            <hr>
        </div>
        <div class="header form-check">
            <input class="form-check-input" type="radio" name="buttonRadios" id="buttonRadios2" value="option2">
            <label class="form-check-label" for="buttonRadios2">Chọn giảng viên tiêu biểu</label>
        </div>
        <div class="admin-choose">
            <div class="row">
                <div class="col-xs-12">
                    <label>Chọn giảng viên tiêu biểu thứ nhất</label>
                    <div class=''>
                        <select class="search-teacher" name="teacher1">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->userRole->user->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==1)
                                            selected
                                        @endif
                                    >{{ $teacher->userRole->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <label>Chọn giảng viên tiêu biểu thứ 2</label>
                    <div class=''>
                        <select class="search-teacher" name="teacher2">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->userRole->user->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==2)
                                            selected
                                        @endif
                                    >{{ $teacher->userRole->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <label>Chọn giảng viên tiêu biểu thứ 3</label>
                    <div class=''>
                        <select class="search-teacher" name="teacher3">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->userRole->user->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==3)
                                            selected
                                        @endif
                                    >{{ $teacher->userRole->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <label>Chọn giảng viên tiêu biểu thứ 4</label>
                    <div class=''>
                        <select class="search-teacher" name="teacher4">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->userRole->user->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==4)
                                            selected
                                        @endif
                                    >{{ $teacher->userRole->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>
            </div>
            <div class="text-center"><button class="btn btn-primary" id="confirmChooseTeacher"><b>Xác nhận</b></button></div>
        </div>
        <br>
    </div>
</section>
<style>
    .feature-teacher .form-check-label{
        font-size: 20px;
    }
    .feature-teacher .search-teacher{
        width: 600px;
    }
    .feature-teacher .listed{
        padding-left: 50px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){

        if( $('#buttonRadios1').attr('checked') == 'checked' ){
            $('.admin-choose').hide()
            $('.auto-choose').show()
        }else{
            $('.auto-choose').hide()
            $('.admin-choose').show()
        }

        $('#buttonRadios1').click(function(){
            $('.admin-choose').hide()
            $('.auto-choose').show()
        })
        $('#buttonRadios2').click(function(){
            $('.auto-choose').hide()
            $('.admin-choose').show()
        })

        $("#confirmChooseTeacher").click(function(){

            var teacher_id1 = $('select[name=teacher1]').children("option:selected").val();
            var teacher_id2 = $('select[name=teacher2]').children("option:selected").val();
            var teacher_id3 = $('select[name=teacher3]').children("option:selected").val();
            var teacher_id4 = $('select[name=teacher4]').children("option:selected").val();
            
            if (teacher_id1 == teacher_id2 || teacher_id1 == teacher_id3 || teacher_id1 == teacher_id4 || teacher_id2 == teacher_id3 || teacher_id2 == teacher_id4 || teacher_id3 == teacher_id4) {
                Swal.fire({
                    type: 'warning',
                    text: 'Không thể chọn trùng nhau.'
                })
                return;
            }

            var arr_teacher_id = []
            arr_teacher_id.push(teacher_id1)
            arr_teacher_id.push(teacher_id2)
            arr_teacher_id.push(teacher_id3)
            arr_teacher_id.push(teacher_id4)

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/feature-teacher/handling-feature-teacher",
                data: {
                    arr_teacher_id : arr_teacher_id
                },
                method: "POST",
                dataType:'json',
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            text: response.message,
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function (error) {
                    var obj_errors = error.responseJSON.errors;
                    var txt_errors = '';
                    for (k of Object.keys(obj_errors)) {
                        txt_errors += obj_errors[k][0] + '</br>';
                    }
                    Swal.fire({
                        type: 'warning',
                        html: txt_errors,
                        allowOutsideClick: false,
                    })
                }
            })
        })

        $('#confirmAutoTeacher').click(function(){

            var arr_teacher_id = []
            for( var i = 0 ; i < 4 ; i++ ){
                arr_teacher_id.push($('#autoTeacher'+i).attr('data-id'))
            }

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/feature-teacher/auto-feature-teacher",
                data: {
                    arr_teacher_id : arr_teacher_id
                },
                method: "POST",
                dataType:'json',
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            text: response.message,
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function (error) {
                    var obj_errors = error.responseJSON.errors;
                    var txt_errors = '';
                    for (k of Object.keys(obj_errors)) {
                        txt_errors += obj_errors[k][0] + '</br>';
                    }
                    Swal.fire({
                        type: 'warning',
                        html: txt_errors,
                        allowOutsideClick: false,
                    })
                }
            })
        })

        $('.search-teacher').select2({
            width: 'resolve',
            theme: "classic",
            multiple: false
        });
    });
</script>
@endsection