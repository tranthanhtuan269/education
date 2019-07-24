<div class="col-md-3 col-sm-6">
    <div class="info">
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
            <span class="number-course"><i class="fas fa-book"></i> {!! number_format($course_number, 0, ',' , '.') !!} khóa học</span>
            <span class="pull-right number-student">
                <i class="fas fa-user-graduate"></i>
                {!! number_format($student_number, 0, ',' , '.') !!} học viên
            </span>
        </div>
    </div>
</div>