@extends('backends.master')

@section('content')
<!-- Select Course -->
<link href="{{ url('/') }}/backend/css/select2.css" rel="stylesheet" />
<script src="{{ url('/') }}/backend/js/select2.js"></script>

@php

$teacher_selected = 0;
$feature_teacher_selected = \App\Setting::where('name', 'feature_teacher_selected')->first();

if($feature_teacher_selected){
    $teacher_selected = $feature_teacher_selected->value;
}

@endphp
<section class="content-header">
    
</section>
<section class="content page">
    <div class="feature-teacher">
        <h1 class="text-center font-weight-600">Giảng viên tiêu biểu</h1>
        <div class="header form-check">
            <input class="form-check-input" type="radio" name="buttonRadios" id="buttonRadios1" value="option1" @if($teacher_selected == 0) checked @endif>
            <label class="form-check-label" for="buttonRadios1">Tự hiển thị 4 giảng viên có nhiều học viên theo học nhất</label>
        </div>
        <div class="auto-choose">
            <div class="row">
                <div class="col-xs-12">
                    <div class="listed">
                        @foreach ($auto_teacher as $key=>$teacher)
                    <div id="autoTeacher{{$key}}" data-id="{{$teacher->id}}"><b>- {{$teacher->name}}</b></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center"><button class="btn btn-primary" id="confirmAutoTeacher"><b>Xác nhận</b></button></div>
            <hr>
        </div>
        <div class="header form-check">
            <input class="form-check-input" type="radio" name="buttonRadios" id="buttonRadios2" value="option2" @if($teacher_selected == 1) checked @endif>
            <label class="form-check-label" for="buttonRadios2">Chọn giảng viên tiêu biểu</label>
        </div>
        <div class="admin-choose">
            <div class="row">
                <div class="col-md-6">
                    <label>Chọn giảng viên tiêu biểu thứ nhất</label>
                    <div class=''>
                        <select class="search-teacher" name="searchTeacher1" onchange="selectionTeacher1(this)" id="selectionTeacher1">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==1)
                                            selected
                                        @endif
                                        @if($teacher->featured == 1 && $teacher->featured_index != 1)
                                            disabled
                                        @endif
                                    >{{ $teacher->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <label>Chọn giảng viên tiêu biểu thứ 2</label>
                    <div class=''>
                        <select class="search-teacher" name="searchTeacher2" onchange="selectionTeacher2(this)" id="selectionTeacher2">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==2)
                                            selected
                                        @endif
                                        @if($teacher->featured == 1 && $teacher->featured_index != 2)
                                            disabled
                                        @endif
                                    >{{ $teacher->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>
                <div class="col-md-6">
                    <label>Chọn giảng viên tiêu biểu thứ 3</label>
                    <div class=''>
                        <select class="search-teacher" name="searchTeacher3" onchange="selectionTeacher3(this)" id="selectionTeacher3">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==3)
                                            selected
                                        @endif
                                        @if($teacher->featured == 1 && $teacher->featured_index != 3)
                                            disabled
                                        @endif
                                    >{{ $teacher->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <label>Chọn giảng viên tiêu biểu thứ 4</label>
                    <div class=''>
                        <select class="search-teacher" name="searchTeacher4" onchange="selectionTeacher4(this)" id="selectionTeacher4">
                            @foreach ($teachers as $teacher)
                                @if( isset($teacher->name) )
                                    <option value="{{ $teacher->id }}"
                                        @if($teacher->featured_index==4)
                                            selected
                                        @endif
                                        @if($teacher->featured == 1 && $teacher->featured_index != 4)
                                            disabled
                                        @endif
                                    >{{ $teacher->name }}</option>
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
        width: 300px;
    }
    .feature-teacher .listed{
        padding-left: 50px;
    }
</style>
<script type="text/javascript">

    function selectionTeacher1(selectObject) {
        var new_value = selectObject.value;
        var old_value = $('select[name=searchTeacher1]').attr('data-value')

        $('#selectionTeacher1 option[value="'+new_value+'"]').attr('selected', true)
        $('select[name=searchTeacher1]').attr('data-value', new_value)

        $('#selectionTeacher2 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher2 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher3 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher3 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher4 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher4 option[value="'+old_value+'"]').attr('disabled', false)

        $('.searchable').select2({
            width: 'resolve',
            theme: "classic",
            multiple: false
        })
    }

    function selectionTeacher2(selectObject) {
        var new_value = selectObject.value;
        var old_value = $('select[name=searchTeacher2]').attr('data-value')

        $('#selectionTeacher2 option[value="'+new_value+'"]').attr('selected', true)
        $('select[name=searchTeacher2]').attr('data-value', new_value)

        $('#selectionTeacher1 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher1 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher3 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher3 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher4 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher4 option[value="'+old_value+'"]').attr('disabled', false)

        $('.searchable').select2({
            width: 'resolve',
            theme: "classic",
            multiple: false
        })
    }

    function selectionTeacher3(selectObject) {
        var new_value = selectObject.value;
        var old_value = $('select[name=searchTeacher3]').attr('data-value')

        $('#selectionTeacher3 option[value="'+new_value+'"]').attr('selected', true)
        $('select[name=searchTeacher3]').attr('data-value', new_value)

        $('#selectionTeacher2 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher2 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher1 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher1 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher4 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher4 option[value="'+old_value+'"]').attr('disabled', false)

        $('.searchable').select2({
            width: 'resolve',
            theme: "classic",
            multiple: false
        })
    }

    function selectionTeacher4(selectObject) {
        var new_value = selectObject.value;
        var old_value = $('select[name=searchTeacher4]').attr('data-value')

        $('#selectionTeacher4 option[value="'+new_value+'"]').attr('selected', true)
        $('select[name=searchTeacher4]').attr('data-value', new_value)

        $('#selectionTeacher2 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher2 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher3 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher3 option[value="'+old_value+'"]').attr('disabled', false)

        $('#selectionTeacher1 option[value="'+new_value+'"]').attr('disabled', true)
        $('#selectionTeacher1 option[value="'+old_value+'"]').attr('disabled', false)

        $('.searchable').select2({
            width: 'resolve',
            theme: "classic",
            multiple: false
        })
    }

    $(document).ready(function(){
        // Set Value Select
        var e = document.getElementById("selectionTeacher1");
        var value = e.options[e.selectedIndex].value
        $('select[name=searchTeacher1]').attr('data-value', value)
        var e = document.getElementById("selectionTeacher2");
        var value = e.options[e.selectedIndex].value
        $('select[name=searchTeacher2]').attr('data-value', value)
        var e = document.getElementById("selectionTeacher3");
        var value = e.options[e.selectedIndex].value
        $('select[name=searchTeacher3]').attr('data-value', value)
        var e = document.getElementById("selectionTeacher4");
        var value = e.options[e.selectedIndex].value
        $('select[name=searchTeacher4]').attr('data-value', value)

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

            var teacher_id1 = $('select[name=searchTeacher1]').children("option:selected").val();
            var teacher_id2 = $('select[name=searchTeacher2]').children("option:selected").val();
            var teacher_id3 = $('select[name=searchTeacher3]').children("option:selected").val();
            var teacher_id4 = $('select[name=searchTeacher4]').children("option:selected").val();
            
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