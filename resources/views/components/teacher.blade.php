<div class="col-sm-3">
    <div class="info">
        <div class="avatar text-center">
            <img class="" src="{{ $image }}">
        </div>
        <h3 class="name-teacher text-center text-center">{!! $name !!}</h3>
        <p class="des-teacher text-center">{!! $expert !!}</p>
        <div class="star-teacher text-center">
            @include(
                'components.vote', 
                [
                    'rate' => 2,
                    'rating_number' => 3500
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