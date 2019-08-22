@extends('frontends.layouts.app') 
@section('content')

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
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Internet Banking">
                                <img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1">
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Visa">
                                <img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2">
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="NganLuongVN">
                                <img src="{{asset('frontend/images/payment-method-3.png')}}" alt="Payment Methods 3">
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Paypal">
                                <img src="{{asset('frontend/images/payment-method-4.png')}}" alt="Payment Methods 4">
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Bank Transfer">
                                <img src="{{asset('frontend/images/payment-method-5.png')}}" alt="Payment Methods 5">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row">
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
            </div>
        </div>    
    </div>
</div>



@endsection
