@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<section class="content-header">
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Tài khoản thanh toán Stripe</h1>
    <div class="row col-xs-12" id="stripeAccount">
        <div class="form-group col-xs-6 form-html">
            <label class="control-label">Publishable key:</label>
            <input type="text" class="form-control" id="STRIPE_KEY" placeholder="Publishable key" value="{{$STRIPE_KEY->value}}">
            <div class="form-html-validate STRIPE_KEY"></div>
        </div>
        <div class="form-group col-xs-6 form-html">
            <label class="control-label">Secret key:</label>
            <input type="text" class="form-control" id="STRIPE_SECRET" placeholder="Secret key" value="{{$STRIPE_SECRET->value}}">
            <div class="form-html-validate STRIPE_SECRET"></div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary" id="submit">Xác nhận</button>  
        </div>     
    </div>
    
</section>
<script>
    $(document).ready(function(){
        $('#submit').click(function(){
            var flag = true;
            var STRIPE_KEY = $('#STRIPE_KEY').val();
            var STRIPE_SECRET = $('#STRIPE_SECRET').val();
            if (STRIPE_KEY == "") {
                alertValidate('Bạn chưa nhập STRIPE_KEY!', 'STRIPE_KEY')
                flag = false
            }
            if (STRIPE_SECRET == "") {
                alertValidate('Bạn chưa nhập STRIPE_SECRET!', 'STRIPE_SECRET')
                flag = false
            }
            if(flag == false) return
            var data = {
                STRIPE_KEY : STRIPE_KEY,
                STRIPE_SECRET : STRIPE_SECRET
                };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL+"/admincp/stripe/update",
                data: data,
                method: "POST",
                dataType:'json',
                success: function (response) {
                    Swal.fire({
                            type: 'success',
                            text: response.message
                        }).then(result => {
                            location.reload()
                        })
                }
            });
        });
    });
</script>
@endsection
