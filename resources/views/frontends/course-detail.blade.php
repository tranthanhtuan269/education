@extends('frontends.layouts.app')
@section('content')
<?php
    $percent_temp = 100;
    if($info_course->vote_count == 0) {
        $info_course->vote_count = 1;
        $percent_temp = 0;
    }

?>
<div class="detail-course">
    <img class="background" src="{{ asset('frontend/images/banner_profile_teacher.png') }}" width="100%" >
    <div class="container">
        <div class="row">
            <div class="item clearfix">
                <div class="col-sm-12">
                    <div class="frame clearfix">
                        <div class="pull-left">
                            <div class="info">
                                <p class="name">{{ $info_course->name }}</p>
                                <p class="expret">{{ $info_course->short_description }}</p>
                            </div>
                        </div>
                        <div class="network pull-right">
                            <a class="btn btn-default btn-xs" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url()->current()); ?>" target="_blank">
                                <i class="fas fa-share-alt"></i> Share
                            </a>
                            <a class="btn btn-default btn-xs" href="https://www.facebook.com/canhchimcodon26988" target="_blank">
                                <i class="fab fa-facebook-square"></i> Facebook
                            </a>
                        </div>
                    </div>
                    <div class="frame_2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row box clearfix">
                                    <?php
                                        $check_time_sale = false;
                                        if ($info_course->from_sale != '' && $info_course->to_sale != '') {
                                            $start_sale = strtotime($info_course->from_sale.' 00:00:00');
                                            $end_sale = strtotime($info_course->to_sale.' 23:59:59');
                                            $date_to = new DateTime($info_course->to_sale);
                                            $date_from = new DateTime(date('Y-m-d'));
                                            if (time() >= $start_sale && time() <= $end_sale) {
                                                $check_time_sale = true;
                                            }
                                        }
                                    ?>
                                    @if ($check_time_sale == true)                                        
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format($info_course->price, 0, ',' , '.') !!}đ</span>
                                        <span class="price">{!! number_format($info_course->real_price, 0, ',' , '.') !!}đ</span>
                                        <span class="interval">{{ $date_to->diff($date_from)->format("%d") }} days left off the price!</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="price-off pull-right">{{ round(100 - ($info_course->price/$info_course->real_price)*100,2) }}%  off</span>
                                    </div>
                                    @else
                                    <div class="col-sm-6 pull-left">
                                        <span class="sale">{!! number_format($info_course->real_price, 0, ',' , '.') !!}đ</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_duration.png') }}" class="icon" alt="" />  <span class="special">{{ $info_course->approx_time }} hours on-demand video</span>
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        <img src="{{ asset('frontend/images/ic_download.png') }}" class="icon" alt="" />  <span class="special">{{ $info_course->downloadable_count	 }} downloadable resources</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_lifetime.png') }}" class="icon" alt="" />  <span class="special">Full lifetime access</span>
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        <img src="{{ asset('frontend/images/ic_mtuli_device.png') }}" class="icon" alt="" />  <span class="special">Access on Mobile & TV</span>
                                    </div>
                                </div>
                                <div class="row box clearfix">
                                    <div class="col-sm-6 pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" class="icon" alt="" /> 
                                        <span class="special">{{ number_format($info_course->video_count, 0, ',' , '.') }} videos</span>
                                        &nbsp &nbsp<img src="{{ asset('frontend/images/icon_student.png') }}" class="icon" alt="" /> 
                                        <span class="special">{{ number_format($info_course->student_count, 0, ',' , '.') }} Students</span>                                        
                                    </div>
                                    <div class="col-sm-6 pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                                                'rating_number' => $info_course->vote_count,
                                                'rating_txt' => true
                                            ]
                                        )
                                    </div>
                                </div>
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        <button type="button" id="add-cart" class="btn btn-default btn-toh">Add to cart</button>
                                    </div>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-toh">By Now</button>
                                    </div>
                                </div>
                                <div class="box clearfix">
                                    <div class="pull-left">
                                        30-Days Money-back Guarantee
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY?controls=0"  frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu clearfix">
                <div class="col-sm-12">
                    <ul>
                        <li class="active"> About </li>
                        <li><a href="javascript:;" class="go-box" data-box="box_requirements">Requirements</a></li>
                        <li><a href="javascript:;" class="go-box" data-box="box_reviews">Reviews</a> </li>
                        @if (count($info_course->Lecturers()) >= 1) <li><a href="javascript:;" class="go-box" data-box="box_instructors">Instructors</a></li> @endif
                        <li><a href="javascript:;" class="go-box" data-box="box_related_course">Related Courses </a></li>
                    </ul>
                </div>
            </div>
            <div class="info clearfix">
                <div class="col-sm-8">
                    <div class="desc">
                        <h3>Descriptions</h3>
                        <p>
                            {!! $info_course->description !!}
                        </p>
                    </div>
                    <?php $will_learn = json_decode($info_course->will_learn); ?>
                    @if ($will_learn != '')
                    <div class="knowledge clearfix">
                        <h3>What you'll learn</h3>
                        <ul>
                                @foreach ($will_learn as $will)                            
                                <li>
                                    <img src="{{ asset('frontend/images/ic_check.png') }}" alt="" /> {!! $will !!}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (count($info_course->tags) > 0)
                    <div class="skill">
                        <h3>Skills you'll again</h3>
                        <ul>
                            @foreach ($info_course->tags as $tag)
                            <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col-sm-4">
                    <ul class="others">
                        <li>
                            <img src="{{ asset('frontend/images/features_online.png') }}" alt="" /> 
                            <span class="txt-large">100 Online</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/features_deadline.png') }}" alt="" /> 
                            <span class="txt-large">Flexible deadlines</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/features_level.png') }}" alt="" /> 
                            <span class="txt-large">Benginner Level</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        @if ($info_course->approx_time != '')
                        <li>
                            <img src="{{ asset('frontend/images/features_hour.png') }}" alt="" /> 
                            <span class="txt-large">Approx {{ $info_course->approx_time }} hours to complete</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                        @endif
                        <li>
                            <img src="{{ asset('frontend/images/features_subtitle.png') }}" alt="" /> 
                            <span class="txt-large">English</span>
                            <span class="txt-small">Content comming soon...</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lessons clearfix">
                <div class="col-sm-8">
                        @include('components.course-lesson-list')
                </div>
                <?php $requirements = json_decode($info_course->requirement); ?>
                @if ($requirements != '')                    
                <div class="col-sm-4">
                    <div class="requirement" id="box_requirements">
                        <h3>Requirement</h3>
                        <ul>
                            @foreach ($requirements as $requirement)
                            <li>{!! $requirement !!}</li>    
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if (count($info_course->Lecturers()) >= 1)
    <div class="instructors">
        <div class="container">
            <div class="row" id="box_instructors">
                <div class="col-sm-12">
                    <h3>About the instructors</h3>
                </div>
                @foreach ($info_course->Lecturers() as $lecturer)
                @php
                    // dd($lecturer);
                    
                @endphp
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ url('/') }}/teacher/{{ $lecturer->user->id }}" title="{{ $lecturer->user->name }}" >
                                <img class="avatar" alt="{{ $lecturer->user->name }}" src="{{ asset('frontend/'.$lecturer->user->avatar) }}">
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <div class="detail-info">
                                <p class="name"><a href="{{ url('/') }}/teacher/{{ $lecturer->user->id }}" title="{{ $lecturer->user->name }}" >{{ $lecturer->user->name }}</a></p>
                                <p class="expret">{{ $lecturer->expert }}</p>
                                <div class="frame clearfix">
                                    <div class="pull-left">
                                        <img src="{{ asset('frontend/images/ic_course.png') }}" alt="" /> 
                                        <span class="special">{{ $lecturer->teacher->course_count }} Courses</span>
                                    </div>
                                    <div class="pull-right">
                                        @include(
                                            'components.vote', 
                                            [
                                                'rate' => $lecturer->teacher->rating_score,
                                                'rating_number' => $lecturer->teacher->vote_count,
                                                'rating_txt' => true,
                                            ]
                                        )
                                    </div>
                                </div>
                                <div class="">
                                    <img src="{{ asset('frontend/images/icon_student.png') }}" alt="" /> 
                                    <span class="special">{{ $lecturer->teacher->student_count }} Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="course-learning-review">
            <div class="feedback clearfix">
                <div class="col-sm-4 student-rating">
                    <h3>Students Feedback</h3>
                    <p class="number">
                        {{ number_format(intval($info_course->star_count) / intval($info_course->vote_count), 1, ',' , '.') }}
                    </p>
                    <p class="star">
                        @include(
                            'components.vote', 
                            [
                                'rate' => intval($info_course->star_count) / intval($info_course->vote_count),
                            ]
                        )
                    </p>
                    <p>Course Rating</p>
                </div>
                <div class="col-sm-8 rating-process">
                    <div class="row">
                        <?php $tmp_percent_vote = 0; ?>
                        @for ($i = 5; $i <10; $i++)
                        <?php
                            if ($i == 5) {
                                $count_star = $info_course->five_stars;
                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                            } elseif ($i == 6) {
                                $count_star = $info_course->four_stars;
                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                            } elseif ($i == 7) {
                                $count_star = $info_course->three_stars;
                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                            } elseif ($i == 8) {
                                $count_star = $info_course->two_stars;
                                $percent_vote = number_format(($count_star / $info_course->vote_count)*100, 0, ',' , '.');
                            } else{
                                $count_star = $info_course->one_stars;
                                $percent_vote = $percent_temp;
                            }

                            $percent_temp -= (int)$percent_vote;
                        ?>
                        <div class="item-progress">
                            <div class="col-sm-9">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $percent_vote }}"
                                        aria-valuemin="0" aria-valuemax="100" style="width:{{ $percent_vote }}%"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @include(
                                    'components.vote', 
                                    [
                                        'rate' => 10 - $i,
                                    ]
                                )
                                <span class="percent-rating">{{ $percent_vote }}%</span>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="reviews"  id="box_reviews">
                <h3>Reviews
                    @if(Auth::check())
                        @if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                            <span class="reviews-star" data-star="{{ isset($ratingCourse) ? $ratingCourse->score : 1 }}">
                                @if($ratingCourse)
                                @include(
                                    'components.vote', 
                                    [
                                        'rate' => $ratingCourse->score,
                                    ]
                                )
                                @else
                                <i id="star-1" class="fa fa-star yellow-color" data-id="1"></i>
                                <i id="star-2" class="far fa-star review-star" data-id="2"></i>
                                <i id="star-3" class="far fa-star review-star" data-id="3"></i>
                                <i id="star-4" class="far fa-star review-star" data-id="4"></i>
                                <i id="star-5" class="far fa-star review-star" data-id="5"></i>
                                @endif
                            </span>
                        @endif
                    @endif
                </h3>
                @if(Auth::check())
                @if(\App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                <textarea name="content" id="editor" class="form-control" placeholder="Type the content here!"></textarea>
                <div class="btn-submit text-center mt-10 mb-20">
                    <input class="btn btn-primary submit-question" type="submit" value="SUBMIT A REVIEW" id="create-comment-new"/>
                </div>
                <script>
                    var baseURL = $('base').attr('href');

                    function hideStar(){
                        for(var j = 1; j <= 5; j++){
                            $('#star-' + j).removeClass('fa').addClass('far');
                        }
                    }

                    function showStar(i){
                        for(var j = 1; j <= i; j++){
                            $('#star-' + j).addClass('fa').removeClass('far');
                        }
                    }

                    $('.review-star').mouseenter(function(){
                        switch($(this).attr('data-id')){
                            case "1":
                                hideStar();showStar(1);
                                break;
                            case "2":
                                hideStar();showStar(2);
                                break;
                            case "3":
                                hideStar();showStar(3);
                                break;
                            case "4":
                                hideStar();showStar(4);
                                break;
                            case "5":
                                hideStar();showStar(5);
                                break;
                        }
                    }).mouseleave(function(){
                        hideStar();
                    }).click(function(){
                        showStar($(this).attr('data-id'))
                        $('.review-star').off( "mouseenter")
                        $('.review-star').off( "mouseleave")
                        $('.reviews-star').attr('data-star', $(this).attr('data-id'))
                    });

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#create-comment-new').on('click', function (e) {
                        var request = $.ajax({
                            url: baseURL + '/reviews/store',
                            method: "POST",
                            data: {
                                course_id: {{ $info_course->id }},
                                content : $('#editor').val(),
                                score: $('.reviews-star').attr('data-star')
                            },
                            dataType: "json"
                        });

                        request.done(function( data ) {
                            if(data.status == 200){
                                var html = "";
                                var htmlRate = $('.reviews-star').html();
                                html += '<div class="box clearfix">';
                                    html += '<div class="col-sm-3">';
                                        html += '<img class="avatar" src="'+baseURL + '/' + data.commentCourse.data.avatar +'" alt="">';
                                        html += '<div class="info-account">';
                                            html += '<p class="interval">' + data.commentCourse.data.created_at +'</p>';
                                            html += '<p class="name">' + data.commentCourse.data.username +'</p>';
                                        html += '</div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-9">';
                                        html += htmlRate;

                                        html += '<p class="comment">';
                                            html += data.commentCourse.data.content;
                                        html += '</p>';
                                        html += '<div class="btn-action">';
                                            html += '<button type="button" class="btn btn-default btn-reply" data-comment-id="'+data.commentCourse.data.id+'">';
                                                html += '<i class="fas fa-comment"></i>';
                                                html += '<span>Reply</span>';
                                            html += '</button>';
                                            html += '<button type="button" class="btn btn-default btn-like" data-comment-id="'+data.commentCourse.data.id+'">';
                                                html += '<i class="fas fa-thumbs-up"></i>';
                                                html += '<span>Like</span>';
                                            html += '</button>';
                                            html += '<button type="button" class="btn btn-default btn-dislike" data-comment-id="'+data.commentCourse.data.id+'">';
                                                html += '<i class="fas fa-thumbs-down"></i>';
                                                html += '<span>Dislike</span>';
                                            html += '</button>';
                                        html += '</div>';
                                        html += '<div id="reply-textbox-'+data.commentCourse.data.id+'" class="reply-textbox hide">';
                                            html += '<textarea name="reply-'+data.commentCourse.data.id+'" id="reply-'+data.commentCourse.data.id+'" class="form-control" placeholder="Type the content here!"></textarea>';
                                            html += '<div class="btn-submit text-center mt-10 mb-20">';
                                                html += '<input class="btn btn-primary create-reply-btn" type="submit" value="SUBMIT A REPLY" id="create-reply-'+data.commentCourse.data.id+'" data-id="'+data.commentCourse.data.id+'"/>';
                                            html += '</div>';
                                        html += '</div>';
                                        html += '<div class="reply-hold-'+data.commentCourse.data.id+'"></div>';
                                    html += '</div>';
                                    html += '<div class="col-sm-12">';
                                        html += '<hr>';
                                    html += '</div>';
                                html += '</div>';
                                $('#review-box').prepend(html);
                                
                                addEventToButton();
                            }
                        });

                        request.fail(function( jqXHR, textStatus ) {
                            alert( "Request failed: " + textStatus );
                        });
                    });
                </script>
                @endif
                @endif
                <div id="review-box">
                    @foreach($info_course->takeComment(0, 3) as $comment)
                        @include('components.question-answer', ['comment' => $comment])
                    @endforeach
                </div>
            </div>
            @if(count($info_course->comments) > 0)
            <div class="col-sm-12 btn-see-more" data-skip="3" data-take="3">
                <button type="button" class="btn">See more</button>
            </div>
            @endif
        </div>
    </div>
    <div class="related-course">
        <div class="container">
            @include('frontends.related-course')
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $(document).ready(function() { 
        $('#add-cart').click(function(){
            var item = {
                'id' : {!! $info_course->id !!},
                'image' : '{!! $info_course->image !!}',
                'slug' : '{!! $info_course->slug !!}',                
                @if(count($info_course->Lecturers()) > 0)
                'lecturer' : '{!! $info_course->Lecturers()[0]->user->name !!}',
                @else
                'lecturer' : 'Nhiều giảng viên',
                @endif
                'name' : '{!! $info_course->name !!}',
                'price' : {!! $info_course->price !!},
                'real_price' : {!! $info_course->real_price !!},
            }

            if (localStorage.getItem("cart") != null) {
                var list_item = JSON.parse(localStorage.getItem("cart"));
                addItem(list_item, item);
                localStorage.setItem("cart", JSON.stringify(list_item));
            }else{
                var list_item = [];
                addItem(list_item, item);
                localStorage.setItem("cart", JSON.stringify(list_item));
            }
        });

        $('.btn-see-more').click(function(){
            var current_skip = $(this).attr('data-skip');
            var current_take = $(this).attr('data-take');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var request = $.ajax({
                url: baseURL + '/comments/see-more?course_id=' + {{ $info_course->id }} + '&skip=' + current_skip + '&take=' + current_take,
                method: "GET",
                dataType: "html"
            });

            request.done(function( data ) {
                if(data == ''){
                    $('.btn-see-more').hide();    
                }
                $('.btn-see-more').attr('data-skip', current_skip + current_take);
                $('#review-box').append(data);
                addEventToButton();
            });
        });

        $('.go-box').click(function() {
            var box = $(this).attr('data-box');
            if($('#' + box).length) {
                var top_scroll = 0;
                top_scroll = $("#" + box).offset().top;
                $('html,body').animate({
                    scrollTop: top_scroll - 100
                }, 'slow');
            }    
        });
        
        addEventToButton();
    });

    function vote(comment_id, type){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var request = $.ajax({
            url: baseURL + '/comments/vote',
            method: "POST",
            data: {
                comment_id: comment_id,
                type: type
            },
            dataType: "json"
        });
    }

    function addEventToButton(){
        $('.btn-default.btn-reply').off('click');
        $('.btn-default.btn-like').off('click');
        $('.btn-default.btn-dislike').off('click');
        $('.create-reply-btn').off('click');

        $('.btn-default.btn-reply').on('click', function (e) {
            // console.log($(this).attr('data-comment-id'));
            // $('.reply-hold').addClass('hide');
            $('.reply-hold-' + $(this).attr('data-comment-id')).removeClass('hide');

            $('.reply-textbox').addClass('hide');
            $('#reply-textbox-' + $(this).attr('data-comment-id')).removeClass('hide');
        });

        $('.btn-default.btn-like').on('click', function (e) {
            vote($(this).attr('data-comment-id'), 'up');
            $(this).removeClass('btn-default').addClass('btn-primary');
            $(this).parent().find('.btn-dislike').addClass('btn-default').removeClass('btn-primary');
        });

        $('.btn-default.btn-dislike').on('click', function (e) {
            vote($(this).attr('data-comment-id'), 'down');
            $(this).removeClass('btn-default').addClass('btn-primary');
            $(this).parent().find('.btn-like').addClass('btn-default').removeClass('btn-primary');
        });

        $('.create-reply-btn').on('click', function (e) {
            var comment_id = $(this).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var request = $.ajax({
                url: baseURL + '/comments/reply',
                method: "POST",
                data: {
                    parent_id: comment_id,
                    content : $("#reply-" + comment_id).val()
                },
                dataType: "json"
            });

            request.done(function( data ) {
                if(data.status == 200){
                    var html = "";
                    html += '<div class="comment-reply">';
                        html += '<div>';
                            html += '<img class="avatar" src="'+baseURL + '/' + data.commentCourse.data.avatar +'" alt="" />';
                            html += '<div class="info-account">';
                                html += '<p class="interval">' + data.commentCourse.data.created_at +'</p>';
                                html += '<p class="name">' + data.commentCourse.data.username +'</p>';
                            html += '</div>';
                        html += '</div>';
                        html += '<div class="comment">';
                            html += data.commentCourse.data.content;
                        html += '</div>';
                    html += '</div>';

                    $('.reply-hold-' + comment_id).prepend(html);
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        });
    }

    function addItem(arr, obj) {
        const { length } = arr;
        const found = arr.some(el => el.id === obj.id);
        if (!found) arr.push(obj);
        return arr;
    }
</script>
@endsection