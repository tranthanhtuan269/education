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
                            @if ($video->id === $main_video->id)
                            <li class="video-list-item video-selected" id="listItem{{$video->id}}" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}" data-name="{{ $video->name }}" data-unit="{{ ($unit->index) }}" data-video="{{ ($video->index) }}">
                                <a id="view-from-learning-page-{{$video->id}}" href="javascript:void(0)">
                                    <span class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></span>
                                    <span class="ln-lect-list-lect-title has-result">{{ $video->name }}</span>
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
                                                        <i class="fas fa-circle fa-stack-2x video_viewed"></i>
                                                        <i class="fas fa-check fa-stack-1x video_viewed" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}" data-name="{{ $video->name }}" data-unit="{{ ($unit->index) }}" data-video="{{ ($video->index) }}"></i>
                                                    </span>
                                                </button>
                                            </span>
                                            @elseif($list_video_done_in_unit[$video->index-1] == 0)
                                            <span class="ln-btn-complete" id="lnBtnComplete{{$video->id}}" data-child="{{$key2+1}}">
                                                <button>
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x video_not_viewed"></i>
                                                        <i class="fas fa-check fa-stack-1x video_not_viewed" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}" data-name="{{ $video->name }}" data-unit="{{ ($unit->index) }}" data-video="{{ ($video->index) }}"></i>                         
                                                    </span>
                                                </button>
                                            </span>
                                            @endif  
                                        @endif  
                                    @endif
                                </a>
                            </li>
                            <script>
                                $(document).ready(function(){
                                    $("#sectionBody"+{{ $key+1 }}).addClass('in')
                                })
                            </script>
                            @else
                            <li class="video-list-item" id="listItem{{$video->id}}" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}" data-name="{{ $video->name }}" data-unit="{{ ($unit->index) }}" data-video="{{ ($video->index) }}">
                                <a id="view-from-learning-page-{{$video->id}}" href="javascript:void(0)">
                                    <span class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></span>
                                    <span class="ln-lect-list-lect-title has-result">{{ $video->name }}</span>
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
                                                        <i class="fas fa-circle fa-stack-2x video_viewed"></i>
                                                        <i class="fas fa-check fa-stack-1x video_viewed" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}" data-name="{{ $video->name }}" data-unit="{{ ($unit->index) }}" data-video="{{ ($video->index) }}"></i>
                                                    </span>
                                                </button>
                                            </span>
                                            @elseif($list_video_done_in_unit[$video->index-1] == 0)
                                            <span class="ln-btn-complete" id="lnBtnComplete{{$video->id}}" data-child="{{$key2+1}}">
                                                <button>
                                                    <span class="fa-stack">
                                                        <i class="fas fa-circle fa-stack-2x video_not_viewed"></i>
                                                        <i class="fas fa-check fa-stack-1x video_not_viewed" data-parent="{{$video->id}}" data-isstudent="{{$isStudent}}" data-name="{{ $video->name }}" data-unit="{{ ($unit->index) }}" data-video="{{ ($video->index) }}"></i>                         
                                                    </span>
                                                </button>
                                            </span>
                                            @endif  
                                        @endif                                  
                                    @endif
                                </a>
                            </li>
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
            $('.video-list-item').show();
            var string = $(".learning-lecture-list-searchbar input").val().trim();
            sessionStorage.setItem("searchString-" + $('body').attr('data-course-id'), string);
            if(string.length > 0){
                $('.ln-lect-list-sect-counter').hide();
                $(".ln-lect-list-lect-title").addClass('has-result')
                $(".ln-lect-list-lect-title").each(function( index ) {
                    if(!$( this ).text().toLowerCase().includes(string.toLowerCase())){
                        $(this).removeClass('has-result');
                        $(this).parent().parent().hide();
                    }
                });
                removeHaveNotResult();
            }else{
                $('.ln-lect-list-item').show();
                $('.ln-lect-list-sect-counter').show();
            }
            $('.ln-lect-list-body').addClass('in')
        });

        var searchString = sessionStorage.getItem("searchString-" + $('body').attr('data-course-id'));

        if(searchString != undefined){
            $(".learning-lecture-list-searchbar input").val(searchString);
            $("#btnSearchSidebar").click(); 
            $('.ln-lect-list-body').addClass('in')   
        }

        $(".learning-lecture-list-searchbar input").keyup(function(){
            $('.video-list-item').show();
            var string = $(".learning-lecture-list-searchbar input").val().trim();
            sessionStorage.setItem("searchString-" + $('body').attr('data-course-id'), string);
            if(string.length > 0){
                $('.ln-lect-list-sect-counter').hide();
                $(".ln-lect-list-lect-title").addClass('has-result')
                $(".ln-lect-list-lect-title").each(function( index ) {
                    if(!$( this ).text().toLowerCase().includes(string.toLowerCase())){
                        $(this).removeClass('has-result');
                        $(this).parent().parent().hide();
                    }
                });
                removeHaveNotResult();
            }else{
                $('.ln-lect-list-item').show();
                $('.ln-lect-list-sect-counter').show();
            }
            $('.ln-lect-list-body').addClass('in')
        });

        document.addEventListener("keydown", function(event) {
            if(event.which == 13){
                $("#btnSearchSidebar").click();
                $('.ln-lect-list-body').addClass('in')
            }
        })

        function removeHaveNotResult(){
            $('.ln-lect-list-item').hide();
            $(".ln-lect-list-lect-title.has-result").parent().parent().parent().parent().parent().show();
        }
    })
</script>

<style>
.video-selected{
    background: #00297b;
}

.video-selected:hover{
    background: #007BE5;
}
.video-selected>a span, .video-selected>div span{
    color: #ffffff !important;
    font-weight: bold;
}
#btnSearchSidebar{
    cursor: pointer;
}
</style>