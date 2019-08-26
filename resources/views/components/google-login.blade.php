<script src="https://apis.google.com/js/platform.js" async></script>
{{-- <meta name="google-signin-client_id" content="658704434303-kgbsdp88qh3avffl16blio0s3kkd7gfa.apps.googleusercontent.com"> --}}


<div class="g-signin2" data-onsuccess="onSignIn"></div>
<script>
    function onSignIn(googleUser) {
        // alert(1)
        var profile = googleUser.getBasicProfile();

        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

        var    name             = profile.getName();
        var    email            = profile.getEmail();
        var    google_id        = profile.getId();

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
                        text: 'Đăng nhập thành công'
                    })
                    // location.reload();
                } else {
                    if(response.status == 201){
                        Swal.fire({
                            type: 'success',
                            text: 'Đăng ký thành công!'
                        })
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'warning',
                            text: 'Đăng nhập thất bại'
                        })
                    }
                    if(response.status){
                        Swal.fire({
                            type: 'warning',
                            text: 'Email đã có tài khoản, yêu cầu đăng nhập!'
                        })
                        // location.reload();
                    }
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
    }

    // function signOut() {
    //     var auth2 = gapi.auth2.getAuthInstance();
    //     auth2.signOut().then(function () {
    //     console.log('User signed out.');
    //     });
    // }

</script>