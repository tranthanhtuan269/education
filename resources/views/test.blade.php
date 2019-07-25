<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
@php
    phpinfo();
@endphp
<body>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&autoLogAppEvents=1&version=v3.3&appId=484211768813006"></script>
        <div class="fb-login-button" data-width="" data-size="medium" data-button-type="login_with" data-auto-logout-link="false" data-use-continue-as="false"></div>

        <fb:login-button 
        scope="public_profile,email"
        onlogin="checkLoginState();">
        </fb:login-button>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId            : '484211768813006',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v3.3'
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

            function checkLoginState() {
                FB.getLoginStatus(function(response) {
                    statusChangeCallback(response);
                });
            }
        </script>
        <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>

</body>
</html>