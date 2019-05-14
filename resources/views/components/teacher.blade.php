<div class="col-sm-3">
    <div class="box-course">
        <a href="{{ url('/') }}/teacher/{{ $id }}" title="{{ $name }}" class="course-box-slider pop">
            <div class="avatar text-center">
                <img class="" src="{{ $image }}">
            </div>
            <h3 class="name-teacher text-center text-center">{!! $name !!}</h3>
        </a>
        <p class="des-teacher text-center">{!! $expert !!}</p>
        <div class="star-teacher text-center">
            @include(
                'components.vote', 
                [
                    'rate' => $rate,
                    'rating_number' => $rating_number
                ]
            )
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