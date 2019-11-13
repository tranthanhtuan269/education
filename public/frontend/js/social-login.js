//Google Login
function onSignIn(googleUser) {
    // alert(1)
    var profile = googleUser.getBasicProfile();

    // console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    // console.log('Name: ' + profile.getName());
    // console.log('Image URL: ' + profile.getImageUrl());
    // console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

    var    name             = profile.getName();
    var    email            = profile.getEmail();
    var    google_id        = profile.getId();

    // console.log(gapi.auth2);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: "/googleLogin",
        data: {
            name        : name,
            email       : email,
            google_id   : google_id,
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
                // if(response.status){
                //     Swal.fire({
                //         type: 'warning',
                //         text: 'Email đã có tài khoản, yêu cầu đăng nhập!'
                //     })
                //     // location.reload();
                // }
            }
        },
        error: function (error) {
            var obj_errors = error;
            console.log(obj_errors)
            var txt_errors = 'Lỗi';
            // for (k of Object.keys(obj_errors)) {
            //     txt_errors += obj_errors[k][0] + '</br>';
            // }
            Swal.fire({
                type: 'warning',
                html: txt_errors,
            })
        }
    });

    // var auth2 = gapi.auth2.getAuthInstance();
    // auth2.signOut().then(function () {
    // console.log('User signed out.');
    // });
    // 
}

// function signOut() {
//     var auth2 = gapi.auth2.getAuthInstance();
//     auth2.signOut().then(function () {
//     console.log('User signed out.');
//     });
// }

//Facebook Login
var facebook_name = ''
var facebook_id = ''
function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    // console.log('statusChangeCallback');
    // console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
        testAPI();
    } else {                                 // Not logged into your webpage or we are unable to tell.
        document.getElementById('status').innerHTML = 'Please log ' +
        'into this webpage.';
    }
}

function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
        statusChangeCallback(response);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/facebookLogin",
        data: {
            name        : facebook_name,
            facebook_id : facebook_id,
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
}

window.fbAsyncInit = function() {
    FB.init({
        appId      : '2474435149283816',
        cookie     : true,                     // Enable cookies to allow the server to access the session.
        xfbml      : true,                     // Parse social plugins on this webpage.
        version    : '5.0'           // Use this Graph API version for this call.
    });

    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
        statusChangeCallback(response);        // Returns the login status.
    });
}

(function(d, s, id) {                      // Load the SDK asynchronously
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    // console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        // console.log('Successful login for: ' + response.name);
        console.log(response)
        // document.getElementById('status').innerHTML =
            // 'Cảm ơn bạn đã đăng nhập, ' + response.name + '!' + response.email;
        facebook_name   = response.name
        facebook_id     = response.id
    });
}

// window.fbAsyncInit = function() {
//   FB.init({
//     appId      : '2474435149283816',
//     cookie     : true,
//     xfbml      : true,
//     version    : '5.0'
//   });
//   FB.AppEvents.logPageView();   
// };

// (function(d, s, id){
//     var js, fjs = d.getElementsByTagName(s)[0];
//     if (d.getElementById(id)) {return;}
//     js = d.createElement(s); js.id = id;
//     js.src = "https://connect.facebook.net/en_US/sdk.js";
//     fjs.parentNode.insertBefore(js, fjs);
// }(document, 'script', 'facebook-jssdk'));


// FB.getLoginStatus(function(response) {
//     statusChangeCallback(response);
// });

// function checkLoginState() {
//     FB.getLoginStatus(function(response) {
//         statusChangeCallback(response);
//     });
// }