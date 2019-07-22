<div class="become-teacher">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="ads-teacher">
                            <p>TRỞ THÀNH</p>
                            <h2>GIẢNG VIÊN<br> COURDEMY</h2>
                            <a href="{{ Auth::check() ? url('user/register-teacher') : 'javascript:void(0)' }}" title="Register Teacher" {{ Auth::check() ? '' : ' data-toggle=modal data-target=#myModalLogin data-dismiss=modal id=redirect_register_teacher' }}>ĐĂNG KÝ NGAY</a>
                        </div>
                    </div>
                    <div class="col-sm-6 hidden-xs">
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-1">
                                <img src="{{ asset('frontend/images/courdemy-teacher.png') }}" alt="Teacher" />  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="member-card">
        <div class="row">
            <div class="col-sm-6">
                <div class="courdemy-member">
                    <p id="coursdemy">Thẻ thành viên</p>
                    <p id="txt-format">Courdemy</p>
                    <p class="des-member-card">Trở thành thành viên của Courdemy để hưởng những ưu đãi bất ngờ cho các khóa học mà bạn quan tâm</p>
                    <div class="btn-register">
                        <a href="{{ url('member-card') }}" title="Register Member">ĐĂNG KÝ NGAY</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="member-card-img">
                    <img src="{{ asset('frontend/images/img_membercard.png') }}" alt="Register Now" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="partner">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Đào tạo nâng cao <br> đội ngũ nhân viên của bạn?</h2>
                <p>Chúng tôi cung cấp giải pháp tiết kiệm, linh hoạt và hiệu quả <br> cho chương trình đạo tạo của bạn </p>
            </div>
        </div>
        <div class="partner-img clearfix">
            <ul>
                <li><div><img src="{{ asset('frontend/images/partner_5.png') }}"></div></li>
                <li><div><img src="{{ asset('frontend/images/partner_4.png') }}"></div></li>
                <li><div><img src="{{ asset('frontend/images/partner_3.png') }}"></div></li>
                <li><div><img src="{{ asset('frontend/images/partner_2.png') }}"></div></li>
                <li><div><img src="{{ asset('frontend/images/partner_1.png') }}"></div></li>
            </ul>
        </div>
    </div>
</div>