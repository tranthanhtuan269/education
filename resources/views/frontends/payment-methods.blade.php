@extends('frontends.layouts.app')
@section('content')
<div class="container">
	<div class="bill-info">
		<div class="row">
			<div class="col-xs-12 clearfix">
				<div class="title-bill-info">
					<div class="pull-left">
						<h2>Thông tin đơn hàng</h2><br>
						<p style="font-size: 20px">Tài khoản: <b>{{ number_format($user_balance, 0, '.', '.') }} ₫</b></p>
					</div>
					<div class="pull-right">
						<ul class="nav nav-tabs" id="fullpageTab">
							{{-- <li class="active"><a data-toggle="tab" href="#payTab">Pay</a></li> --}}
							{{-- <li><a data-toggle="tab" href="#addFundTab">Top up</a></li> --}}
							{{-- <li><a data-toggle="tab" href="#purchaseHistoryTab">Purchase History</a></li> --}}
							{{-- <li><a data-toggle="tab" href="#redeemCodeTab">Redeem Code</a></li> --}}
						</ul>
					</div>
				</div>
			</div>
			
			<div class="tab-content">
				<div id="payTab" class="col-xs-12">
					<div class="tab-pane payment-method check-out-page fade in active">
						<div class="row">
							<div class="col-sm-4 left-column">
								<div class="cart-info">
									<p>Khóa học (<span></span>)</p>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="final-price">
									<span class="price-text"></span>
								</div>
								<div class="">
									<a href="/cart">Chỉnh sửa đơn hàng</a>
								</div>
								<div class="pay-field" >
									<div class="row payment" style="display:flex; align-items: center;">
										<div class="col-sm-5 col-xs-12">
											<button id="btnPurchaseWBalance" class="btn btn-success btn-lg btn-block">Thanh toán</button>
										</div>
										<div class="col-sm-4 col-xs-12">
											<div class="accept-terms">
												<span>Bằng việc tiến hành thanh toán, bạn đồng ý với các</span><a href="/terms-of-service"> Điều khoản và điều kiện</a> của Courdemy.
											</div>
										</div>
										<div class="col-sm-3 col-xs-12 text-right" style="display:flex; align-items: center;">
											<div class="col-sm-5 text-right" style="display:flex; align-items: center; justify-content: flex-end; padding-right:0;">
												<i class="fas fa-lock" style="font-size: xx-large"></i>
											</div>
											<div class="col-sm-7 text-left">
												Kết nối bảo mật
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
								<div class="col-sm-4"><p>Số dư:</p><p class="amount"> {{ number_format($user_balance, 0, '.', '.') }} ₫</p></div>
								<div class="col-sm-8">
									<form>
										<div class="form-row">
											<div class="form-group col-sm-8">
												<input type="text" class="form-control" id="amount-money" placeholder="Enter Your Amount of Money">
											</div>
											<button type="submit" class="col-sm-4 btn-confirm">Xác nhận</button>
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

	<div class="modal fade" id="switchPayment">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="pay-field">
						<ul id="payTabTabs" class="nav nav-pills nav-justified">
							<li role="presentation" class="active"><a data-toggle="tab" href="#topUpWallet">Nạp tiền vào tài khoản</a></li>
							{{-- <li role="presentation"><a data-toggle="tab" href="#payByCard">Pay directly by card</a></li> --}}
						</ul>
						<div class="tab-content">
							<div id="topUpWallet" class="tab-pane fade in active">
								<div class="row" style="margin: 1em 0;">
									<div class="col-sm-4 text-center" style="">
										<div>
											Tài khoản:
										</div>
										<div>
											{{ number_format($user_balance, 0, '.', '.') }} ₫
										</div>
									</div>
									<div class="col-sm-8">
										<div class="input-group top-up-amount">
											<span class="input-group-addon" id="topUpAmount">Tiền muốn nạp:</span>
											<input type="text" class="form-control" aria-describedby="topUpAmount">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="payment-card">
											<a href="javascript:void(0)" title="Internet Banking">
												<img src="{{asset('frontend/images/payment-method-1.png')}}" alt="Payment Methods 1" width="100%">
											</a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="payment-card">
											<a href="javascript:void(0)" title="Visa">
												<img src="{{asset('frontend/images/payment-method-2.png')}}" alt="Payment Methods 2"  width="100%">
											</a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="payment-card">
											<a href="javascript:void(0)" title="NganLuongVN">
												<img src="{{asset('frontend/images/payment-method-3.png')}}" alt="Payment Methods 3" width="100%">
											</a>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 2em;">
									<div class="col-sm-4 col-sm-offset-2">
										<div class="payment-card">
											<a href="javascript:void(0)" title="Paypal">
												<img src="{{asset('frontend/images/payment-method-4.png')}}" alt="Payment Methods 4" width="100%">
											</a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="payment-card">
											<a href="javascript:void(0)" title="Bank Transfer">
												<img src="{{asset('frontend/images/payment-method-5.png')}}" alt="Payment Methods 5" width="100%">
											</a>
										</div>
									</div>
								</div>
								
								
								
							</div>
							{{-- <div id="payByCard" class="tab-pane fade">
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
							</div> --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		var user_id = $('button[id=cartUserId]').attr('data-user-id')
		var loginCart = []

		if( user_id != 0 ){
			if(localStorage.getItem('cart'+user_id) == null){
                localStorage.setItem('cart'+user_id, '[]')
            }
			loginCart = JSON.parse(localStorage.getItem('cart'+user_id))
			if( localStorage.getItem('cart'+0) != null ){
				var noLoginCart = JSON.parse(localStorage.getItem('cart'+0))
				noLoginCart.forEach(function(element) {
					var check = true
					if ( loginCart.length > 0 ){
						loginCart.forEach(function(obj) {
							if(element.id == obj.id){
								check = false
							}
						})
					}
					if(check == true){
						loginCart = loginCart.concat(element)
					}
				})
				localStorage.setItem('cart'+0, '[]')
				localStorage.setItem('cart'+user_id, JSON.stringify(loginCart))
			}
			if(loginCart.length >= 1){
				$('.unica-sl-cart').css('display', 'block')
			}else{
				$('.unica-sl-cart').css('display', 'none')
			}
		}
		console.log(loginCart)
		var cart_items = loginCart
		var coupon_code = localStorage.getItem('coupon')
    	var final_price = 0
    	var totalInitialPrice = 0
		var balance = {{$user_balance}}
		var pay_price = 0;
		var coupon_code_array = new Array()
		var course_id_array = new Array()
		
		$(document).ready( function () {
			showItems()
			getFinalPrice()
			toggleCardMethodPanel()		

			$("#payTab .cart-info span").append(cart_items.length)				
			 
			// $("#payTab .final-price .price-text").append(number_format(pay_price, 0, '.', '.') +" ₫")
			// $('#payWithBalance .price').append(number_format(pay_price, 0, '.', '.') +" ₫")

			function getFinalPrice() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				if(cart_items.length < 1){
					Swal.fire({
						type:"warning",
						text:"Không có sản phẩm cần thanh toán!"
					}).then((result) => {
						window.location.href = ('/')
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
							if(response.status == '200'){
								// $("#payTab .final-price .price-text").append(number_format(response.final_price, 0, '.', '.') +" ₫")
								// $('#payWithBalance .price').append(number_format(response.final_price, 0, '.', '.') +" ₫")
								$("#payTab .final-price .price-text").append(number_format(pay_price, 0, '.', '.') +" ₫")
								$('#payWithBalance .price').append(number_format(pay_price, 0, '.', '.') +" ₫")
								final_price = response.final_price

								if(balance < final_price){
									var html = ''
									html += '<div class="notice" style="margin-bottom: 0.75em">'
										html += '<span class="text-danger">Your balance is not enough!</span> Please <a href="#addFundTab">extend your balance</a> or <a href="#payByCard">Pay directly by your card</a>'
									html += '</div>'

									$("#payWithBalance .user-balance").after(html)

									// Swal.fire({
									// 	type: 'warning',
									// 	text: 'Your Balance is not enough!'
									// })
								}else{
									var html = ''
									html += '<div class="row payment">'
										html += '<div class="col-sm-5">'
											html += '<button id="btnPurchaseWBalance" class="btn btn-success btn-lg btn-block">Complete Payment</button>'
										html += '</div>'
										html += '<div class="col-sm-3 accept-terms">'
											html += '<span>By completing your purchase you agree to these</span><a href="/terms-of-service">Terms of Service</a>.'
										html += '</div>'
										html += '<div class="col-sm-4 text-right">'
											
										html += '</div>'
									html += '</div>'

										
									$("#payWithBalance .user-balance").after(html)
								}

								$('#payWithBalance .notice a[href="#addFundTab"]').on('click', function (e) {
									e.preventDefault()
									e.stopPropagation()
									$('#fullpageTab a[href="#addFundTab"]').tab('show')
								})

								$('#payWithBalance .notice a[href="#payByCard"]').on('click', function (e) {
									e.preventDefault()
									e.stopPropagation()
									$('#payTabTabs a[href="#payByCard"]').tab('show')
								})

								$('#btnPurchaseWBalance').on('click', function () {
									checkout()
								})
							}
							
						},
						error: function (response) {
							// window.location.replace("404")
						}
					})
				}
			}
			
			function showItems(){
				cart_items.forEach((element, index) => {
					// var selling_price = element.price
					
					coupon_code_array[index] = element.coupon_code
					course_id_array[index] = element.id
					// console.log(coupon_code_array)
					var selling_price = element.coupon_price
					if(element.real_price == null){
						selling_price = element.real_price
					}
					html = ''
					html += '<div class="row item-box">'
						html += '<div class="image col-sm-3">'
						

						if(element.image.indexOf('unica') !== -1){
							html += '<img src="'+element.image+'" width="100%" alt="">'
						}else{
							html += '<img src="/frontend/images/'+element.image+'" width="100%" alt="">'
						}
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
					pay_price += selling_price
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
						text:"Giỏ hàng không được trống!"
					})
				}else{
					var list_coupon = JSON.stringify(coupon_code_array)
					var list_course_id = JSON.stringify(course_id_array)

					var request = $.ajax({
						url : "/checkout",
						method: "POST",
						data :{
							"items" : cart_items,
							"coupon" : coupon_code,
							// 'cart' : localStorage.getItem('cart'+user_id),
							// "list_course_id" : list_course_id,
						},
						dataType: "json",    
						beforeSend: function(r, a){
		                    $(".ajax_waiting").addClass("loading");
		                },
		                complete: function() {
		                    $(".ajax_waiting").removeClass("loading");
		                },            
					})

					request.done((response)=>{
						if(response.status == 201){
							// remove cart in localstorage
							cart_items = [];
							localStorage.setItem('cart'+user_id, JSON.stringify(cart_items))
							
							return Swal.fire({
								type:"success",
								text:"Mua khóa học thành công!"
							}).then((result) => {
								if (result.value) {
									window.location.href = "/";									
								}
							});
						}else if(response.status == 204){
							// var htmlNot = ""
							// htmlNot += '<div class="options">'
							// 	htmlNot += '<div class="payment-options">'
							// 		// htmlNot += '<button id="openTopUpModal" class="btn btn-warning">Nạp tiền vào tài khoản</button>'
							// 		htmlNot += '<a href="/proceed-checkout">'
							// 			htmlNot += '<button class="btn btn-danger"><b>Chọn hình thức thanh toán</b></button>'
							// 		htmlNot += '</a>'
							// 	htmlNot += '</div>'
							// htmlNot += '</div>'

							// return Swal.fire({
							// 	type: "warning",
							// 	text: `Tài khoản của bạn không đủ để thực hiện giao dịch!`,
							// 	footer: htmlNot,
							// 	allowOutsideClick: false,
							// 	showConfirmButton: false,
							// }).then((result) => {
							// 	if (result.value) {
							// 		// window.location.href = "/member-card";
							// 		$("#switchPayment").modal('show')
							// 	}
							// });
							window.location.href = "/proceed-checkout"
						}else{
							return Swal.fire({
								type:"warning",
								text:"Đơn hàng không được tạo thành công!"
							})
						}
					})
				}
			}

			$(document).on('click', "#openTopUpModal", function () {
				Swal.close()
				$("#switchPayment").modal('show')
			})
			
		})
	</script>
</div>
@endsection