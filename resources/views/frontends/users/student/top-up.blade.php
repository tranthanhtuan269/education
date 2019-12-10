@extends('frontends.layouts.app') 
@section('content')
<?php
    $internet_banking = $payments[0];
    $visa_mastercard = $payments[1];
    $nganluong = $payments[2];
    $paypal = $payments[3];
    $bank_transfer = $payments[4];
    // dd($visa_mastercard->status,$bank_transfer->status);
?>

<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.student.menu')
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="bill-info">
        <div id="addFundTab" class="col-xs-12 payment-method tab-pane fade in">
            <div class="row">
                <ul>
                    @if ( $internet_banking->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Internet Banking">
                                <img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1">
                            </a>
                        </div>
                    </li>
                    @endif
                    @if ( $visa_mastercard->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a data-toggle="tab" href="#visa_mastercard" id="paymentVisaStripe" title="Visa">
                                <img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2">
                            </a>
                        </div>
                    </li>
                    @endif
                    @if ( $nganluong->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="NganLuongVN">
                                <img src="{{asset('frontend/images/payment-method-3.png')}}" alt="Payment Methods 3">
                            </a>
                        </div>
                    </li>
                    @endif
                    @if ( $paypal->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Paypal">
                                <img src="{{asset('frontend/images/payment-method-4.png')}}" alt="Payment Methods 4">
                            </a>
                        </div>
                    </li>
                    @endif
                    @if ( $bank_transfer->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a title="Bank Transfer" data-toggle="tab" href="#bank_transfer" id="paymentBankTransfer">
                                <img src="{{asset('frontend/images/payment-method-5.png')}}" alt="Payment Methods 5">
                            </a>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
            {{-- <div class="row">
                <div class="col-sm-6 col-sm-offset-3 col-xs-12 balance">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-sm-8">
                                <input type="text" class="form-control" id="amount-money" placeholder="Số tiền bạn muốn nạp">
                            </div>
                            <button type="submit" class="col-sm-4 btn-confirm">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="recharge-content">
                <div class="tab-content">
                    <div id="bank_transfer" class="tab-pane fade in tab-steps-register">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="desc">
                                    <h4>{{ $bank_transfer->title }}</h4>
                                    <p>
                                        {!! $bank_transfer->description !!}
                                    </p>
                                    <p>
                                        {!! $bank_transfer->instruction !!}
                                    </p>
                                    <div class="tit">Nội dung chuyển khoản của bạn:</div>
                                    <div class="mess" style="color:brown">NapTienTK: {{Auth::user()->id}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="account-info">
                                    <h4>Thông tin chuyển khoản ngân hàng</h4>
                                    <div class="tit">Tên tài khoản:</div>
                                    <div class="name">{{ $bank_account->name }}</div>
                                    <div class="tit">Ngân hàng:</div>
                                    <div class="bank-name">{{ $bank_account->bank_name }}</div>
                                    <div class="tit">Số tài khoản:</div>
                                    <div class="account-number">{{ $bank_account->account_number }}</div>
                                    <div class="tit">Nội dung chuyển khoản:</div>
                                    <div class="mess" style="color:brown">NapTienTK: {{Auth::user()->id}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="visa_mastercard" class="tab-pane fade in tab-steps-register">
                        <div class="row">
                            <div class="panel-body col-md-6 col-md-offset-3">
                                
                                @if (Session::has('success'))
                                    <script>
                                        localStorage.clear();
                                        Swal.fire({
                                            type: 'success',
                                            text: "Nạp tiền thanh công!"
                                        }).then( result => {
                                            document.location.href = '/user/student/top-up';
                                        })
                                    </script>
                                @endif
                                @if (Session::has('fail'))
                                    <script>
                                        localStorage.clear();
                                        Swal.fire({
                                            type: 'warning',
                                            text: "Số tiền nhập sai (chỉ được nhập số nguyên dương)! Vui lòng nhập lại từ đầu"
                                        }).then( result => {
                                            $('#paymentVisaStripe').click();
                                        })
                                    </script>
                                @endif
                            
                                <form role="form" action="{{ route('stripe.recharge') }}" method="post" class="require-validation"
                                                                data-cc-on-file="false"
                                                                data-stripe-publishable-key="{{$STRIPE_KEY}}"
                                                                id="payment-form">
                                    @csrf
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Tên in trên thẻ:</label> <input
                                                class='form-control' name='card_name' size='4' type='text' 
                                                >
                                        </div>
                                    </div>
        
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required'>
                                            <label class='control-label'>Số thẻ:</label> <input
                                                autocomplete='off' name='card_number' class='form-control card-number' size='20'
                                                type='text' >
                                        </div>
                                    </div>
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required'>
                                            <label class='control-label'>Số tiền muốn nạp (USD):</label> <input
                                                autocomplete='off' name='price_number' class='form-control price-number' size='20'
                                                type='number' placeholder='Nhập số nguyên dương' min="0" id='priceNumber'>
                                        </div>
                                    </div>
            
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC:</label> <input autocomplete='off'
                                                name='card_cvc' class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                type='text' >
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Tháng hết hạn:</label> <input
                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                name='card_expiry_month' type='text' >
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Năm hết hạn:</label> <input
                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                name='card_expiry_year' type='text' >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" id="stripeSubmit">Thanh toán</button>
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <!-- <div class="blockform-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="default_check" >
                                        <label class="form-check-label" for="defaultCheck1" >Lưu và bảo mật cho lần thanh toán sau</label>
                                    </div> -->
                                </form>
                                <div class="col-xs-4">
                                    <button class="btn btn-default btn-lg btn-block" id="cancel" style="margin-top: -39%;margin-left: 230%;">Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    $('#paymentBankTransfer').click(function(){
        $('#paymentBankTransfer img').css('border-color', '#44B900')
        $('#paymentBankTransfer img').css('border-radius', '20px')
        $('#paymentVisaStripe img').css('border-color', '#ffffff')
    })
    $('#paymentVisaStripe').click(function(){
        $('#paymentVisaStripe img').css('border-color', '#44B900')
        $('#paymentVisaStripe img').css('border-radius', '20px')
        $('#paymentBankTransfer img').css('border-color', '#ffffff')
    })
    $('#cancel').click(function(){
        $('input[name=card_name]').val('');
        $('input[name=card_number]').val('');
        $('input[name=price_number]').val('');
        $('input[name=card_cvc]').val('');
        $('input[name=card_expiry_month]').val('');
        $('input[name=card_expiry_year]').val('');
    })
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    document.getElementById('priceNumber').onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58)
        || e.keyCode == 8)) {
            return false;
        }
    }
    $(function() {

        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');
            console.log($form);
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);

                $(".ajax_waiting").addClass("loading");
            }
            $("#stripeSubmit").attr("disabled", true);
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    
                    // .removeClass('hide')
                    // .find('.alert')
                    // .text(response.error.message);
                    if(status == 400 && response.error.code == "missing_payment_information"){
                        Swal.fire({
                        type:"warning",
                        text:"Không thể tìm thấy thông tin thanh toán!"
                        }).then((result) => {
                            $('button[type=submit]').removeAttr('disabled');
                        });    
                    }

                    if(response.error.code == "incorrect_number" || response.error.code == "invalid_number"){
                        Swal.fire({
                        type:"warning",
                        text:"Số tài khoản không đúng!"
                        }).then((result) => {
                            $('button[type=submit]').removeAttr('disabled');
                        });    
                    }

                    if(status == 402 && response.error.code == "invalid_expiry_year"){
                        Swal.fire({
                        type:"warning",
                        text:"Năm hết hạn thẻ của bạn không hợp lệ!"
                        }).then((result) => {
                            $('button[type=submit]').removeAttr('disabled');
                        });    
                    }

                    if(status == 402 && response.error.code == "invalid_expiry_month"){
                        Swal.fire({
                        type:"warning",
                        text:"Tháng hết hạn thẻ của bạn không hợp lệ!"
                        }).then((result) => {
                            $('button[type=submit]').removeAttr('disabled');
                        });    
                    }
                    if( response.error.code == "invalid_cvc"){
                        Swal.fire({
                        type:"warning",
                        text:"Mã bảo mật của thẻ của bạn không hợp lệ!"
                        }).then((result) => {
                            $('button[type=submit]').removeAttr('disabled');
                        });    
                    }
                    

                    $(".ajax_waiting").removeClass("loading");
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
</script>

@endsection
