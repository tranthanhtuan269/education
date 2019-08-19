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
                <li><i class="far fa-clock fa-fw" aria-hidden="true"></i> {{$course->duration/60}} giờ {{$course->duration%60}} phút</li>
    
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
                    @foreach ($will_learn as $will)
                    <?php                          
                    if(count(explode(" ",trim($will," "))) < 2) continue;
                    ?>
                    <li>
                        <i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i>{!! ltrim($will,";") !!}
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="lp-bc-price">
            <p class="price-b">{!! number_format($course->price, 0, ',' , '.') !!}<sup>đ</sup></p>
            @if($course->real_price != $course->price)
            <p class="price-s">{!! number_format($course->real_price, 0, ',' , '.') !!}<sup>đ</sup></p>
            <p class="price-o">Tiết kiệm {{(int)(100 - ($course->price/$course->real_price)*100)}}</p>
            @endif
    
            <a href="/course/{{$course->slug}}">Đăng ký học</a>
        </div>
    </div>
 
    <style>
    .ubc-course { border: 1px solid #e0e0e0; background: #fff; padding: 10px 10px 5px 10px; border-radius: 3px; display: inline-block; width: 100%; margin-bottom: 10px; }
.ubc-course .price-b { float: right; }
.img-ubc-course { width: 30%; float: left; }
.des-ubc-course { width: 47%; float: left; margin-left: 20px; }
.des-ubc-course p { font-size: 16px; font-weight: bold; margin-bottom: 10px }
.mini-des { display: inline-block; margin-bottom: 10px; }
.mini-des li { float: left; margin-right: 20px; }
.big-des i { color: #0090ff; }
.big-des li { line-height: 25px; }
.lp-bc-price {    text-align: right;    font-weight: bold;    width: 20%;    float: right;}
.lp-bc-price .price-b {    font-size: 34px; text-decoration: none;}
.lp-bc-price .price-b sup {    font-size: 20px;}
.lp-bc-price .price-s {    font-size: 24px;    color: #696969;    text-decoration: line-through;}
.lp-bc-price .price-s sup {    font-size: 12px;}
.lp-bc-price .price-o {    font-size: 14px;    background: #f26522;    border-radius: 3px;    padding: 5px;    color: #fff;    display: inline-block;    margin: 10px 0;}
.lp-bc-price a {    background: #ff0000;    padding: 10px 20px;    text-transform: uppercase;    font-size: 16px;    text-align: center;    color: #fff;    display: inline-block;    width: 100%;    border-radius: 3px;}
    </style>