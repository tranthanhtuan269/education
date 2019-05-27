@extends('frontends.layouts.app') 
@section('content')

<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.teacher.menu')
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="box-user tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Lifelong Course</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="" method="get">
                                        <div class="form-inline box-search-course">
                                            <div class="form-group box-input">
                                                <input type="text" class="form-control" name="u-keyword" placeholder="Search course..." value="{{ Request::get('u-keyword') }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                @if (count($lifelong_course) > 0)
                                    @foreach ($lifelong_course as $course)
                                    <?php
                                        $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
                                    ?>
                                    @include(
                                        'components.course', 
                                        [
                                            'slug' => $course->slug,
                                            'image' => url('/frontend/images/'.$course->image),
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
                                        ]
                                    )
                                    @endforeach
                                    <div class="col-xs-12 text-center">
                                        <div class="u-number-page">{{ $lifelong_course->appends(Request::all())->links() }}</div>
                                    </div>
                                @else
                                    <div class="col-xs-12">
                                        <p class="result-search-u-keyword">
                                            @if (Request::get('u-keyword'))
                                                No results
                                            @else
                                                Has not purchased the course on Courdemy
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
            </div>
        </div>
    </div>
</div>

@endsection