@extends('frontends.layouts.app') @section('content')
<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.menu')
            </div>
        </div>
    </div>
</div>
<style>
    a.btn.btn-warning.margin-left.pull-right {
        margin-top: -8px;
    }
</style>

<div class="container">
    <div class="right">
        <div id="main-content">
            <!--  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span style="font-weight: bold;"><i class="fa fa-user" aria-hidden="true"></i> Profile</span>
                    <a href="https://unica.vn/dashboard/user/password" class="btn btn-warning margin-left pull-right"><i class="fa fa-lock"></i> Change password</a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form id="w0" action="/dashboard/user/profile" method="post" enctype="multipart/form-data">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group" style="margin-bottom: 47px;">
                                    <label style="margin-bottom: 10px;">Choose Image</label>
                                    <br>
                                    <img class="show_image" src="https://unica.vn/icon/profile.png" style="width: 100px; height: 100px;">
                                    <label id="bb" class="absolute" style="display: none;">
                                        <div id="edit-avatar" role="button" class="GVb" style="-webkit-user-select: none;"></div>
                                        <div class="form-group field-File">
                                            <input type="hidden" name="MUser[Avatar]" value=""><input type="file" id="File" name="MUser[Avatar]" value="https://unica.vn/icon/profile.png">
                                            <p class="help-block help-block-error" style="display: none;"></p>
                                        </div>
                                    </label>
                                    {{-- <p style="margin-top:10px;">(Ảnh vuông và &lt;500KB)</p> --}}
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <div class="form-group field-muser-address">
                                        <textarea class="form-control" rows="5" cols="50"></textarea>
                                    </div>
                                </div>
                                <div class="form-group" style="padding-top: 19px;">
                                    <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Full name</label>
                                    <div class="form-group field-muser-fullname required">
                                        <input type="text" id="muser-fullname" class="form-control" name="MUser[Fullname]" value="Tranvanba1992@gmail.com">
                                        <p class="help-block help-block-error" style="display: none;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><i title="Email chưa xác thực" class="fa fa-envelope color-red"></i> Email </label>
                                    <div class="form-group field-muser-email required">
                                        <input type="email" id="muser-email" class="form-control" name="MUser[Email]" value="tranvanba1992@gmail.com" disabled>
                                        <p class="help-block help-block-error" style="display: none;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <div class="form-group field-muser-phone required">
                                        <input type="text" id="muser-phone" class="form-control" name="MUser[Phone]" value="0989278118">
                                        <p class="help-block help-block-error" style="display: none;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Birthday</label>
                                    <div class="form-group field-selector_id">
                                        <input type="text" id="selector_id" class="form-control" name="MUser[Birthday]" value="01-01-1970" placeholder="vd : 01-01-1990" maxlength="10">
                                        <p class="help-block help-block-error" style="display: none;"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Sex</label>
                                    <div class="form-group field-muser-gender required">
                                        <select id="muser-gender" class="form-control" name="MUser[Gender]">
                                            <option value="0">Female</option>
                                            <option value="1" selected="">Male</option>
                                        </select>
                                        <p class="help-block help-block-error" style="display: none;"></p>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label>Kết nối facebook</label>
                                    <br>
                                    <button onclick="login()" type="button" class="btn btn-primary"><i class="fa fa-facebook"></i> Kết nối</button>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button class="errorCode hidden" data-toggle="modal" data-target="#errorUser"></button>
        <div id="errorUser" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Thông báo yêu cầu đổi email và mật khẩu</h4>
                    </div>
                    <div class="modal-body">
                        <p>Vì lý do bảo mật, bạn vui lòng thay đổi địa chỉ email và mật khẩu để tiếp tục vào học</p>
                    </div>
                </div>
            </div>
        </div>
        <script src="/media/js/flatpickr.min.js"></script>
        <script>
            /* $('#selector_id').flatpickr({
                dateFormat: "d-m-Y",
                time_24hr: true,
                enableTime: false,
                enableSeconds: false
                }); */
            
            $('#selector_id').mask('99-99-9999', {placeholder: "vd : 01-01-1990"});
            
            $('.vertify_email').click(function () {
                $.ajax({
                    url: '/create/vtfemail',
                    type: 'POST',
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    complete: function () {
                        $('.loading').hide();
                    },
                    success: function (result) {
                        if (result.success) {
                            location.reload();
                        }
                    }
                });
            });
            
            
            setTimeout(function () {
                $('.help-block').hide();
            }, 10000);
            
        </script>
        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '1550669198563386',
                    xfbml: true,
                    version: 'v2.10'
                });
            };
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            
            function login() {
                FB.login(function (response) {
                    if (response.status === 'connected') {
                        var url = window.location.href;
                        var arguments = url.split('?');
                        var ip = $('body').find('input[name=ip]').val();
                        getInfo(arguments[1], ip);
                    } else if (response.status === 'not_authorized') {
                        console.log(response.status);
                    } else {
                        console.log(response.status);
                    }
            
                }, {scope: 'email'});
            }
            // get user basic info
            function disconnect() {
                var cf = confirm("Bạn chắc chắn muốn hủy kết nối đến facebook");
                if (cf) {
                    $.ajax({
                        url: '/create/fbdisconnect',
                        type: 'post',
                        success: function (response) {
                            location.reload();
                        }
                    })
                }
            }
            
            function getInfo(params, ip) {
                FB.api('/me', 'GET', {fields: 'id, name, email, link, birthday, gender'}, function (response) {
                    $.ajax({
                        url: '/create/fbupdate',
                        type: 'post',
                        data: {
                            'id': response['id'],
                        },
                        success: function (response) {
                            location.reload();
                        }
                    })
            
                });
            }
            
            $(".show_image, #bb").hover(function () {
                $('#bb').show();
            }, function () {
                $('#bb').hide();
            });
            console.log("xxxx");
        </script>                  
    </div>
    <!--end right-->
    <div style="clear:both;"></div>
</div>

@endsection