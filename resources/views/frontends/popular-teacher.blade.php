<div class="container">
    <div class="popular-teacher">
        <div class="row">
            <div class="col-xs-12 title-module-home">
                <h2>Popular Teacher</h2>
            </div>
            @for($i = 0; $i < 4; $i++)
            <div class="col-sm-3">
                <div class="info">
                    <div class="avatar text-center">
                        <img class="" src="https://www.w3schools.com/howto/img_avatar.png" >
                    </div>
                    <h3 class="name-teacher text-center text-center">Bảo Minh</h3>
                    <p class="des-teacher text-center">PHP, Jquery, VueJs</p>
                    <div class="star-teacher text-center">
                        <span class="star-rate">
                        <i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i><i class="fa fa-star co-or" aria-hidden="true"></i>                </span>
                        <span class="n-rate">4.5 (<span>11.990 ratings</span>)</span>
                    </div>
                    <div class="clearfix"> 
                        <span class="number-course"><i class="fas fa-book"></i> 22 Course</span>
                        <span class="pull-right">
                        <i class="fas fa-user-graduate"></i> 
                        111.190 Students
                        </span>
                    </div>
                </div>
            </div>
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