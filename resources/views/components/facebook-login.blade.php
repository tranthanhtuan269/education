{{-- <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0&appId=426138308059078&autoLogAppEvents=1"></script>

<div class="fb-login-button" data-width="400" data-size="large" data-button-type="login_with" data-auto-logout-link="false" data-use-continue-as="true"></div> --}}

<br><br>

<fb:login-button scope="public_profile,email" login_text="Đăng nhập với Facebook" onlogin=checkLoginState()>
</fb:login-button>

<div id="status"></div>

<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '2474435149283816',
        cookie     : true,
        xfbml      : true,
        version    : '5.0'
      });
      FB.AppEvents.logPageView();   
    };
  
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });

    {
        status: 'connected',
        authResponse: {
            accessToken: '{access-token}',
            expiresIn:'{unix-timestamp}',
            reauthorize_required_in:'{seconds-until-token-expires}',
            signedRequest:'{signed-parameter}',
            userID:'{user-id}'
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
</script>