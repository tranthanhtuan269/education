@extends('frontends.layouts.app')
@section('content')
<div class="container">
	<div class="bill-info">
		<div class="row">
			<div class="col-xs-12 clearfix title-bill-info">
				<div class="pull-left">
					<h2>Billing Infomation</h2>
					<h3>Balance :<span> {{ number_format($user_balance, 0, '.', '.') }} ₫</span></h3>
				</div>
				<div class="pull-right">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#payTab">Pay</a></li>
						<li><a data-toggle="tab" href="#addFundTab">Add Funds</a></li>
						<li><a data-toggle="tab" href="#purchaseHistoryTab">Purchase History</a></li>
						<li><a data-toggle="tab" href="#redeemCodeTab">Redeem Code</a></li>
					</ul>
				</div>
			</div>
			
			<hr>

			<div class="tab-content">
				<div id="payTab" class="col-xs-12 tab-pane payment-method check-out-page fade in active">
					<div class="row">
						<div class="col-xs-12 balance">
							<div class="row">
								<div class="col-sm-4"><p>TOTAL :</p><p class="amount"></p></div>
								<div class="col-sm-1"></div>
								<div class="col-sm-6 info-box">
																								
								</div>
							</div>
						</div>
					</div>
					<div class="row payment-methods">
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Internet Banking">
									<img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1">
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Visa">
									<img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2">
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="NganLuongVN">
									<img src="{{asset('frontend/images/payment-method-3.png')}}" alt="Payment Methods 3">
								</a>
							</div>
						</div>
					</div>
					<div class="row payment-methods">
						<div class="col-sm-4 col-sm-offset-2">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Paypal">
									<img src="{{asset('frontend/images/payment-method-4.png')}}" alt="Payment Methods 4">
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Bank Transfer">
									<img src="{{asset('frontend/images/payment-method-5.png')}}" alt="Payment Methods 5">
								</a>
							</div>
						</div>
					</div>

					
				</div>
				<div id="addFundTab" class="col-xs-12 payment-method tab-pane fade in">
					<div class="row">
						<div class="col-xs-12 balance">
							<div class="row">
								<div class="col-sm-4"><p>BALANCE:</p><p class="amount"> {{ number_format($user_balance, 0, '.', '.') }} ₫</p></div>
								<div class="col-sm-8">
									<form>
										<div class="form-row">
											<div class="form-group col-sm-8">
												<input type="text" class="form-control" id="amount-money" placeholder="Enter Your Amount of Money">
											</div>
											<button type="submit" class="col-sm-4 btn-confirm">Confirm</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Internet Banking">
									<img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1">
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Visa">
									<img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2">
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="NganLuongVN">
									<img src="{{asset('frontend/images/payment-method-3.png')}}" alt="Payment Methods 3">
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-sm-offset-2">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Paypal">
									<img src="{{asset('frontend/images/payment-method-4.png')}}" alt="Payment Methods 4">
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="payment-card">
								<a href="javascript:void(0)" title="Bank Transfer">
									<img src="{{asset('frontend/images/payment-method-5.png')}}" alt="Payment Methods 5">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div id="purchaseHistoryTab" class="tab-pane fade">
					<div>
						sadas
					</div>
				</div>
				<div id="redeemCodeTab" class="tab-pane fade">

				</div>
			</div>
			
			
		</div>
	</div>

	<script>
		var cart_items = JSON.parse(localStorage.getItem('cart'))
    	var totalPrice = 0
    	var totalInitialPrice = 0
		$(document).ready( function () {
			cart_items.forEach((element, index) => {
				var real_price = element.real_price
				if(element.real_price == null){
					real_price = element.price
				}
				html = ''
				html += '<div class="items col-sm-12">'
					html += '<div class="col-sm-10">'
						html += element.name
					html += '</div>'
					html += '<div class="col-sm-2">'
						html += '<span style="color: #0097e3;">'+number_format(real_price, 0, '.', '.')+' ₫</span>'
					html += '</div>'
				html += '</div>'

				$("#payTab .info-box").append(html)
				totalPrice += real_price
			})
			$("#payTab .balance .amount").append(number_format(totalPrice, 0, '.', '.') +" ₫")
			var balance = {{$user_balance}}
			// console.log(a)
			
			if (totalPrice < balance){
				$(".payment-methods").hide()
			}else{
				$(".payment-methods").show()				
			}
		})
	</script>
</div>
@endsection