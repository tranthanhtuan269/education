@extends('frontends.layouts.app')
@section('content')
<div class="banner-student-profile">
	<div class="row">
		<div class="col-xs-12">
			<div class="ava">
				<img src="{{asset('frontend/images/student-profile-ava.png')}}" alt="Student Avatar" title="Avatar">
				<button onclick="#" type="button">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					<span>Edit Avatar</span>
				</button>
			</div>
			<div class="brief-des">
				<p class="name">Tran Duong</p>
				<p>Member Since 06 May 2019</p>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="profile">
		<p>Profile</p>
		<form>
			<div class="row">
				<div class="form-group col-sm-6">
					<input type="text" class="form-control" id="full-name" placeholder="Full Name">
				</div>
				<div class="form-group col-sm-6">
					<input type="text" class="form-control" id="email" placeholder="Email">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<input type="number" class="form-control" id="phone-number" placeholder="Phone Number">
				</div>
				<div class="form-group col-sm-6">
					<input type="text" class="form-control" id="dob" placeholder="DOB">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<input type="text" class="form-control" id="city" placeholder="City">
				</div>
				<div class="form-group col-sm-6">
					<input type="text" class="form-control" id="sex" placeholder="SEX">
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="address" placeholder="Address">
			</div>
			<button type="submit" class="btn-save">SAVE</button>
		</form>
	</div>
</div>

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
					<div class="col-sm-4"><p>BALANCE:</p><p class="amount">$400</p></div>
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