@extends('frontends.layouts.app') 
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>

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
        <!-- <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12 balance">
                <h4 class="text-center">Nhập số tiền (VND)</h4>
                <form>
                    <div class="form-row">
                        <div class="form-group col-sm-8">
                            <input type="number" class="form-control" id="amountMoney" min="1000" placeholder="Số tiền bạn muốn nạp">
                        </div>
                        <div class="btn btn-warning col-sm-4 btn-confirm-money">Xác nhận</div>
                    </div>
                </form>
            </div>
        </div> -->
        <div id="addFundTab" class="col-xs-12 payment-method tab-pane fade in" style="display:block">
            <div class="row">
                <ul>
                    @if ( $visa_mastercard->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a data-toggle="tab" href="#visa_mastercard" id="paymentVisaStripe" title="Visa">
                                <img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2">
                            </a>
                        </div>
                    </li>
                    @else
                    <li>
                        <div class="payment-card" id="disabled-hide-card-2">
                            <img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2" style="opacity: 0.5;">                           
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
                    @else
                    <li>
                        <div class="payment-card" id="disabled-hide-card-5">
                            <img src="{{asset('frontend/images/payment-method-5.png')}}" alt="Payment Methods 5" style="opacity: 0.5;">                           
                        </div>
                    </li>
                    @endif
                    @if ( $internet_banking->status == 1 )
                    <li>
                        <div class="payment-card">
                            <a href="javascript:void(0)" title="Internet Banking">
                                <img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1">
                            </a>
                        </div>
                    </li>
                    @else
                    <li>
                        <div class="payment-card" id="disabled-hide-card-1">
                                <img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1" style="opacity: 0.5;">
                            
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
                    @else
                    <li>
                        <div class="payment-card" id="disabled-hide-card-3">
                            <img src="{{asset('frontend/images/payment-method-3.png')}}" alt="Payment Methods 3" style="opacity: 0.5;">                           
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
                    @else
                    <li>
                        <div class="payment-card" id="disabled-hide-card-4">
                            <img src="{{asset('frontend/images/payment-method-4.png')}}" alt="Payment Methods 4" style="opacity: 0.5;">                           
                        </div>
                    </li>
                    @endif                   
                </ul>
            </div>
            <div class="recharge-content">
                <div class="tab-content">
                    <div id="bank_transfer" class="tab-pane fade in tab-steps-register">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="desc">
                                    <h4>{{ $bank_transfer->title }}</h4>
                                    <p class="bank-description">
                                        {!! $bank_transfer->description !!}
                                    </p>
                                    <!-- <div class="tit">Số tiền:</div> -->
                                    <!-- <div class="mess amount-money"></div> -->
                                    <div class="tit">Nội dung chuyển khoản:</div>
                                    <div class="mess">NapTienTK: {{Auth::user()->id}}</div>
                                    <p class="bank-instruction">
                                        {!! $bank_transfer->instruction !!}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="account-info">
                                    <h4>Thông tin chuyển khoản ngân hàng</h4>
                                    <table id="tablepress-5" class="tablepress tablepress-id-5">
                                        <thead>
                                            <tr class="row-1 odd">
                                                <th class="column-1">Số tài khoản</th>
                                                <th class="column-2">Tên tài khoản</th>
                                                <th class="column-2">Ngân hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bank_account as $account)
                                            <tr class="row-2">
                                                <td class="column-1">{{$account->account_number}}</td>
                                                <td class="column-2">{{$account->name}}</td>
                                                <td class="column-3">{{$account->bank_name}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="visa_mastercard" class="tab-pane fade in tab-steps-register">
                        <div class="row">
                            <div class="panel-body col-md-6 col-md-offset-3">
                                
                                @if (Session::has('success'))
                                    <script>
                                        localStorage.clear();
                                        Swal.fire({
                                            type: 'success',
                                            text: "Nạp tiền thành công!"
                                        }).then( result => {
                                            document.location.href = '/user/student/top-up';
                                        })
                                    </script>
                                @endif
                                @if (Session::has('fail'))
                                    <script>
                                        localStorage.clear();
                                        Swal.fire({
                                            type: 'warning',
                                            text: "Số tiền nhập sai (chỉ được nhập số nguyên dương)! Vui lòng nhập lại từ đầu"
                                        }).then( result => {
                                            $('#paymentVisaStripe').click();
                                        })
                                    </script>
                                @endif
                            
                                <form role="form" action="{{ route('stripe.recharge') }}" method="post" class="require-validation"
                                                                data-cc-on-file="false"
                                                                data-stripe-publishable-key="{{$STRIPE_KEY}}"
                                                                id="payment-form">
                                    @csrf
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Tên in trên thẻ:</label> <input
                                                class='form-control' name='card_name' size='4' type='text' 
                                                >
                                        </div>
                                    </div>
        
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required'>
                                            <label class='control-label'>Số thẻ:</label> <input
                                                autocomplete='off' name='card_number' class='form-control card-number' size='20'
                                                type='text' >
                                        </div>
                                    </div>
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required'>
                                            <label class='control-label'>Số tiền muốn nạp (USD):</label> <input
                                                autocomplete='off' name='price_number' class='form-control price-number' size='20'
                                                type='number' placeholder='Nhập số nguyên dương' min="0" id='priceNumber'>
                                        </div>
                                    </div>
            
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC:</label> <input autocomplete='off'
                                                name='card_cvc' class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                type='text' >
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Tháng hết hạn:</label> <input
                                                class='form-control card-expiry-month' placeholder='MM' size='2'
                                                name='card_expiry_month' type='text' >
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Năm hết hạn:</label> <input
                                                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                name='card_expiry_year' type='text' >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" id="stripeSubmit">Nạp tiền</button>
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <!-- <div class="blockform-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="default_check" >
                                        <label class="form-check-label" for="defaultCheck1" >Lưu và bảo mật cho lần thanh toán sau</label>
                                    </div> -->
                                </form>
                                <div class="col-xs-6">
                                    <button class="btn btn-primary btn-lg btn-block" id="cancel" style="margin-top: -25%;margin-left: 111%;">Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <div class="col-md-4 col-md-offset-4" style="ma">
        <button class="btn btn-primary btn-lg btn-block" style="margin-bottom: 20px;" id="historyRecharge">Lịch sử nạp tiền</button>
    </div>
    <div style="display:none" id="showRecharge">
        
        <br>
        <table class="table table-bordered" id="rechargeLogs">
            <thead class="thead-custom">
                <tr>
                    <th scope="col">Mã giao dịch</th>
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Số tiền nạp</th>
                    <th scope="col">Số dư</th>
                    <th scope="col">Loại giao dịch</th>
                    <th scope="col">Ngày nạp</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    var dataTable = null;
    var userCheckList = [];
    var current_page = 0;
    var old_search = '';
    var errorConnect = "Please check your internet connection and try again.";

    $('#historyRecharge').click(function(){
        $('#showRecharge').css('display', 'block')
    })

    $('#paymentBankTransfer').click(function(){
        $('#paymentBankTransfer img').css('border-color', '#44B900')
        $('#paymentBankTransfer img').css('border-radius', '20px')
        $('#paymentVisaStripe img').css('border-color', '#ffffff')
    })
    $('#paymentVisaStripe').click(function(){
        $('#paymentVisaStripe img').css('border-color', '#44B900')
        $('#paymentVisaStripe img').css('border-radius', '20px')
        $('#paymentBankTransfer img').css('border-color', '#ffffff')
    })

    $('#cancel').click(function(){
        $('input[name=card_name]').val('');
        $('input[name=card_number]').val('');
        $('input[name=price_number]').val('');
        $('input[name=card_cvc]').val('');
        $('input[name=card_expiry_month]').val('');
        $('input[name=card_expiry_year]').val('');
    })
    document.getElementById('priceNumber').onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58)
        || e.keyCode == 8)) {
            return false;
        }
    }
    // document.getElementById('amountMoney').onkeydown = function(e) {
    //     if(!((e.keyCode > 95 && e.keyCode < 106)
    //     || (e.keyCode > 47 && e.keyCode < 58)
    //     || e.keyCode == 8)) {
    //         return false;
    //     }
    // }
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
    // $('.btn-confirm-money').click(function(){
    //     var amount = $('#amountMoney').val();
    //     $('.amount-money').html(numberFormat(amount, 0, '.', '.') + ' VND')
    //     $('.payment-method').css('display', 'block')
    // })

    $(document).ready(function() {
        var dataObject = [
            {
                data: "id",
                class: "text-center",
                render: function(data, type, row) {
                    return '#GD'+data;
                },
            },
            {
                data: "customer_name",
                orderable: false
            },
            {
                data: "amount",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '<div style="text-align: right">';
                            html += numberFormat(data, 0, '.', '.') + ' đ';
                            html += '</div>'
                        return html;
                    }
                    return data;
                },
                orderable: false
            },
            {
                data: "balance",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '<div style="text-align: right">';
                            html += numberFormat(data, 0, '.', '.') + ' đ';
                            html += '</div>'
                        return html;
                    }
                    return data;
                },
                orderable: false
            },
            {
                data: "payment_type",
                class: "text-center",
            },
            {
                data: "id",
                render: function(data, type, row){
                    if(type == "display"){
                        var html = '<div style="text-align: right">';
                            html += row.created_at;
                            html += '</div>';
                        return html;
                    }
                    return data;
                },
            },
        ];

        dataTable = $('#rechargeLogs').DataTable({
            serverSide: false,
            search: {
                smart: false
            },
            aaSorting: [],
            stateSave: true,
            search: {
                smart: false
            },
            ajax:{
                url: "/user/student/get-recharge-logs",
            }, 
            columns: dataObject,
            bLengthChange: true,
            pageLength: 10,
            order: [[ 5, "DESC" ]],
            colReorder: {
                fixedColumnsRight: 1,
                fixedColumnsLeft: 1
            },
            oLanguage: {
                sSearch: "Tìm kiếm",
                sLengthMenu: "Hiển thị _MENU_ bản ghi",
                // zeroRecords: "Không tìm thấy bản ghi",
                sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
                sInfoFiltered: "",
                sInfoEmpty: "",
                sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                sEmptyTable: "Chưa có giao dịch nạp thẻ",
                oPaginate: {
                    sPrevious: "Trang trước",
                    sNext: "Trang sau",

                },
            },
            fnServerParams: function(aoData) {

            },
            fnDrawCallback: function(oSettings) {
                // addEventListener();
            },
            createdRow: function( row, data, dataIndex){
                // $(row).attr('data-name', data['name']);
                // $(row).attr('data-account-number', data['account_number']);
                // $(row).attr('data-bank-name', data['bank_name']);
            }
        });

        $('#rechargeLogs').css('width', '100%');
    })
</script>

<style>
    #disabled-hide-card-1 img:hover {
        border-color: white;
        border-radius: 0;
    }
    #disabled-hide-card-2 img:hover {
        border-color: white;
        border-radius: 0;
    }
    #disabled-hide-card-3 img:hover {
        border-color: white;
        border-radius: 0;
    }
    #disabled-hide-card-4 img:hover {
        border-color: white;
        border-radius: 0;
    }
    #disabled-hide-card-5 img:hover {
        border-color: white;
        border-radius: 0;
    }
</style>

@endsection
