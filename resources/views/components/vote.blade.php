<span class="star-rate">
    @for($i = 1; $i < $rate; $i++)
    <i class="fa fa-star co-or" aria-hidden="true"></i>
    @endfor

    @if(!is_integer($rate))
    <i class="fas fa-star-half-alt"></i>
    @endif

    @for($i = 1; $i < 5 - $rate; $i++)
    <i class="far fa-star"></i>
    @endfor
</span>
<span class="n-rate">{{ $rate }} (<span>{!! number_format($rating_number, 0, ',' , '.') !!} ratings</span>)</span>