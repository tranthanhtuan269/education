<script src="https://apis.google.com/js/platform.js" async></script>

{{-- <meta name="google-signin-client_id" content="658704434303-kgbsdp88qh3avffl16blio0s3kkd7gfa.apps.googleusercontent.com"> --}}

{{-- <div class="btn btn-lg btn-danger btn-block kpx_btn_google" id="btn-google-login" >
    <span class="social-login-icon">
        <i class="fab fa-google fa-lg fa-fw"></i>
    </span>
    Đăng nhập với Google
</div> --}}

<div class="g-signin2" data-onsuccess="onSignIn" id="button-signin-gg" data-height="45"
data-longtitle="true" data-title="Đăng nhập với Google">
    Đăng nhập với Google
</div>
<style>
    .g-signin2 .abcRioButtonLightBlue{
        width: auto !important;
    }
</style>
<script>
$('#btn-google-login').click(function(){
    // $('#button-signin-gg').click();
    onSignIn();
});
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

    var check = $('#modalLoginCourseDetail').attr('data-modal-login')
    var course_id = 0
    if ( check == 'teacher' ){
        course_id = course_of_teacher_id;
    }
    if ( check == 'course' ){
        course_id = course_detail_id
    }
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
            course_id   : course_id,
        },
        method: "POST",
        dataType:'json',
        beforeSend: function(r, a){
            $('.alert-errors').addClass('d-none');
        },
        success: function (response) {
            if(response.status == 200){
                if ( course_id != 0 ){
                    $('#modalLoginCourseDetail').modal('toggle');
                }
                if ( response.role == 1 ){
                    Swal.fire({
                        type: 'warning',
                        html: 'Chú là admin nên không thể mua khóa học. Chú hiểu chứ?',
                    }).then((result)=>{
                        window.location.reload()
                    })
                }else if ( response.role == 2 ){
                    Swal.fire({
                        type: 'warning',
                        html: 'Khóa học này là của bạn.',
                    }).then((result)=>{
                        window.location.reload()
                    })
                }else if ( response.role == 3 ){
                    Swal.fire({
                        type: 'warning',
                        html: 'Bạn đã mua khóa học này.',
                    }).then((result)=>{
                        window.location.reload()
                    })
                }else if ( response.role == 0 ){
                    window.location.href = ("/cart/payment/method-selector")
                }else{
                    Swal.fire({
                        type: 'success',
                        text: 'Đăng nhập thành công!'
                    }).then(result => {
                        if (course_id != 0)
                            window.location.href = ("/cart/payment/method-selector")
                        else{
                            location.reload()
                        }
                    })
                }
            } else {
                if(response.status == 201){
                    Swal.fire({
                        type: 'success',
                        text: 'Đăng ký tài khoản thành công!'
                    }).then(result => {
                        if (course_id != 0)
                            window.location.href = ("/cart/payment/method-selector")
                        else{
                            location.reload()
                        }
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
</script>