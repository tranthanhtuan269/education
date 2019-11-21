@extends('frontends.layouts.app')
@section('title','PROCEED CHECKOUT')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<div class="top-checkout">
    <div class='row'>
        <img class="bg-checkout" src="{{ asset('frontend/images/banner_checkout.png') }}" width="100%">
        <div class="container fixed-title">
            <div class="highlight">
                <div class="col-sm-4">
                    <div class="row title">
                        <img src="{{ asset('frontend/images/ic_checkout.png') }}" alt="">
                        <h1>PROCEED CHECKOUT</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="body-checkout">
    <div class="row">
        <div class="container">
            <h2>Chọn hình thức thanh toán</h2>
            
            <div class="row">
                <div class="col-md-9">
                    <div class="payment-method">
                        @if(false)
                        <div class="momo">
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">Default radio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">Second default radio</label>
                            </div> --}}
                            <div class="header form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">Thanh toán bằng ví MoMo <a href="#" class="view-more">Xem chi tiết</a></label>
                                {{-- <input type="radio" name="otpradio" id="" checked id="myCheck">
                                <label class="form-check-label label-title" onclick="myCheck()">Thanh toán bằng ví MoMo <a href="#" class="view-more">Xem chi tiết</a></label> --}}
                            </div>
                        </div>
                        <hr>
                        <div class="bank-transfer">
                            <div class="header form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">Thẻ ATM nội địa/Internet Banking (Miễn phí giao dịch)</label>
                                {{-- <input type="radio" name="otpradio" id="">
                                <span class="label-title">Thẻ ATM nội địa/Internet Banking (Miễn phí giao dịch)</span> --}}
                            </div>
                            <div class="choose-bank">
                                <div class="row">
                                    {{-- <ul> --}}
                                        @for( $i=1 ; $i<=33 ; $i++)
                                        {{-- <li class="active"> --}}
                                            <div class="col-md-2">
                                                <div class="box-img">
                                                    <img class="img-bank" id="bank{{$i}}" src="/frontend/images/banks/bank_{{$i}}.jpg" alt="bank_{{$i}}" width="100%" height="auto">
                                                </div>
                                            </div>
                                        {{-- </li> --}}
                                        @endfor
                                    {{-- </ul> --}}
                                    {{-- <div class="col-md-2">
                                        <img src="/frontend/images/banks/bank_1.jpg" alt="bank_1" width="100%">
                                        <div></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <hr>
                        @endif
                        <div class="international-card">
                            <div class="card-info">
                                <div class="header form-check">
                                    @if(false)<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">@endif
                                    <label class="form-check-label" for="exampleRadios3">Thanh toán bằng thẻ quốc tế VISA, MASTERCARD, JCB</label>
                                    {{-- <input type="radio" name="otpradio" id="">
                                    <span class="label-title">Thanh toán bằng thẻ quốc tế VISA, MASTERCARD, JCB</span> --}}
                                </div>
                                <!-- <div class="block">
                                    <ul class="card-type">
                                        <li>
                                            <span class="label-card">Nhập số thẻ:</span>
                                        </li>
                                        <li>
                                            <img class="" src="/frontend/images/banks/ic_visa.png" alt="VISA" title="VISA">
                                        </li>
                                        <li>
                                            <img class="" src="/frontend/images/banks/ic_master.png" alt="mastercard" title="mastercard">
                                        </li>
                                        <li>
                                            <img class="" src="/frontend/images/banks/ic_jcb.png" alt="JCB" title="JCB">
                                        </li>
                                    </ul>
                                </div> -->

                             
                                <div class="row" id="pay-stripe" >
                                    <div class="col-md-11">
                                        <div class="panel panel-default credit-card-box">
                                            <div class="panel-heading display-table" >
                                                <div class="row display-tr" >
                                                    <h3 class="panel-title display-td" >Nhập số thẻ:</h3>
                                                    <div class="display-td" >                            
                                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                                    </div>
                                                </div>                    
                                            </div>
                                            <div class="panel-body">
                            
                                                @if (Session::has('success'))
                                                    <script>
                                                        Swal.fire({
                                                        type: 'success',
                                                        text: "Mua khóa học thành công!"
                                                        }).then( result => {
                                                            document.location.href = '/';
                                                        })
                                                    </script>
                                                @endif
                                               
                                                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                                                                                data-cc-on-file="false"
                                                                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                                                id="payment-form">
                                                    @csrf
                            
                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 form-group required'>
                                                            <label class='control-label'>Tên in trên thẻ:</label> <input
                                                                class='form-control' name='card_name' size='4' type='text' 
                                                                value='{{  is_object($info_payment) ? $info_payment->card_name : "" }}' disabled>
                                                        </div>
                                                    </div>
                          
                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 form-group card required'>
                                                            <label class='control-label'>Số thẻ:</label> <input
                                                                autocomplete='off' name='card_number' class='form-control card-number' size='20'
                                                                type='text' value='{{ is_object($info_payment) ? $info_payment->card_number : "" }}' disabled>
                                                        </div>
                                                    </div>
                            
                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                            <label class='control-label'>CVC:</label> <input autocomplete='off'
                                                                name='card_cvc' class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                                type='text' 
                                                                value='{{ is_object($info_payment) ? $info_payment->card_cvc : "" }}' disabled>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                            <label class='control-label'>Tháng hết hạn:</label> <input
                                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                                name='card_expiry_month' type='text' 
                                                                value='{{ is_object($info_payment) ? $info_payment->card_expiry_month : "" }}' disabled>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                            <label class='control-label'>Năm hết hạn:</label> <input
                                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                                name='card_expiry_year' type='text' 
                                                                value='{{ is_object($info_payment) ? $info_payment->card_expiry_year : ""}}' disabled>
                                                        </div>
                                                    </div>
                            
                                                    <!-- <div class='form-row row'>
                                                        <div class='col-md-12 error form-group hide'>
                                                            <div class='alert-danger alert'>Please correct the errors and try
                                                                again.</div>
                                                        </div>
                                                    </div> -->
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <button class="btn btn-primary btn-lg btn-block" type="submit" id="stripeSubmit" disabled>Thanh toán (<span id='price-pay-now'></span>)</button>
                                                            <input type="hidden" name="product_stripe">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="blockform-check">
                                                        <input class="form-check-input" type="checkbox" value="1" name="default_check" @if (is_object($info_payment)) checked @endif disabled>
                                                        <label class="form-check-label" for="defaultCheck1" >Lưu và bảo mật cho lần thanh toán sau</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                            </div>
                            <div class="img-card">
                                <img src="/frontend/images/banks/ic_card_demo.png" alt="ATM card" title="ATM card" id="atm-card">
                                <div class="row">
                                    <div class="col-xs-6 flex">
                                        <img class="red-dot" src="/frontend/images/banks/red_dot_1.png" alt=""><span>Số thẻ</span>
                                    </div>
                                    <div class="col-xs-6 flex">
                                        <img class="red-dot" src="/frontend/images/banks/red_dot_2.png" alt=""><span>Ngày hết hạn</span>
                                    </div>
                                    <div class="col-xs-6 flex">
                                        <img class="red-dot" src="/frontend/images/banks/red_dot_3.png" alt=""><span>Tên in trên thẻ</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">Vui lòng kiểm tra tin nhắn nếu có yêu cầu</div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="order" id="sidebar-content">
                        <div class="title text-center">
                            <h3>ĐƠN HÀNG</h3>
                        </div>
                        <div class="list-course-order">


                        </div>
                        <div class="text-center box-price">
                            <p>Thành tiền:</p>
                            <div class="total-price">
                                
                            </div>
                            <p>(Đã bao gồm VAT)</p>
                        </div>
                        {{-- <div class="checkout text-center">
                            <button class="btn btn-warning"><b>THANH TOÁN</b></button>
                        </div> --}}
                    </div>
                </div>
                @if (!\App\Helper::isMobile())
                    <script>
                        $(window).scroll(function() {
                            var block_on = $('.body-checkout .container .row').position().top - 10 //Padding
                            var block_below = $('footer').position().top - $('#sidebar-content').height() - 30 - 62 //Padding
                            if ($(window).scrollTop() >= block_on) {
                                if($(window).scrollTop() <= block_below - 80){
                                    document.getElementById("sidebar-content").classList.add("sidebar-fixed");
                                    $("#sidebar-content").removeClass('sidebar-unfix').css('top', '');
                                }else{
                                    document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                                    $("#sidebar-content").addClass('sidebar-unfix').css('top', block_below - block_on + 20);
                                }
                            } else {
                                document.getElementById("sidebar-content").classList.remove("sidebar-fixed");
                            }
                        });
                    </script>
                    <style>
                    .body-checkout  .sidebar-fixed {
                        position: fixed;
                        top: 115px;
                        width: 277.5px;
                    }
                    .body-checkout .sidebar-unfix {
                        position: absolute;
                        width: 277.5px;
                    }
                    </style>
                @endif
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .panel-title {
    display: inline;
    font-weight: bold;
    }
    .display-table {
        display: table;
    }
    .display-tr {
        display: table-row;
    }
    .display-td {
        display: table-cell;
        vertical-align: middle;
        width: 61%;
    }
</style>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
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

    $('#exampleRadios3').click(function(){
        $("input[type=text]").removeAttr('disabled');
        $('button[type=submit]').removeAttr('disabled');
        $('input[type=checkbox]').removeAttr('disabled');        
    });
    $('#exampleRadios2').click(function(){
        $("input[type=text]").prop('disabled', true);
        $('button[type=submit]').prop('disabled', true);
        $('input[type=checkbox]').prop('disabled', true);  
    });
    $('#exampleRadios1').click(function(){
        $("input[type=text]").prop('disabled', true);
        $('button[type=submit]').prop('disabled', true);
        $('input[type=checkbox]').prop('disabled', true);  
    });

    var user_id = $('button[id=cartUserId]').attr('data-user-id')
    var cart_items = JSON.parse(localStorage.getItem('cart'+user_id))
    $('input[name=product_stripe]').val(localStorage.getItem('cart'+user_id));
    var total_price = 0
    $(document).ready( function () {
        showItems()
        function showItems(){
            cart_items.forEach((element, index) => {
                // var selling_price = element.price
                
                // coupon_code_array[index] = element.coupon_code
                // course_id_array[index] = element.id
                // console.log(coupon_code_array)
                // var selling_price = element.coupon_price
                // if(element.real_price == null){
                //     selling_price = element.real_price
                // }
                html = ''
                html += '<div class="item-box">'
                    html += '<div class="info">'
                        html += '<div class="title">'
                            html += element.name
                        html += '</div>'
                        html += '<div class="author pull-left">'
                            html += element.lecturer
                        html += '</div>'
                        html += '<div class="price pull-right">'+number_format(element.coupon_price, 0, '.', '.')+' ₫</div>'
                    html += '</div>'
                html += '</div>'
                html += '<div class="clearfix"></div>'
                html += '<hr>'

                $(".list-course-order").append(html)
                total_price += element.coupon_price
            })
            $(".total-price").append(number_format(total_price, 0, '.', '.')+' ₫')
            $("#price-pay-now").append(total_price/20000 +' usd')
        }

        $('.img-bank').on('click', function(e){
            e.stopPropagation()
            e.preventDefault()
            // alert(1)
            $('.img-bank').css('border', '1px dashed #c1c1c1')
            $(this).css('border', 'none')
            $('.img-bank').parent().css('margin','10px 1px')
            $(this).parent().css('margin','9px 0px')
            $('.img-bank').parent().removeClass("active")
            $(this).parent().addClass("active")
            $('.ic-check-bank').remove()
            var html = ''
            html += '<div class="ic-check-bank">'
                html += '<img src="/frontend/images/banks/ic_check_bank.png">'
            html += '</div>'
            $(this).parent().append(html)
        })
        // $('.img-bank').hover(function(){
        //     $(this).css('border', '1px dashed #007ff0')
        // }, function(){
        //     $(this).css('border', '1px dashed #c1c1c1');
        // })
    })

    function myCheck(){
        // alert(1)

    }
</script>
@endsection