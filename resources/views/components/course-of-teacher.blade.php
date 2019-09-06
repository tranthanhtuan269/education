<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
    // dd($course->userRoles[0]->user_id)
    // dd(Auth::user()->id)
?>

<div class="ubc-course">
    <div class="img-ubc-course">
    <a href="/course/{{$course->slug}}">
        @if(filter_var($course->image, FILTER_VALIDATE_URL))
            <img class="img-responsive" src="{{$course->image}}" alt="{{$course->name}}">
        @else
            <img class="img-responsive" src="{{ asset('frontend/images/'.$course->image)}}" alt="{{$course->name}}">
        @endif
    </a>
    </div>
    <div class="des-ubc-course">
        <p><a href="/course/{{$course->slug}}">{{$course->name}}</a></p>
        <ul class="mini-des">
            <li><i class="fa fa-list-alt fa-fw" aria-hidden="true"></i> {{$course->video_count}} bài giảng</li>
            <li><i class="far fa-clock fa-fw" aria-hidden="true"></i> {{ intval($course->duration / 3600) }} giờ {{ intval($course->duration % 60 ) }} phút</li>
        </ul>
        <?php 
            $will_learn = $course->will_learn;
            if(count(explode("</li>", $will_learn)) > 3){
                $will_learn = explode("</li>", $will_learn);
                $will_learn = $will_learn[0]."</li>".$will_learn[1]."</li>".$will_learn[2]."</li>".$will_learn[3]."<li>...</li>";
            }
        ?>
        <div class="clearfix course-des-{{$course->id}}">
            <div class="row">
                <div class="col-sm-12 big-des">
                    {!! $will_learn !!}
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function (){
                $('.course-des-{{$course->id}} .row li').prepend('<i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i>')
            })
        </script>
    </div>
    <div class="lp-bc-price">
        <p class="price-b">{!! number_format($course->price, 0, ',' , '.') !!}<sup>₫</sup></p>
        @if($course->real_price != $course->price && $course->real_price != 0)
        <p class="price-s">{!! number_format($course->real_price, 0, ',' , '.') !!}<sup>₫</sup></p>
        <p class="price-o">Tiết kiệm {{(int)(100 - ($course->price/$course->real_price)*100)}}%</p>
        @endif

        <div class="teacher-course">
            @if (Auth::check())
                @if( (int)($course->userRoles[0]->user_id) == (int)(Auth::user()->id) )
                    <div id="add-cart" class="btn btn-primary" disabled><b>ĐÂY LÀ KHÓA HỌC CỦA BẠN</b></div>
                @else
                    @if (in_array($course->id, $list_bought))
                        <div id="add-cart" class="btn btn-primary" disabled><b>BẠN ĐÃ MUA KHÓA HỌC NÀY</b></div>
                    @else
                        <div id="add-cart" data-id="{{ $course->id }}" class="btn btn-primary"><b>THÊM VÀO GIỎ HÀNG</b></div>
                    @endif
                @endif     
            @else
            <div id="add-cart" data-id="{{ $course->id }}" class="btn btn-primary"><b>THÊM VÀO GIỎ HÀNG</b></div>
            @endif
        </div>
    </div>
</div>

<script>
    var course_id = Number( {{ $course->id }} )
    jQuery(function () {
        $(".teacher-course #add-cart").click( function(e){
            e.stopPropagation()
            e.preventDefault()

            $(this).html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
            
            addCart();
            Swal.fire({
                type: 'success',
                text: 'Đã thêm vào giỏ hàng!'
            })
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'));
            $('.number-in-cart').text(number_items_in_cart.length);
            $('.unica-sl-cart').css('display', 'block')
            // console.log(number_items_in_cart.length)
        })

        if(localStorage.getItem('cart') != null){
            var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))

            $.each( number_items_in_cart, function(i, obj) {
                if(course_id == Number(obj.id)){
                    $('.teacher-course #add-cart').html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
                }
            });
        }
    })

    function addCart(){
        var item = {
            'id' : {!! $course->id !!},
            'image' : '{!! $course->image !!}',
            'slug' : '{!! $course->slug !!}',                
            @if(count($course->Lecturers()) > 0)
            'lecturer' : "{!! $course->Lecturers()[0]->user->name !!}",
            @else
            'lecturer' : 'Nhiều giảng viên',
            @endif
            'name' : "{!! $course->name !!}",
            'price' : {!! $course->price !!},
            'real_price' : {!! $course->real_price !!},
            'coupon_price' : {!! $course->price !!},
            'coupon_code' : '',
        }

        if (localStorage.getItem("cart") != null) {
            var list_item = JSON.parse(localStorage.getItem("cart"));
            addItem(list_item, item);
            localStorage.setItem("cart", JSON.stringify(list_item));
        }else{
            var list_item = [];
            addItem(list_item, item);
            localStorage.setItem("cart", JSON.stringify(list_item));
        }

        var number_items_in_cart = JSON.parse(localStorage.getItem('cart'))
            // alert(number_items_in_cart.length)
        $('.number-in-cart').text(number_items_in_cart.length);
    }
</script>