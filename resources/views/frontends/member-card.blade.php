@extends('frontends.layouts.app')
@section('content')
<div class="member-card-banner">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 bann">
                <img src="{{ asset('frontend/images/member-card-union.png')}}" alt="Union Member Card" title="Union Member Cards">
                <div class="tit">
                    <p>Thẻ thành viên</p>
                    <p>Courdemy</p>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="container">
    <div class="member-card-offer">
        <h2>Các loại thẻ thành viên:</h2>
        <div class="row">
            <div class="col-sm-6 box-offer-l">
                <div class="img">
                    <img class="img-bg" src="{{ asset('frontend/images/member-card-50.png')}}" alt="$10 Courdemy" title="$50 - Courdemy online courses">
                    <div class="box-l">
                        <div class="offer-dollar">
                            <p class="dollar">$50</p>
                            <div class="courdemy">
                                <img src="{{asset('frontend/images/member-card-courdemy-icon.png')}}" alt="Courdemy Icon" title="Icon">
                                <p>Courdemy</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p class="dollar">$50 - Gói khóa học trực tuyến Courdemy</p>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="valid">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>Thời hạn: 10 tháng</p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="number-course">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>10 khóa học</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="buy-now">MUA NGAY</button>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="add-to">THÊM VÀO GIỎ HÀNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 box-offer-r">
                <div class="img">
                    <img class="img-bg" src="{{ asset('frontend/images/member-card-25.png')}}" alt="$25 Courdemy" title="$25 - Courdemy online courses">
                    <div class="box-r">
                        <div class="offer-dollar">
                            <p class="dollar">$25</p>
                            <div class="courdemy">
                                <img src="{{asset('frontend/images/member-card-courdemy-icon.png')}}" alt="Courdemy Icon" title="Icon">
                                <p>Courdemy</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p class="dollar">$25 - Gói khóa học trực tuyến Courdemy</p>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="valid">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>Thời hạn: 10 tháng</p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="number-course">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>10 khóa học</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="buy-now">MUA NGAY</button>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="add-to">THÊM VÀO GIỎ HÀNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-sm-6 box-offer-l">
                <div class="img">
                    <img class="img-bg" src="{{ asset('frontend/images/member-card-10.png')}}" alt="$10 Courdemy" title="$10 - Courdemy online courses">
                    <div class="box-l">
                        <div class="offer-dollar">
                            <p class="dollar">$10</p>
                            <div class="courdemy">
                                <img src="{{asset('frontend/images/member-card-courdemy-icon.png')}}" alt="Courdemy Icon" title="Icon">
                                <p>Courdemy</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p class="dollar">$10 - Gói khóa học trực tuyến Courdemy</p>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="valid">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>Thời hạn: 10 tháng</p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="number-course">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>10 khóa học</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="buy-now">MUA NGAY</button>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="add-to">THÊM VÀO GIỎ HÀNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 box-offer-r">
                <div class="img">
                    <img class="img-bg" src="{{ asset('frontend/images/member-card-5.png')}}" alt="$5 Courdemy" title="$5 - Courdemy online courses">
                    <div class="box-r">
                        <div class="offer-dollar">
                            <p class="dollar">$5</p>
                            <div class="courdemy">
                                <img src="{{asset('frontend/images/member-card-courdemy-icon.png')}}" alt="Courdemy Icon" title="Icon">
                                <p>Courdemy</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p class="dollar">$5 - Gói khóa học trực tuyến Courdemy</p>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="valid">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>Thời hạn: 10 tháng</p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="number-course">
                                <img src="{{asset('frontend/images/member-card-check-mark.png')}}" alt="Check Mark" title="Check Mark">
                                <p>10 khóa học</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="buy-now">MUA NGAY</button>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0)">
                                <button class="add-to">THÊM VÀO GIỎ HÀNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="member-card-purchase-way">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="textx">
                    <p class="how-to">Hướng dẫn cách thanh toán</p>
                    <p class="courdemy">Giảng viên <br> Courdemy</p>
                    <a href="javascript:void(0)" title="Button Show Me">
                        <button class="show-me">Xem thêm</button>
                    </a>
                </div>
            </div>
            <div class="col-md-5 hidden-sm hidden-xs">
                <img src="{{ asset('frontend/images/member-card-how-to-purchase.png')}}" alt="How To Purchase" title="How To Purchase">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="member-card-info">
        <h2>Courdemy's <span style="color: #00baed;">Thẻ thành viên</span></h2>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <form>
                    <div class="row padding-form">
                        <div class="form-group col-sm-6">
                            <select name="card" id="select-card" class="form-control">
                                <option value="0">Chọn loại thẻ</option>
                                <option value="5">$5</option>
                                <option value="10">$10</option>
                                <option value="20">$20</option>
                                <option value="50">$50</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <select name="number" id="card-number" class="form-control">
                                <option value="0">Chọn số lượng</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group padding-form">
                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                    </div>
                    <div class="form-group padding-form">
                        <input type="number" class="form-control" id="phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group padding-form">
                        <input type="text" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="row padding-form">
                        <div class="form-group col-sm-6">
                            <select name="card" id="select-card" class="form-control">
                                <option value="0">Chọn loại thẻ</option>
                                <option value="5">$5</option>
                                <option value="10">$10</option>
                                <option value="20">$20</option>
                                <option value="50">$50</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <select name="number" id="card-number" class="form-control">
                                <option value="0">Chọn số lượng</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group padding-form">
                        <input type="text" class="form-control" id="address" placeholder="Address">
                    </div>
                    <button type="submit" class="btn-save">Lưu</button>
                </form> 
            </div>
            <div class="col-sm-6 hidden-xs">
                <img src="{{ asset('frontend/images/img_membercard.png') }}" alt="Member Card">
            </div>
        </div>
    </div>
</div>
@endsection