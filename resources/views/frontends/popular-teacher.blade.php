<div class="container">
    <div class="popular-teacher">
        <div class="row">
            <div class="col-xs-12 title-module-home">
                <h2>Popular Teacher</h2>
            </div>
            @for($i = 0; $i < 4; $i++)
                @include(
                    'components.teacher', 
                    [
                        'image' => 'https://www.w3schools.com/howto/img_avatar.png',
                        'name' => 'Bảo Minh',
                        'expert' => 'PHP, Jquery, VueJs',
                        'rate' => 4.6,
                        'rating_number' => 11900,
                        'course_number' => 36,
                        'student_number' => 3600
                    ]
                )
            @endfor
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