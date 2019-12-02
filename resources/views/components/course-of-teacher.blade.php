<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
    $course_duration = $course->totalDuration($course);
?>

<div class="ubc-course">
    <div class="img-ubc-course">
    <a href="/course/{{$course->id}}/{{$course->slug}}">
        {{-- @if(filter_var($course->image, FILTER_VALIDATE_URL)) --}}
        @if (strpos($course->image, 'http') !== false)
            <img class="img-responsive" src="{{$course->image}}" alt="{{$course->name}}">
        @else
            <img class="img-responsive" src="{{ asset('frontend/images/'.$course->image)}}" alt="{{$course->name}}">
        @endif
    </a>
    </div>
    <div class="des-ubc-course">
        <p><a href="/course/{{$course->id}}/{{$course->slug}}">{{$course->name}}</a></p>
        <ul class="mini-des">
            <li><i class="fa fa-list-alt fa-fw" aria-hidden="true"></i> {{$course->all_videos()}} bài giảng</li>
            <li><i class="far fa-clock fa-fw" aria-hidden="true"></i> {{ intval($course_duration / 3600) }} giờ {{ intval(($course_duration % 3600 ) / 60) }} phút</li>
        </ul>
        <?php 
            $will_learn = $course->will_learn;
            $will_learn = str_replace('<li>','<br>',$will_learn);
            $will_learn = str_replace('<p>','<br>',$will_learn);
            $will_learn = explode("<br>", $will_learn);
            $counter_w = count($will_learn);
            for( $i = 0 ; $i < $counter_w ; $i++){
                $will_learn[$i] = trim($will_learn[$i]);
                $will_learn[$i] = strip_tags($will_learn[$i]);
            }
            $will_learn = array_filter($will_learn);
            $number_w = 0;
        ?>
        <div class="clearfix course-des-{{$course->id}}">
            <div class="row">
                <div class="col-sm-12 big-des">
                    <ul style="list-style: none">
                        @for( $i = 0 ; $i < $counter_w ; $i++)
                            @if(isset($will_learn[$i]))
                                <li><span><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></span>{!!$will_learn[$i]!!}</li>
                                <?php $number_w++ ?>
                                @if( $number_w == 4 )
                                    {{-- <li><span><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></span>...</li> --}}
                                    @break
                                @endif
                            @endif
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="lp-bc-price">
        <p class="price-b" style="float:none">
            {{-- @if ( gettype($course->price) == 'integer' ) --}}
                {!! number_format($course->price, 0, ',' , '.') !!}<sup>₫</sup>
            {{-- @else
                {!!$course->price!!}
            @endif --}}
        </p>
        @if($course->real_price != $course->price && $course->real_price != 0)
        <div class="">
            <span class="price-s">{!! number_format($course->real_price, 0, ',' , '.') !!}<sup>₫</sup></span>
            <span class="price-o">Tiết kiệm {{(int)(100 - ($course->price/$course->real_price)*100)}}%</span>
        </div>
        @endif

        <div class="teacher-course">
            @if (Auth::check())
                @if (!Auth::user()->isAdmin())
                    @if( (int)($course->userRoles[0]->user_id) == (int)(Auth::user()->id) )
                        <button id="addCart{{ $course->id }}" class="btn btn-primary" disabled><b>ĐÂY LÀ KHÓA HỌC CỦA BẠN</b></button>
                    @else
                        @if (in_array($course->id, $list_bought))
                            <button id="addCart{{ $course->id }}" class="btn btn-primary" disabled><b>BẠN ĐÃ MUA KHÓA HỌC NÀY</b></button>
                        @else
                            <button id="addCart{{ $course->id }}" data-id="{{ $course->id }}" class="btn btn-primary add-to-cart"><b>THÊM VÀO GIỎ HÀNG</b></button>
                            <button id="buyNow{{ $course->id }}" data-id="{{ $course->id }}" class="btn btn-warning"><b>MUA NGAY</b></button>
                        @endif
                    @endif     
                @endif
            @else
                <button id="addCart{{ $course->id }}" data-id="{{ $course->id }}" class="btn btn-primary add-to-cart"><b>THÊM VÀO GIỎ HÀNG</b></button>
                <button id="buyNowLogin{{ $course->id }}" data-toggle="modal" data-target="#modalLoginCourseDetail" data-dismiss="modal" class="btn btn-warning"><b>MUA NGAY</b></button>
            @endif
        </div>
    </div>
