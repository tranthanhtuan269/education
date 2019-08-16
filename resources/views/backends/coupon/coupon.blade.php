@extends('backends.master')
@section('content')

<!-- Begin MultiSelect -->
<link href="{{ asset('backend/css/sol.css') }}" rel="stylesheet" />
<script src="{{ asset('backend/js/sol.js') }}"></script>
<!-- End MultiSelect -->

<script type="text/javascript" src="{{ url('/') }}/backend/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap-multiselect.css" type="text/css"/>

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Tạo Mã giảm giá</h1>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-md-6">
                <h3><b>Nhập mã Coupon</b></h3><br>
                <p>Tạo mã Coupon</p>
                <input type="text" id="coupon_code" name="name">
                <br>&nbsp;
                <p>Nhập số % của Coupon</p>
                <input type="number" id="coupon_value" name="value">
                <br>&nbsp;
                <p>Nhập ngày hết hạn của Coupon</p>
                <input type="text" id="coupon_expired" pattern="\d{1,2}/\d{1,2}/\d{4}" value="" autocomplete="off">
                <script>
                    $(function() {
                    $( "#coupon_expired" ).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "2019:2050",
                            dateFormat: 'yy/mm/dd',
                            minDate: new Date(),
                        }	
                    );
                    });
                </script>
            </div>
            <div class="col-md-6">
                <h3><b>Chọn khóa học được hưởng Coupon</b></h3><br>
                <div>
                    <p><select id="demonstration" name="course[]" style="width: 400px" multiple="multiple">
                        @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select></p>
                </div>
            </div>

        </div>
    </div>
    <br>
    <div class="text-center"><button class="btn btn-success" id="btn-confirm">Xác nhận</button></div>
</section>
<script>
$(document).ready(function(){
    $("#btn-confirm").click(function(){
        var asInputs = sol.getSelection(), course_id = [];
        var coupon_code = $('#coupon_code').val();
        var coupon_value = $('#coupon_value').val();
        var coupon_expired = $('#coupon_expired').val();

        if(coupon_code == ''){
            Swal.fire({
                type: 'warning',
                text: 'Bạn chưa nhập mã Coupon!'
            })
            return;
        }

        if(coupon_value == ''){
            Swal.fire({
                type: 'warning',
                text: 'Bạn chưa nhập số % được giảm!'
            })
            return;
        }

        for (var i = 0; i < asInputs.length; i++) {
            course_id[i] = $(asInputs[i]).data('sol-item').value;
        }

        if (course_id.length == 0) {
            Swal.fire({
                type: 'warning',
                text: 'Chưa có khóa học nào được chọn!'
            })
            return;
        }

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: baseURL+"/admincp/add-coupon",
            data: {
                coupon_code  : coupon_code,
                coupon_value : coupon_value,
                course_id    : course_id,
                coupon_expired : coupon_expired
            },
            method: "POST",
            dataType:'json',
            beforeSend: function(r, a){
                
            },
            success: function (response) {
                if(response.status == 200){

                    Swal.fire({
                        type: 'success',
                        text: 'Thêm mã giảm giá thành công!'
                    })
                }
            },
            error: function (data) {
            }
        });
    });
});

var sol = $('#demonstration').searchableOptionList({ 
        maxHeight: '250px',
        showSelectAll: true
    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
@endsection