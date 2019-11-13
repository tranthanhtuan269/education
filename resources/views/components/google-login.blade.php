<script src="https://apis.google.com/js/platform.js" async></script>
<script type="text/javascript" src="/frontend/js/social-login.js"></script>

{{-- <meta name="google-signin-client_id" content="658704434303-kgbsdp88qh3avffl16blio0s3kkd7gfa.apps.googleusercontent.com"> --}}

{{-- <div class="btn btn-lg btn-danger btn-block kpx_btn_google" id="btn-google-login" >
    <span class="social-login-icon">
        <i class="fab fa-google fa-lg fa-fw"></i>
    </span>
    Đăng nhập với Google
</div> --}}

<div class="g-signin2" data-onsuccess="onSignIn" id="button-signin-gg" data-width="398" data-height="50"
data-longtitle="true">
    Đăng nhập với Google
</div>
<style>
    .g-signin2{
        width: 100%;
    }
</style>
<script>
    $('#btn-google-login').click(function(){
        // $('#button-signin-gg').click();
        onSignIn();
    });
</script>