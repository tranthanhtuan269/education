@extends('backends.master')

@section('content')
<!-- Select Course -->
<link href="{{ url('/') }}/backend/css/select2.css" rel="stylesheet" />
<script src="{{ url('/') }}/backend/js/select2.js"></script>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Chọn giảng viên tiêu biểu</h1>
    <div class="row">
        <div class="col-xs-12">
            <p><b>Chọn giảng viên tiêu biểu thứ nhất</b></p>
            <div class=''>
                <select class="search-teacher" name="teacher1" style="width: 50%">
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
            <p><b>Chọn giảng viên tiêu biểu thứ 2</b></p>
            <div class=''>
                <select class="search-teacher" name="teacher2" style="width: 50%">
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
            <p><b>Chọn giảng viên tiêu biểu thứ 3</b></p>
            <div class=''>
                <select class="search-teacher" name="teacher3" style="width: 50%">
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
            <p><b>Chọn giảng viên tiêu biểu thứ 4</b></p>
            <div class=''>
                <select class="search-teacher" name="teacher4" style="width: 50%">
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
    <br>
    <div class="text-center"><button class="btn btn-primary" id="btn-confirm"><b>Xác nhận</b></button></div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $("#btn-confirm").click(function(){
            var teacher_1 = $('select[name=teacher1]').children("option:selected").val();
            var teacher_2 = $('select[name=teacher2]').children("option:selected").val();
            var teacher_3 = $('select[name=teacher3]').children("option:selected").val();
            var teacher_4 = $('select[name=teacher4]').children("option:selected").val();
            
            if (teacher_1 == teacher_2 || teacher_1 == teacher_3 || teacher_1 == teacher_4 || teacher_2 == teacher_3 || teacher_2 == teacher_4 || teacher_3 == teacher_4) {
                Swal.fire({
                    type: 'warning',
                    text: 'Không thể chọn trùng nhau.'
                })
                return;
            }

            var arr_teacher = []
            arr_teacher.push(teacher_1)
            arr_teacher.push(teacher_2)
            arr_teacher.push(teacher_3)
            arr_teacher.push(teacher_4)

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/feature-teacher/handling-feature-teacher",
                data: {
                    arr_teacher : arr_teacher
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
            });
        });

        $('.search-teacher').select2({
            width: 'resolve',
            theme: "classic",
            multiple: false
        });
    });
</script>
@endsection