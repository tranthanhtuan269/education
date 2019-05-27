@extends('frontends.layouts.app')
@section('content')
<div class="cart-page-body background-page">
    <div class="cart-page-title jumbotron">
        <h2><i class="fas fa-shopping-cart"></i> Shopping cart</h2>
    </div>
    <div class="cart-page-content container">
        <div class="cart-pre-info">
            <div class="cart-pre-info-left">
                <span class="fa-stack">
                        <i class="fas fa-circle fa-stack-2x" style="color: rgb(200, 201, 202);"></i>
                        <i class="fas fa-check fa-stack-1x" style="color: rgb(200, 201, 202)"></i>                         
                </span>
                <span>
                    2 courses
                </span>
                <span>
                    100.000 đ
                </span>
            </div>
        </div>
        <div class="row">
            <div class="cart-item-list col-md-9">
                @for ($i = 0; $i < 4; $i++)
                <div class="cart-single-item">
                    <div class="image">
                        <img src="frontend/images/course_6.jpg" width="110rem" alt="">
                    </div>
                    <div class="course-info">
                        <div class="course-name">Learn Canva from an Expert Designer: Let's Create a Brand!</div>
                        <div class="lecturer-info">By Lindsay Marsh, 14+ Years | Graphic Design:Photoshop, Illustrator, Canva, XD</div>
                    </div>
                    <div class="actions">
                        <div class="save">Remove</div>
                        <div class="remove">Save for later</div>
                        <div class="wishlist">Move to wishlist</div>
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
                        <h2>120 000 ₫</h2>
                        <h5>199.99 ₫</h5>
                        <h5>50% off</h5>
                        <button id="btnCartCheckOut" class="btn btn-danger">Checkout</button>
                    </div>
                    <div>
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

@include('frontends.feature-courses')

@endsection