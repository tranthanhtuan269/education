@extends('frontends.layouts.app')
@section('content')
<div class="cart-page-body background-page">
    <div class="cart-page-title container">
        {{-- <img src="http://courdemy.local/frontend/images/tab_cart.png" alt="" style="width: auto;"> --}}
        <div class="cart-pre-info">
            <div class="cart-pre-info-left">
                <div>
                    <h2><i><span class="course-amount"></span> courses in cart</i></h2>
                </div>
            </div>
        </div>
        <div class="blue-half-square" style=""></div>
    </div>
    <div class="cart-page-content container">
        
        <div class="row">
            <div class="cart-item-list col-md-9">
                {{-- @for ($i = 0; $i < 4; $i++)
                <div class="cart-single-item">
                    <div class="image">
                        <img src="frontend/images/course_6.jpg" width="130rem" alt="">
                    </div>
                    <div class="course-info">
                        <div class="course-name">Learn Canva from an Expert Designer: Let's Create a Brand!</div>
                        <div class="lecturer-info">By Lindsay Marsh, 14+ Years | Graphic Design:Photoshop, Illustrator, Canva, XD</div>
                    </div>
                    <div class="actions">
                        <div class="btn-remove"><i class="far fa-trash-alt"></i></div>
                    </div>
                    <div class="single-price">
                        <div>
                            <div>
                                <div class="current-price">120 000 ₫</div>
                                <div class="initial-price">199.99 ₫</div>
                            </div>
                            <i class="fas fa-tag"></i>
                        </div>
                    </div>
                </div>
                    
                @endfor --}}
                    
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
                            <button id="btnCartCheckOut" class="btn btn-danger">Checkout</button>
                        </div>
                    </div>
                    <div class="coupon-code-input">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Apply coupon code" aria-describedby="btnCartCouponApply">
                            <span class="input-group-addon" id="btnCartCouponApply">APPLY</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var cart_items = JSON.parse(localStorage.getItem('cart'))
    var totalPrice = 0
    var totalInitialPrice = 0
    
    $(document).ready(function(){
        $(".cart-pre-info .course-amount").prepend(cart_items.length)
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

            $(".cart-item-list").prepend(html)

            totalPrice += element.price
            totalInitialPrice += element.real_price
        });

        $(".checkout-column .current-price").append("<span>"+number_format(totalPrice, 0, '.', '.')+" ₫</span>")
        $(".checkout-column .initial-price").append("<span>"+number_format(totalInitialPrice, 0, '.', '.')+" ₫</span>")
        
        $(".checkout-column .percent-off").append("<span>"+Math.floor(100-(totalPrice/totalInitialPrice)*100)+"% off</span>")

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
                    cartSingleItem.fadeOut()
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


                    localStorage.setItem('cart', JSON.stringify(cart_items))
                    console.log(cart_items)
                    $('.number-in-cart').text(cart_items.length);
                    
                }
            })
            
        })

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        // if(cart_items.length < 1){
        //     return Swal.fire({
        //         type:"warning",
        //         text:"You can not checkout an empty shopping cart!"
        //     })
        // }else{
        //     var course_id_array = []
        //     cart_items.forEach((element, index) =>{
        //         course_id_array.push(element.id)
        //     })
        //     var request = $.ajax({
        //         url : "",
        //         method: "POST",
        //         data :{
        //             "course_id_array" : course_id_array,
        //         },
        //         dataType: "json",                
        //     })

        //     request.done((response)=>{
        //         console.log(response)
                
        //     })
        // }
    })
    
    
</script>

@include('frontends.feature-courses')

@endsection