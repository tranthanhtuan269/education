
<?php
    $rate_temp = $rate - (int) $rate;
    if(0 <= $rate_temp && $rate_temp < 0.25){
        $rate = (int)$rate;
    }else if(0.25 < $rate_temp && $rate_temp < 0.75){
        $rate = (int)$rate + 0.5;
    }else{
        $rate = (int)$rate + 1;
    }
?>
<span class="star-rate">
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
    <span class="n-rate">{!! number_format($rate, 1, ',' , '.') !!}(<span>{!! number_format($rating_number, 0, ',' , '.') !!}@if(isset($rating_txt)) ratings @endif</span>)</span>
@endif
