@extends('frontends.layouts.app')
@section('title')
Giỏ hàng của tôi
@stop
@section('content')
<div class="cart-banner">
    <div class="container">
        {{-- <div class="col-sm-offset-1">
            <img src="/frontend/images/ic_cart.png" alt="image cart" style="width: 6em !important;">
        </div> --}}
        <div class="cart-banner-title">
            <div class="box-cart-title">
                <i class="fas fa-shopping-cart fa-fw fa-3x"></i>
                <h1>Giỏ hàng<br>của tôi</h1>
            </div>
        </div>
    </div>
</div>
<div class="cart-page-body">
    <div class="cart-page-content container">        
        <div class="row">
            <div class="col-xs-12">
                <div class="cart-page-title container">
                    <p>BẠN CÓ <span class="course-amount"></span> KHOÁ HỌC TRONG GIỎ HÀNG</p>
                </div>
            </div>
            <div class="cart-item-list col-md-9 col-xs-12">
                
            </div>
            <div class="checkout-column col-md-3 col-xs-12">
                <div>
                    <div class="price-group">
                        <div class="text-total">
                            TỔNG
                        </div>
                        <div class="current-price">
                            
                        </div>
                        <div class="initial-price">

                        </div>
                        <div class="percent-off">
                            
                        </div>
                        <div class="btn-checkout">
                            @if(Auth::check())
                            <a href="/cart/payment/method-selector">
                                <button id="btnCartCheckOut"  class="btn btnCartCheckout">THANH TOÁN</button>
                            </a>
                            @else
                            <button class="btn btnCartCheckout" data-toggle=modal data-target=#myModalLogin data-dismiss=modal >THANH TOÁN</button>
                            @endif
                        </div>
                        <div class="" style="margin-top: 0.5em;">
                            <a href="/list-course?type=best-seller" class="btn btn-info" style="padding: 0.5em 1em; font-size:larger;"><span><i class="fa fa-plus"></i> THÊM KHOÁ HỌC</span></a>
                        </div>
                    </div>
                    {{-- <div class="coupon-code-input">
                        <div class="input-group">
                            <input type="text" id="input-coupon" class="form-control" placeholder="Nhập mã giảm giá" aria-describedby="btnCartCouponApply">
                            <span class="input-group-addon" id="btnCartCouponApply"><b>Áp dụng</b></span>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div><br>
        
    </div>
    <div class="cart-page-empty">
        <div class="container text-center">
            <img src="/frontend/images/tab_cart.png" alt="" style="width: 135px;">
            <div>
                Giỏ hàng trống. Hãy xem thêm các khóa học khác!
            </div>
            <div>
                <a href="/">
                    <button class="btn">Xem thêm khóa học</button>
                </a>
            </div>   
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var user_id = $('button[id=cartUserId]').attr('data-user-id')
        var cart_items = JSON.parse(localStorage.getItem('cart'+user_id))
        var totalPrice = 0
        var totalInitialPrice = 0
        var activeCoupon = ''
        
        if(cart_items.length < 1){
            $(".cart-page-empty").addClass('active')
            $('.cart-page-title.container').hide()
        }else{
            $(".cart-page-content").addClass('active')
        }
        // console.log(cart_items)
        $(".cart-page-title .course-amount").append(`(${cart_items.length})`)
        cart_items.forEach((element, index) => {
            
            html = '';
            html += '<div class="cart-single-item" data-parent="'+element.id+'" data-index="'+index+'">'
                html += '<div class="image">'
                if(element.image.indexOf('unica') !== -1){
                    html += '<a href="/course/'+element.id+'/'+element.slug+'"><img src="'+element.image+'" width="250rem" alt=""></a>'
                }else{
                    html += '<a href="/course/'+element.id+'/'+element.slug+'"><img src="/frontend/images/'+element.image+'" width="250rem" alt=""></a>'
                }
                html += '</div>'
                html += '<div class="course-info">'

                    html += '<a href="/course/'+element.id+'/'+element.slug+'"><div class="course-name">'+element.name+'</div></a>'
                    html += '<div class="lecturer-info">'+element.lecturer+'</div>'
                    html += '<div class="coupon">'
                        // html += '<div class="coupon-code-label"><b>Mã giảm giá:<b></div>'
                        html += '<div class="coupon-input-field">'
                            html += '<div>'
                                html += '<input placeholder="Mã giảm giá" type="text" class="form-control coupon-input" data-id="'+element.id+'" value="'+element.coupon_code+'">'
                            html += '</div>'
                            html += '<div>'
                                html += '<button class="btn coupon-button" data-child="'+element.id+'" data-price="'+element.price+'" data-index="'+index+'">ÁP DỤNG</button>'
                            html += '</div>'
                        html += '</div>'
                    html +='</div>'
                html += '</div>'
                
                html += '<div class="single-price">'
                    
                        html += '<div class="price-tag">'
                        if(element.coupon_price == element.real_price){
                            html += '<div class="current-price" id="current_price'+element.id+'">'+number_format(element.coupon_price, 0, '.', '.')+' ₫ </div>'
                            html += '<div class="initial-price" id="initial_price'+element.id+'" style="display:none">'+number_format(element.real_price, 0, '.', '.')+' ₫ </div>'
                        }else{
                            html += '<div class="current-price" id="current_price'+element.id+'">'+number_format(element.coupon_price, 0, '.', '.')+' ₫ </div>'
                            html += '<div class="initial-price" id="initial_price'+element.id+'">'+number_format(element.real_price, 0, '.', '.')+' ₫ </div>'
                        }
                        html += '</div>'
                        // html += '<i class="fas fa-tag"></i>'
                        html += '<div class="actions">'
                            html += '<div class="btn-remove" style="cursor: pointer;" ><img width="30" src="/frontend/images/ic_delete.png" data-child="'+element.id+'"/></div>'
                        html +='</div>'
                    
                html += '</div>'
            html += '</div>'
            $(".cart-item-list").append(html)

            // totalPrice += element.coupon_price
            // totalInitialPrice += element.real_price
        });

        cart_items.forEach((element)=>{
            totalPrice += element.coupon_price
            totalInitialPrice += element.real_price
        })

        if(totalPrice == totalInitialPrice){
            $(".checkout-column .current-price").append("<span>"+number_format(totalPrice, 0, '.', '.')+" ₫</span>")
        }else{
            $(".checkout-column .current-price").append("<span>"+number_format(totalPrice, 0, '.', '.')+" ₫</span>")
            $(".checkout-column .initial-price").append("<span>"+number_format(totalInitialPrice, 0, '.', '.')+" ₫</span>")
            if(totalInitialPrice != 0){
                $(".checkout-column .percent-off").append("<span>Tiết kiệm "+Math.floor(100-(totalPrice/totalInitialPrice)*100)+"%</span>")
            }
        }


        $('.coupon-code').on('click', function(e){
            e.stopPropagation()
            e.preventDefault()
        });
        $('.coupon-input').on('click', function(e){
            e.stopPropagation()
            e.preventDefault()
        });
        // $('.coupon-button').on('click', function(e){
        //     e.stopPropagation()
        //     e.preventDefault()
        // });
        
        $('.btn-remove img').on('click', function(e){
            // e.stopPropagation()
            // e.preventDefault()
            var dataChild = $(this).attr("data-child")
            Swal.fire({
                type: "warning",
                text: "Bạn có muốn xóa khóa học khỏi giỏ hàng không?",
                showCancelButton: true,
            }).then( (result) =>{
                if(result.value){
                    var cartSingleItem = $(".cart-single-item[data-parent="+dataChild+"]")
                    cartSingleItem.fadeOut("normal", function () {
                        // your other code
                        $(this).trigger('myFadeOutEvent');
                        cartSingleItem.remove();
                    });    
                    $.each($('.cart-single-item'), function(index, value){ $(value).attr('data-index', index)})

                    cart_items = JSON.parse(localStorage.getItem('cart'+user_id))
                    cart_items.splice(cartSingleItem.attr("data-index"), 1)
                    
                    totalPrice = 0
                    totalInitialPrice = 0

                    cart_items.forEach((element)=>{
                        totalPrice += element.coupon_price
                        totalInitialPrice += element.real_price
                    })
                   
                    $(".checkout-column .current-price span").remove()
                    $(".checkout-column .current-price").append("<span>"+number_format(totalPrice, 0, '.', '.')+" ₫</span>")
                    $(".checkout-column .initial-price span").remove()
                    $(".checkout-column .initial-price").append("<span>"+number_format(totalInitialPrice, 0, '.', '.')+" ₫</span>")
                    $(".checkout-column .percent-off span").remove()
                    if(cart_items.length == 0){
                        // $(".checkout-column .percent-off").append("<span>0% off</span>")
                    }else{
                        $(".checkout-column .percent-off").append("<span>Tiết kiệm "+Math.floor(100-(totalPrice/totalInitialPrice)*100)+"%</span>")
                    }
                    $(".cart-page-title .course-amount").html("")
                    $(".cart-page-title .course-amount").prepend(`(${cart_items.length})`)
                    $('.number-in-cart').text(cart_items.length);

                    localStorage.setItem('cart'+user_id, JSON.stringify(cart_items))
                    if(totalPrice == totalInitialPrice){
                        $('.price-group .initial-price').css('display', 'none')
                        $('.price-group .percent-off').css('display', 'none')
                    }else{
                        $('.price-group .percent-off').css('display', 'block')
                        $('.price-group .initial-price').css('display', 'block')
                    }
                    if(cart_items.length < 1){
                        $('.unica-sl-cart').css('display', 'none' )
                    }else{
                        $('.unica-sl-cart').css('display', 'block' )
                    }

                    if(cart_items.length == 0){
                        // location.reload();
                        $(".cart-page-content").hide()
                        $('.cart-page-title.container').hide()

                        $(".cart-page-empty").show()
                    }else{
                        $('.cart-page-title.container').show()
                    }
                    location.reload()
                }
            })
        })

        // $('#btnCartCouponApply').on('click', function(e){
        //     e.stopPropagation()
        //     e.preventDefault()
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     var coupon = $('#input-coupon').val();
        //     if(coupon.length < 1){
        //         return Swal.fire({
        //             type:"warning",
        //             text:"Chưa có mã khuyến mại!"
        //         })
        //     }else{
        //         var request = $.ajax({
        //             url : "/check-coupon",
        //             method: "GET",
        //             data :{
        //                 "coupon" : coupon
        //             },
        //             dataType: "json",                
        //         })

        //         request.done((response)=>{
        //             console.log(response)
        //             if(response.status == 200){
        //                 localStorage.setItem('coupon', coupon)
        //                 return Swal.fire({
        //                     type:"success",
        //                     text:"The coupon exists!"
        //                 })
        //             }else{
        //                 localStorage.removeItem('coupon')
        //                 $('#input-coupon').val('')
        //                 return Swal.fire({
        //                     type:"warning",
        //                     text:"Mã khuyến mãi không tồn tại!"
        //                 })
        //             }
        //         })
        //     }
        // });
        $('.coupon-button').off()
        $('.coupon-button').on('click', function(e){
            e.stopPropagation()
            e.preventDefault()
            var dataChild = $(this).attr("data-child")
            var dataPrice = $(this).attr("data-price")
            var new_totalPrice = 0;
            var numeric_cart = $(this).attr("data-index")
            var course_id = dataChild
            var cart_items = JSON.parse(localStorage.getItem('cart'+user_id))

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var coupon = $(".cart-single-item[data-parent="+dataChild+"] input").val().trim();

            var new_cart = cart_items

            new_cart.forEach((element, index) => {
                if( element.id == course_id ){
                    get_coupon = element.coupon_code
                }
            })

            if(coupon.length < 1){
                return Swal.fire({
                    type:"warning",
                    text:"Bạn chưa nhập mã giảm giá !"
                })
            }
            else{
                if( get_coupon == coupon ){
                    return Swal.fire({
                        type:"warning",
                        text:"Mã giảm giá đã được áp dụng !"
                    })
                }
                else{
                    var request = $.ajax({
                        url : "/check-coupon",
                        method: "GET",
                        data :{
                            "course_id" : dataChild,
                            "coupon" : coupon
                        },
                        dataType: "json",                
                    })

                    request.done((response)=>{
                        // console.log(response)
                        if(response.status == 200){
                            // localStorage.setItem('coupon', coupon)
                            if(response.coupon_value != 0){
                                new_price = dataPrice*(100-response.coupon_value)/100
                            }
                            // new_totalPrice = totalPrice - dataPrice + new_price
                            Swal.fire({
                                type:"success",
                                text:"Áp dụng mã khuyến mãi thành công!"
                            })
                        }
                        if(response.status == 404){
                            localStorage.removeItem('coupon')
                            $('#input-coupon').val('')
                            return Swal.fire({
                                type:"warning",
                                text:"Mã khuyến mãi không tồn tại!"
                            })
                        }
                        if(response.status == 403){
                            return Swal.fire({
                                type:"warning",
                                text:"Mã khuyến đã hết hạn sử dụng!"
                            })
                        }
                        // totalPrice = new_totalPrice
                        // Insert into localStorage
                        new_cart.forEach((element, index) => {
                            if( element.id == course_id ){
                                element.coupon_price = new_price   
                                element.coupon_code  = coupon
                            }
                        })

                        localStorage.setItem('cart'+user_id, JSON.stringify(new_cart))
                        
                        $("#initial_price"+dataChild).css('display','block')
                        $("#current_price"+dataChild).text('')
                        $("#current_price"+dataChild).append(number_format(new_price, 0, '.', '.')+' ₫')

                        var course_count = 1;
                        new_totalPrice=0
                        new_totalInitialPrice=0
                        // new_totalPrice = new_price
                        cart_items.forEach((element)=>{
                            // new_totalPrice += parseFloat($('#current_price'+element.id).text())*1000
                            new_totalPrice += element.coupon_price
                            new_totalInitialPrice += element.real_price
                        })

                        // new_totalPrice = new_totalPrice - dataPrice + new_price
                        // alert(new_totalPrice)

                        if(new_totalPrice == totalInitialPrice){
                            $(".checkout-column .current-price span").remove()
                            $(".checkout-column .current-price").append("<span>"+number_format(new_totalPrice, 0, '.', '.')+" ₫</span>")
                        }else{
                            $(".checkout-column .current-price span").remove()
                            $(".checkout-column .current-price").append("<span>"+number_format(new_totalPrice, 0, '.', '.')+" ₫</span>")
                            $(".checkout-column .initial-price span").remove()
                            $(".checkout-column .initial-price").append("<span>"+number_format(new_totalInitialPrice, 0, '.', '.')+" ₫</span>")
                            $(".checkout-column .percent-off span").remove()
                            $(".checkout-column .percent-off").append("<span> Tiết kiệm "+Math.floor(100-(new_totalPrice/new_totalInitialPrice)*100)+"%</span>")
                        }
                    })
                }
            }
        });

        $('#btnCartCheckOut').on('click', function(e){
        });

        function checkout() {
            var coupon = $('#input-coupon').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(cart_items.length < 1){
                return Swal.fire({
                    type:"warning",
                    text:"Giỏ hàng đang trống!"
                })
            }else{
                var request = $.ajax({
                    url : "/checkout",
                    method: "POST",
                    data :{
                        "items" : cart_items,
                        "coupon" : coupon
                    },
                    dataType: "json",                
                })

                request.done((response)=>{
                    console.log(response)
                    if(response.status == 201){
                        // remove cart in localstorage
                        cart_items = [];
                        localStorage.setItem('cart'+user_id, JSON.stringify(cart_items))
                        
                        return Swal.fire({
                            type:"success",
                            text:"Mua khóa học không thành công!"
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }else if(response.status == 204){
                        return Swal.fire({
                            type:"warning",
                            text:"Tài khoản của bạn không đủ để thực hiện giao dịch!"
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "/member-card";
                            }
                        });
                    }else{
                        return Swal.fire({
                            type:"warning",
                            text:"Mua khóa học không thành công!"
                        })
                    }
                })
            }
        }

        // Vertical center Cart empty
        $('.cart-page-empty').css('margin-top', (document.body.scrollHeight - $('header').height() - $('footer').height() - $('.cart-banner').height() - $('.cart-page-empty').height())/2)
    })
    
</script>

@include('frontends.feature-courses')

@endsection