<div class="u-list-course" id="u-list-course">
    <div class="top clearfix">
        <h3 class="pull-left">Courses Lessons</h3>
        <ul class="pull-right">
            {{-- <li>Expand all</li> --}}
            <li>{{ $info_course->video_count }} lectures</li>
            <li>{{ $info_course->duration }}</li>
        </ul>
    </div>
    <div class="content">
        <div class="panel-group" id="accordion">
            @foreach ($info_course->units as $key_unit => $value_unit)
            <div class="panel panel-default">
                <!-- phần -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key_unit }}" class="accordion-toggle @if ($key_unit != 0) collapsed in @endif" aria-expanded="true"> Phần {{ $key_unit + 1 }}: {{ $value_unit->name }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- bài -->
                <div id="collapse{{ $key_unit }}" class="panel-collapse collapse  @if ($key_unit == 0) in @endif" aria-expanded="true">
                    <div class="panel-body">
                        @foreach ($value_unit->videos as $key_video => $value_video)
                        <div class="col">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-5 col-md-8">
                                        <div class="title">
                                            <a>
                                                <i class="fa fa-play-circle" aria-hidden="true"></i> Bài {{ $value_video->index }}: {{ $value_video->name }} 
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-2">
                                        {{-- @if ($value_video->state == 1)
                                        <div class="link">
                                            &nbsp;
                                            <a class="btn-preview" href="javascript:void(0)" onclick="preview_freetrial(24337);">Free Trial</a>
                                        </div>
                                        @endif --}}
                                    </div>
                                    <div class="col-xs-3 col-md-2">
                                        <div class="time">{{ $value_video->duration }}</div>
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
    @if (count($info_course->tags) > 0)
    <div class="tags">
        <div class="pull-left">
            <span>Tags</span>
            <ul class="pull-right">
                @foreach ($info_course->tags as $tag)
                <li>{{ $tag->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
