@extends('frontends.layouts.app') 
@section('content')
<?php
    $internet_banking = $payments[0];
    $visa_mastercard = $payments[1];
    $nganluong = $payments[2];
    $paypal = $payments[3];
    $bank_transfer = $payments[4];
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
                            <a href="javascript:void(0)" title="Visa">
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
    })
</script>

@endsection
