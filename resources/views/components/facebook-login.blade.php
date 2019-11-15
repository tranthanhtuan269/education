{{-- <div id="fb-root"></div> --}}
{{-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0&appId=2474435149283816&autoLogAppEvents=1"></script> --}}

{{-- <div class="fb-login-button" data-width="400" data-size="large" data-button-type="login_with" data-auto-logout-link="false" data-use-continue-as="true"></div> --}}

<fb:login-button scope="public_profile,email" login_text="Đăng nhập với Facebook" onlogin=checkLoginState() style="display:none">
</fb:login-button>

<div id="status"></div>

<div class="btn btn-lg btn-primary btn-block kpx_btn-facebook buttonFacebookLogin" data-toggle="tooltip" data-placement="top" title="Facebook">
    <span class="social-login-icon">
        <i class="fab fa-facebook-f fa-lg fa-fw"></i>
    </span>
    Đăng nhập với facebook
</div>