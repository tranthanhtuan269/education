<fb:login-button scope="public_profile,email" login_text="Đăng nhập với Facebook" onlogin=checkLoginState() style="display:none">
</fb:login-button>

<div id="status"></div>

<div class="btn btn-lg btn-primary btn-block kpx_btn-facebook buttonFacebookLogin" data-toggle="tooltip" data-placement="top" title="Facebook">
    <span class="social-login-icon">
        <i class="fab fa-facebook-f fa-lg fa-fw"></i>
    </span>
    Đăng nhập với facebook
</div>
@if (!Auth::check())
<script>
    var course = {{$course_fb_login}};
    $('.buttonFacebookLogin').click(function(){
        checkLoginState()
    })
    function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
        if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            facebookLogin();
        } else {                                 // Not logged into your webpage or we are unable to tell.
            FB.login(function(response){
                checkLoginState()
            }, {scope: 'email'});
        }
    }

    function checkLoginState() {               // Called when a person is finished with the Login Button.
        FB.getLoginStatus(function(response) {   // See the onlogin handler
            statusChangeCallback(response);
            if (response.status === 'connected') {
                console.log(response.authResponse);
            }
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '426138308059078',
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

    function facebookLogin() {
        FB.api('/me',
            'GET',
            {"fields":"id,name,email"},
            function(response) {
            console.log(response)
            var facebook_id = response.name;
            var facebook_name = response.id;
            var facebook_email = response.email;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/facebookLogin",
                data: {
                    name        : facebook_id,
                    facebook_id : facebook_name,
                    email       : facebook_email,
                    course      : course,
                },
                method: "POST",
                dataType:'json',
                beforeSend: function(r, a){
                    $('.alert-errors').addClass('d-none');
                },
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            text: 'Đăng nhập thành công!'
                        }).then(result => {
                            location.reload()
                        })
                    } else {
                        if(response.status == 201){
                            Swal.fire({
                                type: 'success',
                                text: 'Đăng ký tài khoản thành công!'
                            }).then(result => {
                                location.reload()
                            })
                        }else{
                            Swal.fire({
                                type: 'warning',
                                text: 'Đăng nhập thất bại'
                            })
                        }
                    }
                },
                error: function (error) {
                    var obj_errors = error;
                    console.log(obj_errors)
                    var txt_errors = 'Lỗi';
                    Swal.fire({
                        type: 'warning',
                        html: txt_errors,
                    })
                }
            });
        });
    }
</script>
@endif