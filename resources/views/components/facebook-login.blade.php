<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status"></div>

<script>

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{your-app-id}',
        cookie     : true,
        xfbml      : true,
        version    : '{api-version}'
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
</script>