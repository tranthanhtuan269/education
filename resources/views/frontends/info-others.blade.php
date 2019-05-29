<div class="become-teacher">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-xs-8 col-xs-offset-4">
                                <div class="ads-teacher">
                                    <p>BECOME</p>
                                    <h2>COURDEMY'S <br> TEACHER</h2>
                                    <a href="{{ Auth::check() ? url('user/register-teacher') : 'javascript:void(0)' }}" title="Register Teacher" {{ Auth::check() ? '' : ' data-toggle=modal data-target=#myModalLogin data-dismiss=modal id=redirect_register_teacher' }}>REGISTER NOW</a>
                                </div>
                            </div>
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
                    <p id="coursdemy">Coursdemy's</p>
                    <p id="txt-format">Member Card</p>
                    <p class="des-member-card">Learning can happen anywhere with our apps on your computer, mobile device, and TV, featuring enhanced navigation and faster streaming for anytime learning.</p>
                    <div class="btn-register">
                        <a href="{{ url('member-card') }}" title="Register Member">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <img src="{{ asset('frontend/images/img_membercard.png') }}" alt="Register Now" />
            </div>
        </div>
    </div>
</div>
<div class="partner">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Need to Train Your Team?</h2>
                <p>We offer flexible, cost-effective group memberships for your business, school, or government organization. Contact us to learn more.</p>
            </div>
        </div>
        <div class="partner-img clearfix">
            <ul>
                <li><img src="{{ asset('frontend/images/partner_5.png') }}"></li>
                <li><img src="{{ asset('frontend/images/partner_4.png') }}"></li>
                <li><img src="{{ asset('frontend/images/partner_3.png') }}"></li>
                <li><img src="{{ asset('frontend/images/partner_2.png') }}"></li>
                <li><img src="{{ asset('frontend/images/partner_1.png') }}"></li>
            </ul>
        </div>
    </div>
</div>