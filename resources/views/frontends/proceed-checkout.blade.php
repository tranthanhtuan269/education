@extends('frontends.layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<div class="top-checkout">
    <div class='row'>
        <img class="bg-checkout" src="{{ asset('frontend/images/banner_checkout.png') }}" width="100%">
        <div class="container">
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
                        <div class="international-card">
                            <div class="card-info">
                                <div class="header form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                                    <label class="form-check-label" for="exampleRadios3">Thanh toán bằng thẻ quốc tế VISA, MASTERCARD, JCB</label>
                                    {{-- <input type="radio" name="otpradio" id="">
                                    <span class="label-title">Thanh toán bằng thẻ quốc tế VISA, MASTERCARD, JCB</span> --}}
                                </div>
                                <div class="block">
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
                                </div>
                                <div class="block">
                                    <div class="label-text">Số thẻ:</div>
                                    <input type="text" class="form-control" id="card-number" placeholder="VD: 1234 5678 9101 1221">
                                </div>
                                <div class="block">
                                    <div class="label-text">Tên in trên thẻ:</div>
                                    <input type="text" class="form-control" id="name" placeholder="VD: NGUYEN TUNG DUONG">
                                </div>
                                <div class="block">
                                    <div class="row">
                                        <div class="col-xs-4 exp">
                                            <div class="label-text">Ngày hết hạn:</div>
                                            <input type="text" id="datepicker" class="form-control">
                                            <script>
                                                $(function() {
                                                    $( "#datepicker" ).datepicker({
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            yearRange: "2019:2050",
                                                            dateFormat: 'dd/mm/yy',
                                                            minDate: new Date(),
                                                        }	
                                                    );
                                                });
                                            </script>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="label-text">Mã bảo mật:</div>
                                            <div class="secure-code">
                                                <input type="text" class="form-control">
                                                <img src="/frontend/images/banks/ic_ccv.png" alt="ic_ccv" title="ic_ccv">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="blockform-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">Lưu và bảo mật cho lần thanh toán sau</label>
                                </div>
                            </div>
                            <div class="img-card">
                                <img src="/frontend/images/banks/ic_card_demo.png" alt="ATM card" title="ATM card" id="atm-card">
                                <div class="row">
                                    <div class="col-xs-6 flex">
                                        <img class="red-dot" src="/frontend/images/banks/red_dot_1.png" alt=""><span>Số thẻ</span>
                                    </div>
                                    <div class="col-xs-6 flex">
                                        <img class="red-dot" src="/frontend/images/banks/red_dot_2.png" alt=""><span>Tên in trên thẻ</span>
                                    </div>
                                    <div class="col-xs-6 flex">
                                        <img class="red-dot" src="/frontend/images/banks/red_dot_3.png" alt=""><span>Ngày hết hạn</span>
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
                    <div class="order">
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
                        <div class="checkout text-center">
                            <button class="btn btn-warning"><b>THANH TOÁN</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var cart_items = JSON.parse(localStorage.getItem('cart'))
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