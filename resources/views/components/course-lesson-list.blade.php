<div class="u-list-course" id="u-list-course">
    <div class="top clearfix">
        <h3 class="pull-left">Bài học</h3>
        <ul class="pull-right">
            {{-- <li>Expand all</li> --}}
            <li>{{ $info_course->video_count }} bài học</li>
            <li>{{ intval($info_course->duration / 3600) }} giờ {{ intval($info_course->duration % 60 ) }} phút</li>
        </ul>
    </div>
    <div class="content">
        <div class="panel-group" id="accordion">
            @foreach ($info_course->units->sortBy('index') as $key_unit => $value_unit)
            <div class="panel panel-default">
                <!-- phần -->
                {{-- <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true"> --}}
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true" style="cursor: pointer;">
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="panel-title">
                                    
                                        <span>{{ $value_unit->name }}</span>
                                    <!-- <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true"><span>Section {{ $key_unit + 1 }}:&nbsp; {{ $value_unit->name }}</span></a> -->
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </a> --}}

                <!-- bài -->
                <div id="collapse{{ $key_unit }}" class="panel-collapse collapse  @if ($key_unit == 0) in @endif" aria-expanded="true">
                    <div class="panel-body">
                        @foreach ($value_unit->videos->sortBy('index') as $key_video => $value_video)
                        <div class="col">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-5 col-md-8">
                                        <div class="title">
                                            @if(App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                            <a href="/learning-page/{{$info_course->id}}/lecture/{{$value_video->id}}">
                                                <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                <!-- <span>Lecture {{ $value_video->index }}: &nbsp;{{ $value_video->name }}</span>  -->
                                                <span>{{ $value_video->name }}</span> 
                                            </a>
                                            @else
                                                <i class="fa fa-play-circle" aria-hidden="true"></i>
                                                <!-- <span>Lecture {{ $value_video->index }}: &nbsp;{{ $value_video->name }}</span>  -->
                                                <span>{{ $value_video->name }}</span> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-2 text-center">
                                        @if(App\Helper\Helper::getUserRoleOfCourse($info_course->id))
                                        <a class="btn-preview btn-success" href="/learning-page/{{$info_course->id}}/lecture/{{$value_video->id}}">Xem</a>
                                        @else
                                            <i class="fas fa-lock fa-fw" aria-hidden="true"></i>
                                        @endif
                                        {{-- @if ($value_video->state == 1)
                                        <div class="link">
                                            &nbsp;
                                            <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24337);">Free Trial</a>
                                        </div>
                                        @endif --}}
                                    </div>
                                    <div class="col-xs-3 col-md-2">
                                        <div class="time">{{ App\Helper::convertSecondToTimeFormat($value_video->duration) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- <div class="tags">
        <div class="pull-left">
            Tags</span>
            <ul class="pull-right">
                <li>PHP</li>
                <li>C#</li>
                <li>Java</li>
                <li>Jquey</li>
            </ul>
        </div>
    </div> --}}
    {{-- @if (count($info_course->tags) > 0) --}}
    {{-- <div class="tags">
        <div class="pull-left">
            <span>Tags</span>
            <ul class="pull-right">
                @foreach ($info_course->tags as $tag)
                <li>{{ $tag->name }}</li>
                @endforeach
            </ul>
        </div>
    </div> --}}
    {{-- @endif --}}
</div>
