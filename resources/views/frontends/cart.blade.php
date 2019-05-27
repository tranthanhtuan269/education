@extends('frontends.layouts.app')
@section('content')
<div class="cart-page-body background-page">
    <div class="cart-page-title container">
        {{-- <img src="http://courdemy.local/frontend/images/tab_cart.png" alt="" style="width: auto;"> --}}
        <div class="cart-pre-info">
            <div class="cart-pre-info-left">
                <div>
                    <h2> Shopping cart</h2>
                </div>
                <h4>
                   <i>2 courses in cart</i> 
                </h4>
            </div>
        </div>
        <div class="blue-half-square" style=""></div>
    </div>
    <div class="cart-page-content container">
        
        <div class="row">
            <div class="cart-item-list col-md-9">
                @for ($i = 0; $i < 4; $i++)
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
                    
                @endfor
                    
            </div>
            <div class="checkout-column col-md-3">
                <div>
                    <div class="price-group">
                        
                        <div class="current-price">
                            <span>120 000 ₫</span>
                        </div>
                        <div class="initial-price">
                            <span>199.99 ₫</span> 
                        </div>
                        <div class="percent-off">
                            <span>50% off</span>
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
    $(document).ready(function(){
        cart_items.forEach(element => {
            html = '';
            html += '<div class="cart-single-item">'
                html += '<div class="image">'
                    html += '<img src="/frontend/images/'+element.image+'" width="130rem" alt="">'
                html += '</div>'
                html += '<div class="course-info">'
                    html += '<div class="course-name">'+element.name+'</div>'
                    html += '<div class="lecturer-info">By '+element.lecturer+'</div>'
                html += '</div>'
                html += '<div class="actions">'
                    html += '<div class="btn-remove"><i class="far fa-trash-alt"></i></div>'
                html +='</div>'
                html += '<div class="single-price">'
                    html += '<div>'
                        html += '<div>'
                            html += '<div class="current-price">'+element.price+' ₫</div>'
                            html += '<div class="initial-price">'+element.real_price+' ₫</div>'
                        html += '</div>'
                        html += '<i class="fas fa-tag"></i>'
                    html += '</div>'
                html += '</div>'
            html += '</div>'

            $(".cart-item-list").prepend(html)
            
        });
    })
    
    
</script>

@include('frontends.feature-courses')

@endsection