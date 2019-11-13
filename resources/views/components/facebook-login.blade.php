<script type="text/javascript" src="/frontend/js/social-login.js"></script>

{{-- <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0&appId=426138308059078&autoLogAppEvents=1"></script>

<div class="fb-login-button" data-width="400" data-size="large" data-button-type="login_with" data-auto-logout-link="false" data-use-continue-as="true"></div> --}}

<br><br>

<fb:login-button scope="public_profile,email" login_text="Đăng nhập với Facebook" onlogin=checkLoginState()>
</fb:login-button>

<div id="status"></div>