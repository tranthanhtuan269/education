<div class="container">
    <div class="popular-teacher">
        <div class="row">
            <div class="col-xs-12 title-module-home">
                <h2>Popular Teacher</h2>
            </div>
            @foreach ($popular_teacher as $teacher)
                @include(
                    'components.teacher', 
                    [
                        'id' => $teacher->userRole->user->id,
                        'image' => url($teacher->userRole->user->avatar),
                        'name' => $teacher->userRole->user->name,
                        'expert' => $teacher->expert,
                        'rate' => $teacher->rating_score,
                        'rating_number' => $teacher->vote_count,
                        'course_number' => $teacher->course_count,
                        'student_number' => $teacher->student_count
                    ]
                )
            @endforeach
        </div>
    </div>
    <div class="feature-website">
        <div class="row">
            <div class="col-sm-4 course-feature">
                <div class="symbol-format">
                    <img src="{{ asset('frontend/images/features_unlimited.png')}}">
                </div>
                <h3>Unlimited Access</h3>
                <p>Choose what you'd like to learn from our extensive subscription library.</p>
            </div>
            <div class="col-sm-4 course-feature">
                <div class="symbol-format">
                    <img src="{{ asset('frontend/images/features_teacher.png')}}">
                </div>
                <h3>Expect Teacher</h3>
                <p>Learn from industry experts who are passionate about teaching.</p>
            </div>
            <div class="col-sm-4 course-feature">
                <div class="symbol-format">  
                    <img src="{{ asset('frontend/images/features_devices.png')}}">
                </div>
                <h3>Learn Anywhere</h3>
                <p>Switch between your computer, tablet or mobile device.</p>
            </div>
        </div>
    </div>
</div>