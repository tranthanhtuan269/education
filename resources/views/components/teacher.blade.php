<div class="col-md-3 col-sm-6">
    <div class="info">
        <div class="avatar text-center">
            <a href="{{ url('/') }}/teacher/{{ $id }}" title="{{ $name }}">
                @if (strpos($image, 'unica') !== false)
                    <img class="" src="{{ $image }}">
                @else
                    <img class="" src="{{ url('frontend/'.$teacher->userRole->user->avatar) }}">
                @endif
            </a>
        </div>
        <div class="name-teacher text-center">
            <a href="{{ url('/') }}/teacher/{{ $id }}" title="{{ $name }}">
                <span>
                    {!! $name !!}
                </span>
            </a>
        </div>
        <div class="des-teacher text-center" title="{!! $expert !!}">{{ $expert }}</div>
        <div class="clearfix">
            <span class="number-course"><i class="fas fa-book"></i> {!! number_format($course_number, 0, ',' , '.') !!} khóa học</span>
            <span class="pull-right number-student">
                <i class="fas fa-user-graduate"></i>
                {!! number_format($student_number, 0, ',' , '.') !!} học viên
            </span>
        </div>
    </div>
</div>