</div>
@if ( !Auth::check() )
<div id="modalLoginCourseDetail" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">				
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><b>Đăng nhập vào tài khoản Courdemy của bạn</b></div>
            </div>
            <div class="modal-body">
                <br/>
                <form action="/examples/actions/confirmation.php" method="post">
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-envelope fa-fw fa-md"></i></span>
                            <input type="t" class="form-control" name="email" placeholder="Email" required="required">
                            <div class="form-html-validate login_email"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                            <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required" id="courseShowMyPassword">
                            <div class="show-password" onclick="courseShowPassword()">
                                <i class="fas fa-eye fa-fw fa-md" id="eye"></i>
                            </div>
                            <div class="form-html-validate login_password"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng nhập" onclick="loginCourseDetailAjax()">
                    </div>
                    <input id="resetCourseDetailFormsLogin" type="reset" value="Reset the form" style="display:none">
                </form>
                @if($_SERVER['SERVER_NAME'] === "courdemy.vn")
                    <hr>
                    @include('components.facebook-login')
                    @include('components.google-login')
                @endif
            </div>

            <div class="modal-footer">
                <div class="link-to-sign-up">
                    <div>
                        Bạn chưa có tài khoản? <a href="javascript:void(0)" data-toggle="modal" data-target="#modalRegisterCourseDetail" data-dismiss="modal"><b>Đăng ký</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalRegisterCourseDetail" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">				
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><b>Tạo tài khoản mới</b></div>
            </div>
            <div class="modal-body">
                <form action="/examples/actions/confirmation.php" method="post">
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-user fa-lock fa-fw fa-md"></i></span>
                            <input type="text" class="form-control" name="name" placeholder="Tên của bạn" required="required">
                            <div class="form-html-validate name"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-envelope fa-envelope fa-fw fa-md"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                            <div class="form-html-validate email"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                            <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required">
                            <div class="form-html-validate password"></div>
                        </div>				
                    </div>
                    <div class="form-group">
                        <div class="input-group form-html">
                            <span class="input-group-addon"><i class="fas fa-lock fa-fw fa-md"></i></span>
                            <input type="password" class="form-control" name="confirmpass" placeholder="Nhập lại mật khẩu" required="required">
                            <div class="form-html-validate confirmpassword"></div>
                        </div>				
                    </div>
                    {{-- <div class="terms-and-policy">
                        <label class="checkbox-inline"><input type="checkbox">You agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>!</label>
                    </div> --}}
                    <div class="form-group">
                        <input type="button" class="btn btn-success btn-block btn-lg" value="Đăng ký" onclick="registerCourseDetailAjax()">
                    </div>
                    <input id="resetCourseDetailFormsSignup" type="reset" value="Reset the form" style="display:none">
                </form>				
            </div>
            <div class="modal-footer">
                <div class="link-to-sign-up">
                    <div>
                        Bạn đã có tài khoản? <a href="javascript:void(0)" data-toggle="modal" data-target="#modalLoginCourseDetail" data-dismiss="modal"><b>Đăng nhập</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script>
    var user_id = $('button[id=cartUserId]').attr('data-user-id')
    var course_id = Number( {{ $course->id }} )
    jQuery(function () {

        $("#buyNow{{ $course->id }}").click(function(){
            addCart();
            window.location.href =("/cart/payment/method-selector")
        })

        $("#buyNowLogin{{ $course->id }}").click(function(){
            addCart();
        })

        $("#addCart{{ $course->id }}").click( function(){

            $(this).html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
            addCart()

            Swal.fire({
                type: 'success',
                text: 'Đã thêm vào giỏ hàng!'
            })
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id));
            $('.number-in-cart').text(number_items_in_cart.length);
            $('.unica-sl-cart').css('display', 'block')
        })

        function addCart(){
            var course_id = {!! $course->id !!}
            course_id = Number(course_id)
            var check = true
            
            if(localStorage.getItem('cart'+user_id) != null){
                var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))

                $.each( number_items_in_cart, function(i, obj) {
                    if( course_id == Number(obj.id) ){
                        check = false
                    }
                });
            }
            if(check){
                var item = {
                    'id' : {!! $course->id !!},
                    'image' : '{!! $course->image !!}',
                    'slug' : '{!! $course->slug !!}',                
                    @if(count($course->Lecturers()) > 0)
                    'lecturer' : "@if($course->Lecturers()[0]->user){!! $course->Lecturers()[0]->user->name !!}@else Courdemy @endif",
                    @else
                    'lecturer' : 'Nhiều giảng viên',
                    @endif
                    'name' : "{!! $course->name !!}",
                    'price' : {!! $course->price !!},
                    'real_price' : {!! $course->real_price !!},
                    'coupon_price' : {!! $course->price !!},
                    'coupon_code' : '',
                }
        
                if (localStorage.getItem('cart'+user_id) != null) {
                    var list_item = JSON.parse(localStorage.getItem('cart'+user_id));
                    addItem(list_item, item);
                    localStorage.setItem('cart'+user_id, JSON.stringify(list_item));
                }else{
                    var list_item = [];
                    addItem(list_item, item);
                    localStorage.setItem('cart'+user_id, JSON.stringify(list_item));
                }
        
                var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))
                $('.number-in-cart').text(number_items_in_cart.length);
            }
        }

        // Tai tren Footer 
        // if(localStorage.getItem('cart'+user_id) != null){
        //     var number_items_in_cart = JSON.parse(localStorage.getItem('cart'+user_id))

        //     $.each( number_items_in_cart, function(i, obj) {
        //         $('.teacher-course button[id=addCart'+obj.id+']').html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
        //     });
        // }

    })
    function loginCourseDetailAjax(){
        var email = $('#modalLoginCourseDetail input[name=email]').val();
        email = email.trim();
        var password = $('#modalLoginCourseDetail input[name=pass]').val();
        var remember = $('#modalLoginCourseDetail input[name=remember]').prop('checked');
        var data = {
            login_email     : email,
            login_password  : password,
            course_id: {{$course->id}},
        };
        $.ajaxSetup(
        {
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: '{{ url("loginAjax-course-detail") }}',
            data: data,
            dataType: 'json',
            success: function (response) {
                if(response.status == 200){
                    $('#modalLoginCourseDetail').modal('toggle');
                    if ( response.role == 1 ){
                        Swal.fire({
                            type: 'warning',
                            html: 'Chú là admin nên không thể mua khóa học. Hiểu chứ?',
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
                    }else if ( response.role ==3 ){
                        Swal.fire({
                            type: 'warning',
                            html: 'Bạn đã mua khóa học này.',
                        }).then((result)=>{
                            window.location.reload()
                        })
                    }else{
                        window.location.href = ("/cart/payment/method-selector")
                    }
                }else{
                    Swal.fire({
                        type: 'warning',
                        html: response.message,
                    })
                }
            },
            error: function (error) {
                $(".ajax_waiting").removeClass("loading");
                var obj_errors = error.responseJSON.errors;
                $('.form-html-validate').css('display', 'block')
                $('.form-html-validate').html('')
                $.each(obj_errors, function( index, value ) {
                    var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                    $('.form-html-validate.' + index).html(content);
                })
            }
        });
        return false;
    }
    function registerCourseDetailAjax(){
        var name = $('#modalRegisterCourseDetail input[name=name]').val();
        name = name.trim();
        var email = $('#modalRegisterCourseDetail input[name=email]').val();
        email = email.trim();
        var password = $('#modalRegisterCourseDetail input[name=pass]').val();
        var confirmpassword = $('#modalRegisterCourseDetail input[name=confirmpass]').val();
        var data = {
            name : name,
            email:email,
            password: password,
            confirmpassword: confirmpassword,
        };
        $.ajaxSetup(
        {
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: '{{ url("registerAjax") }}',
            data: data,
            dataType: 'json',
            success: function (response) {
                if(response.status == 200){
                    Swal.fire({
                        type: 'success',
                        html: response.message,
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = ("/cart/payment/method-selector")
                        }
                    });
                }else{
                    Swal.fire({
                        type: 'warning',
                        html: 'Error',
                    })
                }
            },
            error: function (error) {             
                $(".ajax_waiting").removeClass("loading");
                var obj_errors = error.responseJSON.errors;
                $('.form-html-validate').css('display', 'block')
                $('.form-html-validate').html('')
                $.each(obj_errors, function( index, value ) {
                    var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                    $('.form-html-validate.' + index).html(content);
                })
            }
        });
        return false;
    }
</script>