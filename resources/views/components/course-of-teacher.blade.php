<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }

    // dd($list_bought)
    // dd($course->id)
?>

<div class="ubc-course">
    <div class="img-ubc-course">
    <a href="/course/{{$course->slug}}">
    <img class="img-responsive" src="{{$course->image}}" alt="{{$course->name}}">
        </a>
    </div>
    <div class="des-ubc-course">
        <p><a href="/course/{{$course->slug}}">{{$course->name}}</a></p>
        <ul class="mini-des">
            <li><i class="fa fa-list-alt fa-fw" aria-hidden="true"></i> {{$course->video_count}} bài giảng</li>
            <li><i class="far fa-clock fa-fw" aria-hidden="true"></i> {{ intval($course->duration / 3600) }} giờ {{ intval($course->duration % 60 ) }} phút</li>

        </ul>
        {{-- <ul class="big-des">
            <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Nắm được 36 thế Yoga giúp tăng cường sinh lý</li>
            <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Cải thiện hạnh phúc gia đình</li>
            <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Lấy lại cân bằng cho cuộc sống</li>
            <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Cải thiện sinh lý tự nhiên mà không cần thuốc</li>
        </ul> --}}
        @php
            $will_learn = $course->will_learn;
            $will_learn = explode(";;", $will_learn);
            $will_learn = array_filter($will_learn, function($will){
                $will = trim($will);
                return $will != '';
            });
            // $will_learn = json_decode($will_learn);
        @endphp
        @if ($will_learn != null)
            <ul class="big-des">
                @foreach ($will_learn as $key => $will)
                <?php                          
                if(count(explode(" ",trim($will," "))) < 2) continue;
                ?>
                @if( $key > 3 )
                <li>
                    <i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i>...
                </li>
                @break
                @endif
                <li>
                    <i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i>{!! ltrim($will,";") !!}
                </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="lp-bc-price">
        <p class="price-b">{!! number_format($course->price, 0, ',' , '.') !!}<sup>₫</sup></p>
        @if($course->real_price != $course->price && $course->real_price != 0)
        <p class="price-s">{!! number_format($course->real_price, 0, ',' , '.') !!}<sup>₫</sup></p>
        <p class="price-o">Tiết kiệm {{(int)(100 - ($course->price/$course->real_price)*100)}}%</p>
        @endif

        {{-- <a href="/course/{{$course->slug}}">Thêm vào giỏ hàng</a> --}}
        <div class="teacher-course">
            @if (in_array($course->id, $list_bought))
            <div class="btn btn-danger" disabled><b>BẠN ĐÃ MUA KHÓA HỌC NÀY</b></div>
            @else
            <div id="add-cart" data-id="{{ $course->id }}" class="btn btn-danger"><b>THÊM VÀO GIỎ HÀNG</b></div>
            @endif
        </div>
    </div>
</div>

<script>

    jQuery(function () {
        $(".teacher-course #add-cart").click( function(e){
            e.stopPropagation()
            e.preventDefault()

            $(this).html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
            
            addCard();
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
                $('.teacher-course #add-cart').html('<b>ĐÃ THÊM VÀO GIỎ HÀNG</b>').attr('disabled', true)
                // $(".sidebar-add-cart button").off()
            });
        }
    })

    function addCard(){
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