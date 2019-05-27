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
            <div class="cart-item-list col-md-8">
                <div>
                
                </div>
            </div>
            <div class="col-md-4">
                <div>

                </div>
            </div>
        </div>
    </div>
</div>

@include('frontends.feature-courses')

@endsection