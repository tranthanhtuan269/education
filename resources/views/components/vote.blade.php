
<?php
    $avg_star = $rate;
    $rate_temp = $rate - (int) $rate;
    if(0 <= $rate_temp && $rate_temp < 0.25){
        $rate = (int)$rate;
    }else if(0.25 < $rate_temp && $rate_temp < 0.75){
        $rate = (int)$rate + 0.5;
    }else{
        $rate = (int)$rate + 1;
    }
    // dd($avg_star)
?>
<span class="star-rate">
    <!-- <i class="fa fa-star co-or" aria-hidden="true"></i> -->
    @for($i = 1; $i <= $rate; $i++)
    <i class="fa fa-star co-or" aria-hidden="true"></i>
    @endfor

    @if(!is_integer($rate))
    <i class="fas fa-star-half-alt"></i>
    @endif

    @for($i = 1; $i <= 5 - $rate; $i++)
    <i class="far fa-star"></i>
    @endfor
</span>

@if(isset($rating_number) && isset($rate))
    <span class="n-rate">
        {!! number_format($avg_star, 1, ',' , '.') !!}&nbsp;
        (<span>{!! $rating_number !!}@if(isset($rating_txt)) đánh giá @endif</span>)
    </span>
@endif
