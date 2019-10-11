<?php
    $check_count = 0;
?>
<div class="container">
    <div class="popular-teacher">
        <div class="row">
            <div class="col-sm-12 title-module-home">
                <h2>Giảng viên tiêu biểu</h2>
            </div>
            @foreach ($popular_teacher as $teacher)
                @if ($teacher->userRole->user)
                    <?php
                        $count_course = count($teacher->userRole->userCoursesByTeacher()->where('status', 1));
                    ?>
                    @if( $count_course > 0 )
                        @include(
                            'components.teacher', 
                            [
                                'id' => $teacher->id,
                                'image' => $teacher->userRole->user->avatar,
                                'name' => $teacher->userRole->user->name,
                                'expert' => $teacher->expert,
                                // 'rate' => $teacher->rating_score,
                                // 'rating_number' => $teacher->vote_count,
                                'course_number' => $count_course,
                                'student_number' => $teacher->student_count
                            ]
                        )
                    <?php $check_count++; ?>
                    @endif
                    @if ( $check_count == 4 )
                        @break;
                    @endif
                @endif

            @endforeach
        </div>
    </div>
    <div class="feature-website">
        <div class="row">
            <div class="col-sm-4 course-feature">
                <div class="symbol-format">
                    <img src="{{ asset('frontend/images/features_unlimited.png')}}">
                </div>
                <h3>Truy cập mọi lúc</h3>
                <p>Chọn những gì mà bạn muốn học từ thư viện rộng lớn của chúng tôi</p>
            </div>
            <div class="col-sm-4 course-feature">
                <div class="symbol-format">
                    <img src="{{ asset('frontend/images/features_teacher.png')}}">
                </div>
                <h3>Học từ chuyên gia</h3>
                <p>Học từ những chuyên gia, những giảng viên đam mê truyền tải kiến thức cho mọi người </p>
            </div>
            <div class="col-sm-4 course-feature">
                <div class="symbol-format">  
                    <img src="{{ asset('frontend/images/features_devices.png')}}">
                </div>
                <h3>Truy cập ở bất cứ đâu</h3>
                {{-- <p>Switch between your computer, tablet or mobile device.</p> --}}
                <p>Chỉ cần thiết bị của bạn truy cập được internet, bạn có thể học ngay từ Courdemy </p>
            </div>
        </div>
    </div>
</div>