<div class="learning-lecture-list">
    <div class="learning-lecture-list-searchbar">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for lectures">
            
            <span class="input-group-addon" ><i class="fas fa-search"></i></span>
            
        </div>
        <button class="btn" id="btnCloseSidebar"><i class="fas fa-times-circle"></i></button>
        
    </div>
    
    <div class="learning-lecture-list-body">
        @foreach ($units as $key => $unit)
            
        <div class="ln-lect-list-item">
        <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody{{$key+1}}">
                <div class="ln-lect-list-header-row-1">
                <p class="ln-lect-list-sect-number">Section {{ $key+1 }}</p>
                <p class="ln-lect-list-sect-counter">
                    @php
                        $video_done_in_one_section = 0;
                    @endphp
                    @foreach ($unit->videos as $video)
                        @if ($video_done_array[$video->index-1] == 1)
                        @php
                            $video_done_in_one_section += 1;                            
                        @endphp    
                        @endif
                    @endforeach
                    {{$video_done_in_one_section}}
                    /{{$unit->video_count}}
                </p>
                </div>
                <div class="ln-lect-list-header-row-2">
                    <h4 class="ln-lect-list-sect-title">{{$unit->name}}</h4>
                </div>
            </div>
            <div id="sectionBody{{ $key+1 }}" class="ln-lect-list-body collapse">
                <ul>
                    @foreach($unit->videos as $video)
                        <li class="video-list-item" id="listItem{{$video->id}}" data-parent="{{$video->id}}">
                            <a href="{{ route('videoplayer.show', ['courseId' => $unit->course_id, 'videoId' => $video->id]) }}">
                                <span class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></span>
                                <span class="ln-lect-list-lect-title">{{$video->index}}.  {{ $video->name }}</span>
                                <span class="ln-lect-list-lect-duration">{{ App\Helper::convertSecondToTimeFormat($video->duration) }}</span>
                                @if ($video_done_array[$video->index-1] == 1)
                                <span class="ln-btn-complete">
                                    <button >
                                        <span class="fa-stack">
                                            <i class="fas fa-circle fa-stack-2x" style="color: #44b900;"></i>
                                            <i class="fas fa-check fa-stack-1x" style="color: #ffffff;"></i>
                                        </span>
                                    </button>
                                </span>
                                @elseif($video_done_array[$video->index-1] == 0)
                                <span class="ln-btn-complete">
                                    <button class="ln-btn-complete ">
                                        <span class="fa-stack">
                                            <i class="fas fa-circle fa-stack-2x" style="color: rgb(200, 201, 202);"></i>
                                            <i class="fas fa-check fa-stack-1x" style="color: rgb(200, 201, 202)"></i>                         
                                        </span>
                                    </button>
                                </span>
                                @endif
                            </a>
                        </li>
                        @if ($video->id === $main_video->id)
                            <script>
                                $("#sectionBody"+{{ $key+1 }}).addClass('in')
                            </script>
                        @endif
                        
                    @endforeach
                </ul>
            </div>
        </div>

        @endforeach
        
    </div>
</div>
<script>
</script>

<style>
#listItem{{$main_video->id}}{
    background: #007BE5;
}
#listItem{{$main_video->id}}>a span, #listItem{{$main_video->id}}>div span{
    color: #ffffff !important;
    font-weight: bold;
}
.fa-stack{
    font-size: 0.5em;
}
</style>