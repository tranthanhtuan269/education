@extends('frontends.layouts.app') 
@section('content')

<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.student.menu')
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="box-user tabbable-panel">
                {{-- <div class="tabbable-line"> --}}
                    {{-- <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Courses</a>
                        </li>
                    </ul> --}}
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <form action="" method="get">
                                        <div class="form-inline box-search-course">
                                            <div class="form-group box-input">
                                                <input type="text" class="form-control" name="u-keyword" placeholder="Tìm kiếm khoá học..." value="{{ Request::get('u-keyword') }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                @if (count($lifelong_course) > 0)
                                @php
                                    // dd($lifelong_course)
                                @endphp
                                    @foreach ($lifelong_course as $course)
                                    <?php
                                    if(isset($course->Lecturers()[0]->user->name)){
                                        $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
                                    }else{
                                        $lecturers = "Courdemy";
                                    }
                                        // if($course->id == 14){
                                        //     dd($course);
                                        // }
                                        // print_r($course->id);die;
                                    $course->vote_count = $course->five_stars+$course->four_stars+$course->three_stars+$course->two_stars+$course->one_stars;
                                    ?>
                                    @include(
                                        'components.purchased-course', 
                                        [
                                            'courseId' => $course->id,
                                            'slug' => $course->slug,
                                            'image' => url('/frontend/images/'.$course->image),
                                            'rawImage' => $course->image,
                                            'title' => $course->name,
                                            'author' => $lecturers,
                                            'star_count' => $course->star_count,
                                            'vote_count' => $course->vote_count,
                                            'time' => $course->approx_time,
                                            'view_number' => $course->view_count,
                                            'price' => $course->real_price,
                                            'sale' => $course->price,
                                            'from_sale' => $course->from_sale,
                                            'to_sale' => $course->to_sale,
                                            'btn_start_learning' => true,
                                            'video_count'=>$course->video_count
                                        ]
                                    )
                                    @endforeach
                                    <style>
                                    .box-course{
                                        margin: unset;
                                    }
                                    </style>
                                    <div class="col-xs-12 text-center">
                                        <div class="u-number-page">{{ $lifelong_course->appends(Request::all())->links() }}</div>
                                    </div>
                                @else
                                    <div class="col-xs-12">
                                        <p class="result-search-u-keyword">
                                            @if (Request::get('u-keyword'))
                                                Không có kết quả tìm kiếm
                                            @else
                                                Bạn chưa sở hữu khoá học nào! 
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                        {{-- <div class="tab-pane" id="membership">
                            <p>Chưa kích hoạt khóa học với thẻ membership</p>
                        </div> --}}
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.btn.btn-primary.btn-sm.btn-start-learning').click(function (e) {
            e.stopPropagation()
            e.preventDefault()

            const course_id = $(this).attr('data-courseid')
            const course_slug = $(this).attr('data-courseslug')
            const learning_id = $(this).attr('data-learningid')
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const request = $.ajax({
                method: 'POST',
                url: "/user-course/update-watched",
                data: {
                    'video_id': learning_id
                },
                dataType: "json",
                success: function () {
                    window.location.href = ("/learning-page/"+ course_id +"/"+ course_slug)
                },
                error: function () {

                }
            });
        })
    })
</script>
@endsection