@extends('backends.master')

@section('content')

<!-- Select Course -->
<link href="{{ url('/') }}/backend/css/select2.css" rel="stylesheet" />
<script src="{{ url('/') }}/backend/js/select2.js"></script>

<!-- Include the plugin's CSS and JS: -->
<!-- <script type="text/javascript" src="{{ url('/') }}/backend/js/bootstrap-multiselect.js"></script> -->
<!-- <link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap-multiselect.css" type="text/css"/> -->

<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Chọn khóa học nổi bật</h1>
    <div class="row">
        <div class="col-xs-12">
            <p><b>Chọn khóa học nổi bật nhất</b></p>
            <div class=''>
                <select multiple class="searchable" name="searchable1" style="width: 50%">
                @foreach ($courses as $course)
                <option
                @if($course->featured_index==1)
                selected
                @endif
                value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
                </select>
            </div>
            <br>
            <p><b>Chọn khóa học nổi bật thứ 2</b></p>
            <div class=''>
                <select multiple class="searchable" name="searchable2" style="width: 50%">
                @foreach ($courses as $course)
                <option
                @if($course->featured_index==2)
                selected
                @endif
                value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
                </select>
            </div>
            <br>
            <p><b>Chọn khóa học nổi bật thứ 3</b></p>
            <div class=''>
                <select multiple class="searchable" name="searchable3" style="width: 50%">
                @foreach ($courses as $course)
                <option
                @if($course->featured_index==3)
                selected
                @endif
                value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="text-center"><button class="btn btn-success" id="btn-confirm">Xác nhận</button></div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $("#btn-confirm").click(function(){
            var course_1 = $('select[name=searchable1]').children("option:selected").val();
            var course_2 = $('select[name=searchable2]').children("option:selected").val();
            var course_3 = $('select[name=searchable3]').children("option:selected").val();
            
            if (course_1 == course_2 || course_3 == course_2 || course_1 == course_3) {
                Swal.fire({
                    type: 'warning',
                    text: 'Không thể chọn trùng nhau!'
                })
                return;
            }

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/feature-course/handling-feature-course",
                data: {
                    course_1 : course_1,
                    course_2 : course_2,
                    course_3 : course_3
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
    });
</script>
<script>
    $(document).ready(function() {
        $('.searchable').select2({
            width: 'resolve',
            // placeholder: 'Chọn khóa học',
            theme: "classic",
            multiple: false
        });
    });
</script>

@endsection