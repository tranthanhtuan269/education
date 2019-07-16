@extends('frontends.layouts.app')
@section('content')
<div class="cart-page-body background-page">
    <div class="cart-page-title container">
        {{-- <img src="http://courdemy.local/frontend/images/tab_cart.png" alt="" style="width: auto;"> --}}
        <div class="cart-pre-info">
            <div class="cart-pre-info-left">
                <div>
                    <h2><i><span class="course-amount"></span> khóa học trong giỏ hàng</i></h2>
                </div>
            </div>
        </div>
        <div class="blue-half-square" style=""></div>
    </div>
    <div class="cart-page-content container">
        
        <div class="row">
            <div class="cart-item-list col-md-9">             
            </div>
            <div class="checkout-column col-md-3">
                <div>
                    <div class="price-group">
                        
                        <div class="current-price">
                            
                        </div>
                        <div class="initial-price">

                        </div>
                        <div class="percent-off">
                            
                        </div>
                        <div class="btn-checkout">
                            @if(Auth::check())
                            <a href="/cart/payment/method-selector">
                                <button id="btnCartCheckOut"  class="btn btn-danger btnCartCheckout">Thanh toán</button>
                            </a>
                            @else
                            <button class="btn btn-danger btnCartCheckout" data-toggle=modal data-target=#myModalLogin data-dismiss=modal >Thanh toán</button>
                            @endif
                        </div>
                    </div>
                    <div class="coupon-code-input">
                        <div class="input-group">
                            <input type="text" id="input-coupon" class="form-control" placeholder="Nhập mã giảm giá" aria-describedby="btnCartCouponApply">
                            <span class="input-group-addon" id="btnCartCouponApply"><b>Áp dụng</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-page-empty">
        <div class="container text-center">
            <img src="/frontend/images/tab_cart.png" alt="" style="width: 10vw;">
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
    var cart_items = JSON.parse(localStorage.getItem('cart'))
    var totalPrice = 0
    var totalInitialPrice = 0
    var activeCoupon = ''
    
    $(document).ready(function(){
        if(cart_items.length < 1){
            $(".cart-page-empty").addClass('active')
        }else{
            $(".cart-page-content").addClass('active')
        }
        
        $(".cart-pre-info .course-amount").append(cart_items.length)
        cart_items.forEach((element, index) => {
            
            html = '';
            html += '<a href="/course/'+element.slug+'"><div class="cart-single-item" data-parent="'+element.id+'" data-index="'+index+'">'
                html += '<div class="image">'
                    html += '<img src="/frontend/images/'+element.image+'" width="130rem" alt="">'
                html += '</div>'
                html += '<div class="course-info">'

                    html += '<div class="course-name">'+element.name+'</div>'
                    html += '<div class="lecturer-info">By '+element.lecturer+'</div>'
                html += '</div>'
                html += '<div class="actions">'
                    html += '<div class="btn-remove"><i class="far fa-trash-alt" data-child="'+element.id+'"></i></div>'
                html +='</div>'
                html += '<div class="single-price">'
                    html += '<div>'
                        html += '<div>'
                            html += '<div class="current-price">'+number_format(element.price, 0, '.', '.')+' ₫</div>'
                            html += '<div class="initial-price">'+number_format(element.real_price, 0, '.', '.')+' ₫</div>'
                        html += '</div>'
                        // html += '<i class="fas fa-tag"></i>'
                    html += '</div>'
                html += '</div>'
            html += '</div></a>'

            $(".cart-item-list").append(html)

            totalPrice += element.price
            totalInitialPrice += element.real_price
        });

        $(".checkout-column .current-price").append("<span>"+number_format(totalPrice, 0, '.', '.')+" ₫</span>")
        $(".checkout-column .initial-price").append("<span>"+number_format(totalInitialPrice, 0, '.', '.')+" ₫</span>")
        
        if(totalInitialPrice == 0){
            $(".checkout-column .percent-off").append("<span>0% off</span>")
        }else{
            $(".checkout-column .percent-off").append("<span>"+Math.floor(100-(totalPrice/totalInitialPrice)*100)+"% off</span>")
        }



        $('.btn-remove i').on('click', function(e){
            e.stopPropagation()
            e.preventDefault()
            var dataChild = $(this).attr("data-child")
            Swal.fire({
                type: "warning",
                text: "Do you want to remove this course from your cart?",
                showCancelButton: true,
            }).then( (result) =>{
                if(result.value){
                    var cartSingleItem = $(".cart-single-item[data-parent="+dataChild+"]")
                    cartSingleItem.fadeOut("normal", function () {
                        // your other code
                        $(this).trigger('myFadeOutEvent');
                        cartSingleItem.parent().remove();
                    });    
                    $.each($('.cart-single-item'), function(index, value){ $(value).attr('data-index', index)})
                    cart_items.splice(cartSingleItem.attr("data-index"), 1)
                    
                    totalPrice = 0
                    totalInitialPrice = 0

                    cart_items.forEach((element)=>{
                        totalPrice += element.price
                        totalInitialPrice += element.real_price
                    })
                   
                    $(".checkout-column .current-price span").remove()
                    $(".checkout-column .current-price").append("<span>"+number_format(totalPrice, 0, '.', '.')+" ₫</span>")
                    $(".checkout-column .initial-price span").remove()
                    $(".checkout-column .initial-price").append("<span>"+number_format(totalInitialPrice, 0, '.', '.')+" ₫</span>")
                    $(".checkout-column .percent-off span").remove()
                    if(cart_items.length == 0){
                        $(".checkout-column .percent-off").append("<span>0% off</span>")
                    }else{
                        $(".checkout-column .percent-off").append("<span>"+Math.floor(100-(totalPrice/totalInitialPrice)*100)+"% off</span>")
                    }
                    $(".cart-pre-info .course-amount").html("")
                    $(".cart-pre-info .course-amount").prepend(cart_items.length)
                    $('.number-in-cart').text(cart_items.length);

                    localStorage.setItem('cart', JSON.stringify(cart_items))                    
                }
            })
            
        })

        $('#btnCartCouponApply').on('click', function(e){
            e.stopPropagation()
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var coupon = $('#input-coupon').val();
            if(coupon.length < 1){
                return Swal.fire({
                    type:"warning",
                    text:"Coupon can't be empty!"
                })
            }else{
                var request = $.ajax({
                    url : "/check-coupon",
                    method: "GET",
                    data :{
                        "coupon" : coupon
                    },
                    dataType: "json",                
                })

                request.done((response)=>{
                    console.log(response)
                    if(response.status == 200){
                        localStorage.setItem('coupon', coupon)
                        return Swal.fire({
                            type:"success",
                            text:"The coupon exists!"
                        })
                    }else{
                        localStorage.removeItem('coupon')
                        $('#input-coupon').val('')
                        return Swal.fire({
                            type:"warning",
                            text:"The coupon doesn't exist!"
                        })
                    }
                })
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
                    text:"Cart can't be empty!"
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
                        localStorage.setItem('cart', JSON.stringify(cart_items))
                        
                        return Swal.fire({
                            type:"success",
                            text:"Order has been created!"
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }else if(response.status == 204){
                        return Swal.fire({
                            type:"warning",
                            text:"Your balance is not enough!"
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "/member-card";
                            }
                        });
                    }else{
                        return Swal.fire({
                            type:"warning",
                            text:"Order has not been created!"
                        })
                    }
                })
            }
        }
    })
    
    
</script>

@include('frontends.feature-courses')

@endsection