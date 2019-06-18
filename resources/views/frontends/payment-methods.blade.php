@extends('frontends.layouts.app')
@section('content')
<div class="container">
	<div class="bill-info">
		<div class="row">
			<div class="col-xs-12 clearfix title-bill-info">
				<div class="pull-left">
					<h2>Billing Information</h2>
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
			
			<div class="tab-content">
				{{-- <div id="payTab" class="col-xs-12 tab-pane payment-method check-out-page fade in active">
					<div class="row">
						<div class="col-xs-12 balance">
							<div class="row">
								<div class="col-sm-4">
									<p>TOTAL :</p>
									<p class="amount"></p>
									<div class="applied-coupon">COUPON : COUPON16</div>
								</div>
								<div class="col-sm-4">
									<div>
										<span>Payment Method: </span><span class="text-primary">My Courdemy Wallet</span>
									</div>
									<div>
										<span>Name: </span><span class="text-primary">{{Auth::user()->name}}</span>						
									</div>
									<div class="checkbox">
										<label>
										<input id="checkoutCheckBox" type="checkbox"> I agree to these <a href="#">Terms of Service</a>.
										</label>
									</div>
								</div>
								<div class="col-sm-3">
									<div>
										<button id="btnPurchase" class="btn btn-success btn-lg btn-block">Complete Payment</button>										
									</div>
									<div>
										<a href="/cart">Edit your cart</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="info-box">
						<div class="items col-md-12">
							<div class="col-md-2 item-image">
								<img src="/frontend/images/course_2.jpg" width="100%" alt="">
							</div>
							<div class="col-md-8">
								<div class="title">
									Forex Robots: Automate Your Trading
								</div>
								<div class="author">
									Arjen Robben
								</div>
							</div>
							<div class="col-md-2">
								<span class="price" style="color: #0097e3;">800.000 ₫</span>
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
					
				</div> --}}

				<div id="payTab" class="col-xs-12 tab-pane payment-method check-out-page fade in active">
					<div class="col-sm-4 left-column">
						<div class="cart-info">
							<p>Your Items (3)</p>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="final-price">
							<span class="price-text"></span>
						</div>
						<div class="">
							<a href="/cart">Edit your cart</a>
						</div>
						<div class="pay-field">
							<ul class="nav nav-pills nav-justified">
								<li role="presentation" class="active"><a data-toggle="tab" href="#payWithBalance">Pay with your balance</a></li>
								<li role="presentation"><a data-toggle="tab" href="#payByCard">Pay directly by card</a></li>
							</ul>
							<div class="tab-content">
								<div id="payWithBalance" class="tab-pane fade in active">
									<div class="total">
										Total price to pay: <span class="price"></span>
									</div>
									<div class="user-balance">
										Your balance: <span>{{ number_format($user_balance, 0, '.', '.') }} ₫</span>
									</div>
									<div class="row payment">
										<div class="col-sm-5">
											<button class="btn btn-success btn-lg btn-block">Complete Payment</button>
										</div>
										<div class="col-sm-3">
											<span>By completing your purchase you agree to these </span><a href="/terms-of-service">Terms of Service</a>.
										</div>
										<div class="col-sm-4">

										</div>
									</div>
								</div>
								<div id="payByCard" class="tab-pane fade">
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
    	var final_price = 0
    	var totalInitialPrice = 0
		var balance = {{$user_balance}}

		$(document).ready( function () {
			showItems()
			getFinalPrice()
			toggleCardMethodPanel()

			$('#btnPurchase').click( function () {
				checkout()
			})
			
			function getFinalPrice() {
				var coupon_code = localStorage.getItem('coupon')
				var cart_items = JSON.parse(localStorage.getItem('cart'))
				console.log(cart_items);
				
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
					$.ajax({
						method: 'GET',
						url: '/cart/payment/getFinalPrice',
						data: {
							coupon_code: coupon_code,
							items : cart_items,
						},
						success: function (response) {
							$("#payTab .final-price .price-text").append(number_format(response.final_price, 0, '.', '.') +" ₫")
							$('#payWithBalance .price').append(number_format(response.final_price, 0, '.', '.') +" ₫")
							final_price = response.final_price
						},
						error: function (response) {
							
						}
					})
				}
			}
			
			function showItems(){
				cart_items.forEach((element, index) => {
					var selling_price = element.price
					if(element.real_price == null){
						selling_price = element.real_price
					}
					html = ''
					html += '<div class="row item-box">'
						html += '<div class="image col-sm-3">'
							html += '<img src="/frontend/images/'+element.image+'" width="100%" alt="">'
						html += '</div>'
						html += '<div class="info col-sm-9">'
							html += '<div class="title">'
								html += element.name
							html += '</div>'
							html += '<div class="author">'
								html += element.lecturer
							html += '</div>'
							html += '<div class="price">'
								html += number_format(selling_price, 0, '.', '.') +" ₫"
							html += '</div>'
						html += '</div>'
					html += '</div>'

					$("#payTab .left-column").append(html)
				})
			}
			
			function toggleCardMethodPanel () {
				if (final_price <= balance){
					$(".payment-methods").hide()
				}else{
					$(".payment-methods").show()				
				}
			}

			function checkout(){
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
</div>
@endsection