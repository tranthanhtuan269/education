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
        <p class="price-b">{!! number_format($course->price, 0, ',' , '.') !!}<sup>₫</sup></p>
        @if($course->real_price != $course->price && $course->real_price != 0)
        <p class="price-s">{!! number_format($course->real_price, 0, ',' , '.') !!}<sup>₫</sup></p>
        <p class="price-o">Tiết kiệm {{(int)(100 - ($course->price/$course->real_price)*100)}}%</p>
        @endif

        <a href="/course/{{$course->slug}}">Đăng ký học</a>
    </div>
</div>