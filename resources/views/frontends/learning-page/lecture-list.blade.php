<div class="learning-lecture-list active">
    
    <div class="learning-lecture-list-searchbar">
        <div class="input-group">
            <input type="text" class="form-control" id="sidebarInput" placeholder="Tìm kiếm bài giảng" value="{{ isset($_GET['search']) == true ? $_GET['search'] : '' }}">
            
            <span class="input-group-addon" id="btnSearchSidebar" ><i class="fas fa-search"></i></span>
            
        </div>
        {{-- <button class="btn" id="btnCloseSidebar"><i class="fas fa-times-circle"></i></button> --}}
        
    </div>
    
    <div class="learning-lecture-list-body">
        @php
        $units = $units->sortBy('index');
        @endphp
        @foreach ($units as $key => $unit)
        @php
        if(isset($_GET['search'])){
            $search = strtolower($_GET["search"]);
            $videos = $unit->videos()->whereRaw("LOWER(`videos`.`name`) LIKE '%".$search."%'")->get();
        }else{
            $videos = $unit->videos;    
        }
        
        $string = "Expanding the VueJs Application";
        @endphp
        @if ( count($videos) > 0 )
            <div class="ln-lect-list-item">
            <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody{{$key+1}}">
                    <div class="ln-lect-list-header-row-1">
                    <p class="ln-lect-list-sect-number">Phần {{ $key+1 }}</p>
                    @if ($isStudent)
                        <p class="ln-lect-list-sect-counter">
                            @php
                                $video_done_in_this_units = 0;
                                if(!isset($_GET['search']) || strlen($_GET['search']) == 0){
                            @endphp
                            @foreach ($videos as $video)
                                @php
                                    $list_video_done_in_unit = $video_done_units[($unit->index)-1];
                                    if( isset( array_count_values($list_video_done_in_unit)[1] ) ){
                                        $video_done_in_this_units += array_count_values($list_video_done_in_unit)[1];
                                    }
                                @endphp                       
                            @endforeach
                            {{-- <span id="videoDoneOneSect{{$key+1}}">{{$video_done_in_this_units/count($unit->videos)}}</span>
                            / {{count($unit->videos)}} --}}
                            <span id="videoDoneOneSect{{$key+1}}">{{$video_done_in_this_units/count($videos)}}</span>
                            / {{count($videos)}}
                            @php
                                }
                            @endphp
                        </p>                
                    @endif
                    </div>
                    <div class="ln-lect-list-header-row-2">
                        <p class="ln-lect-list-sect-title">{{$unit->name}}</p>
                    </div>
                </div>
                <div id="sectionBody{{ $key+1 }}" class="ln-lect-list-body collapse">
                    <ul>
                        @foreach($videos as $key2 => $video)
                            <li class="video-list-item" id="listItem{{$video->id}}" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}">
                                @if(isset($_GET['search']) && strlen($_GET['search']) > 0)
                                <a href="learning-page/{{$unit->course_id}}/lecture/{{$video->id}}?search={{ $_GET['search'] }}">
                                @else
                                <a href="learning-page/{{$unit->course_id}}/lecture/{{$video->id}}">
                                @endif
                                    <span class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></span>
                                    <span class="ln-lect-list-lect-title">{{ $video->name }}</span>
                                    <span class="ln-lect-list-lect-duration">{{ App\Helper::convertSecondToTimeFormat($video->duration) }}</span>                                
                                    @if ($isStudent)
                                        @php
                                            $list_video_done_in_unit = $video_done_units[($unit->index)-1];                  
                                        @endphp
                                        @if(isset($list_video_done_in_unit[$video->index-1]))
                                            @if ($list_video_done_in_unit[$video->index-1] == 1)
                                            <span class="ln-btn-complete" id="lnBtnComplete{{$video->id}}" data-child="{{$key2+1}}">
                                                <button >
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x" style="color: #44b900;"></i>
                                                        <i class="fas fa-check fa-stack-1x" style="color: #ffffff;" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}"></i>
                                                    </span>
                                                </button>
                                            </span>
                                            @elseif($list_video_done_in_unit[$video->index-1] == 0)
                                            <span class="ln-btn-complete" id="lnBtnNotComplete{{$video->id}}" data-child="{{$key2+1}}">
                                                <button class="ln-btn-complete " >
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x" style="color: rgb(200, 201, 202);"></i>
                                                        <i class="fas fa-check fa-stack-1x" style="color: rgb(200, 201, 202)" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}"></i>                         
                                                    </span>
                                                </button>
                                            </span>
                                            @endif  
                                        @endif                                  
                                    @endif
                                </a>
                            </li>
                            @if ($video->id === $main_video->id)
                                <script>
                                    $(document).ready(function(){
                                        $("#sectionBody"+{{ $key+1 }}).addClass('in')
                                    })
                                </script>
                            @endif
                            
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @endforeach
        
    </div>
</div>
<script>
    $(document).ready( function (){
        var initialLectureList = $(".ln-lect-list-item").get()
        
        // Search Lecture List
        $("#btnSearchSidebar").click(function (){
            var string = $(".learning-lecture-list-searchbar input").val().trim();
            window.location.replace("{{ url('/') }}/learning-page/{{ $main_video->unit->course->id }}/lecture/{{ $main_video->id }}?search=" + string);
        });

        document.addEventListener("keydown", function(event) {
            if(event.which == 13){
                var string = $(".learning-lecture-list-searchbar input").val().trim();
                window.location.replace("{{ url('/') }}/learning-page/{{ $main_video->unit->course->id }}/lecture/{{ $main_video->id }}?search=" + string);
            }
        })

        $('.collapse').collapse('show');

        // var searchString = localStorage.getItem("searchString");

        // if(searchString != undefined){
        //     $(".learning-lecture-list-searchbar input").val(searchString);
        //     $("#btnSearchSidebar").click();    
        // }

        // $(".learning-lecture-list-searchbar input").keyup(function(){
        //     $('.video-list-item').show();
        //     var string = $(".learning-lecture-list-searchbar input").val().trim();
        //     localStorage.setItem("searchString", string);

        //     $('.collapse').collapse('show');
        //     if(string.length > 0){
        //         $('.ln-lect-list-sect-counter').hide();
        //         $(".ln-lect-list-lect-title").each(function( index ) {
        //             if(!$( this ).text().toLowerCase().includes(string.toLowerCase())){
        //                 $(this).parent().parent().hide();
        //             }
        //         });
        //     }else{
        //         $('.ln-lect-list-sect-counter').show();
        //     }
        // });
    })
</script>

<style>
#listItem{{$main_video->id}}{
    background: #007BE5;
}
#listItem{{$main_video->id}}>a span, #listItem{{$main_video->id}}>div span{
    color: #ffffff !important;
    font-weight: bold;
}
#btnSearchSidebar{
    cursor: pointer;
}
</style>