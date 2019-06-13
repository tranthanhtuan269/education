@extends('frontends.layouts.app')
@section('content')
<div class="container">
	<div class="bill-info">
		<div class="row">
			<div class="col-xs-12 clearfix title-bill-info">
				<div class="pull-left">
					<h2>Billing Infomation</h2>
				</div>
				<div class="pull-right">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#best-seller">Add Funds</a></li>
						<li><a data-toggle="tab" href="#menu1">Purchase History</a></li>
						<li><a data-toggle="tab" href="#menu2">Redeem Code</a></li>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 balance">
				<div class="row">
					<div class="col-sm-4"><p>BALANCE:</p><p class="amount"> {{ number_format($user_balance, 0, '.', '.') }} VND</p></div>
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
			<div class="col-xs-12 payment-method">
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
					<div class="col-md-4">
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
@endsection