<div class="col-sm-3">
    <div class="info">
        <div class="avatar text-center">
            <img class="" src="{{ $image }}">
        </div>
        <h3 class="name-teacher text-center text-center">{!! $name !!}</h3>
        <p class="des-teacher text-center">{!! $expert !!}</p>
        <div class="star-teacher text-center">
            <span class="star-rate">
                <!-- @for($i = 1; $i < $rate; $i++)
                <i class="fa fa-star co-or" aria-hidden="true"></i>
                @endfor
                @if(!is_integer($rate))
                <i class="fas fa-star-half-alt"></i>
                @endif
                @for($i = 1; $i < 5 - $rate; $i++)
                <i class="far fa-star"></i>
                @endfor -->
                <!-- <?php //$rate = 3.5; ?> -->
                @for($i = 1; $i <= 5; $i++)
                    @if(!is_integer($rate) && ($rate +0.5 == $i))
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="fa fa-star co-or" aria-hidden="true"></i>
                    @endif
                @endfor
                <!-- <i class="fa fa-star co-or" aria-hidden="true"></i>
                <i class="fa fa-star co-or" aria-hidden="true"></i>
                <i class="fa fa-star co-or" aria-hidden="true"></i>
                <i class="fas fa-star-half-alt"></i> -->
            </span>
            <span class="n-rate">{{ $rate }} (<span>{!! number_format($rating_number, 0, ',' , '.') !!} ratings</span>)</span>
        </div>
        <div class="clearfix">
            <span class="number-course"><i class="fas fa-book"></i> {!! number_format($course_number, 0, ',' , '.') !!} Course</span>
            <span class="pull-right">
                <i class="fas fa-user-graduate"></i>
                {!! number_format($student_number, 0, ',' , '.') !!} Students
            </span>
        </div>
    </div>
</div>