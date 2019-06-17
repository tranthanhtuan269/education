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
                {{-- <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Courses</a>
                        </li>
                    </ul> --}}
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
                                <div class="col-sm-6">
                                    <div class="pull-right"><button class="btn btn-primary" id="create-course-btn"><i class="fas fa-book"></i> Create Course</button></div>
                                </div>
                            </div>
                            <div class="row">
                                @if (count($lifelong_course) > 0)
                                    @foreach ($lifelong_course as $course)
                                    <?php
                                        $lecturers = count($course->Lecturers()) > 1 ? 'Nhiều tác giả' : count($course->Lecturers()) > 0 ? $course->Lecturers()[0]->user->name : "Courdemy";
                                    ?>
                                    @include(
                                        'components.teaching-course', 
                                        [   
                                            'id'    => $course->id,
                                            'slug' => $course->slug,
                                            'rawImage' => $course->image,
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
            {{-- </div> --}}
        </div>
    </div>
</div>

<div id="createCourse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Create a new Course</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#create-course-btn').click(function(){
            // alert(1)
            $('#createCourse').modal('toggle')
        });
    });
</script>

@endsection