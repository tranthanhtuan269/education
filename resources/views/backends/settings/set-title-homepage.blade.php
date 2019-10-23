@extends('backends.master')
@section('content')

<section class="content-header">
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Tiêu đề trang chủ</h1><br>
    <div class="row">
        <div class="col-xs-12">
            <div class="">
                <form>
                    <div class="form-group">
                        <textarea name="" id="titleHomepage" rows="3" style="width: 100%;font-size: 16px">{{$title}}</textarea><br>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <br>
    <div class="text-center"><button class="btn btn-primary" id="btn-confirm"><b>Xác nhận</b></button></div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $("#btn-confirm").click(function(){
            var title = $('#titleHomepage').val()
            
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseURL+"/admincp/set-title-homepage",
                data: {
                    title : title
                },
                method: "POST",
                dataType:'json',
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            text: response.message
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
    });
</script>

@endsection