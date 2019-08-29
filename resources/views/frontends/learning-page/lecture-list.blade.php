@php
    // dd(($video_done_array));
@endphp
<div class="learning-lecture-list active">
    
    <div class="learning-lecture-list-searchbar">
        <div class="input-group">
            <input type="text" class="form-control" id="sidebarInput" placeholder="Tìm kiếm bài giảng">
            
            <span class="input-group-addon" id="btnSearchSidebar" ><i class="fas fa-search"></i></span>
            
        </div>
        {{-- <button class="btn" id="btnCloseSidebar"><i class="fas fa-times-circle"></i></button> --}}
        
    </div>
    
    <div class="learning-lecture-list-body">
        @foreach ($units as $key => $unit)
        @php
        $string = "Expanding the VueJs Application";
        @endphp
            
        <div class="ln-lect-list-item">
        <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody{{$key+1}}">
                <div class="ln-lect-list-header-row-1">
                <p class="ln-lect-list-sect-number">Phần {{ $key+1 }}</p>
                <p class="ln-lect-list-sect-counter">
                    @php
                        $videos_arr = $unit->videos->sortBy('index');
                    @endphp
                    @foreach ($videos_arr as $video)
                        @php
                            $video_done_in_this_units = 0;
                            $list_video_done_in_unit = $video_done_units[($unit->index)-1];
                            if( isset( array_count_values($list_video_done_in_unit)[1] ) ){
                                $video_done_in_this_units += array_count_values($list_video_done_in_unit)[1];
                            }
                        @endphp                       
                    @endforeach
                    <span id="videoDoneOneSect{{$key+1}}">{{$video_done_in_this_units}}</span>
                    / {{$unit->video_count}}
                </p>
                </div>
                <div class="ln-lect-list-header-row-2">
                    <h5 class="ln-lect-list-sect-title">{{$unit->name}}</h5>
                </div>
            </div>
            <div id="sectionBody{{ $key+1 }}" class="ln-lect-list-body collapse">
                <ul>
                    @foreach($unit->videos->sortBy('index') as $key2 => $video)
                        <li class="video-list-item" id="listItem{{$video->id}}" data-parent="{{$video->id}}">
                            {{-- <a href="{{ route('videoplayer.show', ['courseId' => $unit->course_id, 'videoId' => $video->id]) }}"> --}}
                                @php
                                    $list_video_done_in_unit = $video_done_units[($unit->index)-1];
                                    // if(!is_array($list_video_done_in_unit[$video->index-1])){
                                    //     $list_video_done_in_unit = array($list_video_done_in_unit);
                                    // }
                                    // dd($list_video_done_in_unit);
                                @endphp
                            <a href="learning-page/{{$unit->course_id}}/lecture/{{$video->id}}">
                                <span class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></span>
                                <span class="ln-lect-list-lect-title">{{ $video->name }}</span>
                                <span class="ln-lect-list-lect-duration">{{ App\Helper::convertSecondToTimeFormat($video->duration) }}</span>
                                @if ($list_video_done_in_unit[$video->index-1] == 1)
                                <span class="ln-btn-complete" id="lnBtnComplete{{$video->id}}" data-child="{{$key2+1}}">
                                    <button >
                                        <span class="fa-stack">
                                            <i class="fas fa-circle fa-stack-2x" style="color: #44b900;"></i>
                                            <i class="fas fa-check fa-stack-1x" style="color: #ffffff;"></i>
                                        </span>
                                    </button>
                                </span>
                                @elseif($list_video_done_in_unit[$video->index-1] == 0)
                                <span class="ln-btn-complete" id="lnBtnNotComplete{{$video->id}}" data-child="{{$key2+1}}">
                                    <button class="ln-btn-complete " >
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
                                $(document).ready(function(){
                                    $("#sectionBody"+{{ $key+1 }}).addClass('in')
                                })
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
    $(document).ready( function (){
        var initialLectureList = $(".ln-lect-list-item").get()
        
        // Search Lecture List
        $("#btnSearchSidebar").click(function (){
            // alert()
            var courseId = {{$course->id}}
            var request = $.ajax({
                method: "GET",
                url: "/learning-page/search-lecture-list",
                data: {
                    courseId : courseId,
                    content : $(".learning-lecture-list-searchbar input").val().trim(),
                    type: String,
                }
                
            })
            request.done( function (response){
                if(response.videoList){
                    $(".learning-lecture-list-body").empty()
                    response.videoList.data.forEach( function(element, index) {
                        
                        var html = ''
                        html += '<div class="ln-list-found">'
                            html += '<ul>'
                                html += '<li>'
                                    html += '<a href="/learning-page/'+courseId+'/lecture/'+element.id+'">'
                                        html += '<span class="ln-found-title-icon"><span><i class="fas fa-play-circle"></i></span></span>'
                                        html += '<span class="ln-found-title">'+element.index+'. '+element.name+'</span>'
                                        html += '<span class="ln-found-duration">'+element.duration+'</span>'
                                    html += '</a>'
                                    html += '<div>'
                                        html += '<span class="ln-found-sect-number">Section '+element.unitIndex+': </span>'
                                        html += '<span class="ln-found-sect-name">'+element.unitName+'</span>'
                                    html += '</div>'
                                html += '</li>'
                            html += '</ul>            '
                        html += '</div>'
                        $(".learning-lecture-list-body").append(html)
                    });                    
                }
            })
        })
        
        $(".learning-lecture-list-searchbar input").keyup(function(){

            var courseId = {{$course->id}}
            var request = $.ajax({
                method: "GET",
                url: "/learning-page/search-lecture-list",
                data: {
                    courseId : courseId,
                    content : $(".learning-lecture-list-searchbar input").val().trim(),
                    type: String,
                }
                
            })
            request.done( function (response){
                if($(".learning-lecture-list-searchbar input").val().trim() != ""){
                    if(response.videoList){
                        $(".learning-lecture-list-body").empty()
                        response.videoList.data.forEach( function(element, index) {
                            
                            var html = ''
                            html += '<div class="ln-list-found">'
                                html += '<ul>'
                                    html += '<li>'
                                        html += '<a href="/learning-page/'+courseId+'/lecture/'+element.id+'">'
                                            html += '<span class="ln-found-title-icon"><span><i class="fas fa-play-circle"></i></span></span>'
                                            html += '<span class="ln-found-title">'+element.index+'. '+element.name+'</span>'
                                            html += '<span class="ln-found-duration">'+element.duration+'</span>'
                                        html += '</a>'
                                        html += '<div>'
                                            html += '<span class="ln-found-sect-number">Section '+element.unitIndex+': </span>'
                                            html += '<span class="ln-found-sect-name">'+element.unitName+'</span>'
                                        html += '</div>'
                                    html += '</li>'
                                html += '</ul>            '
                            html += '</div>'
                            $(".learning-lecture-list-body").append(html)
                        });                    
                    }
                }else{
                    $(".learning-lecture-list-body").empty()
                    initialLectureList.forEach( function (element, index){
                        $(".learning-lecture-list-body").append(element)
                    })
                }
                
            })
        })
        
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
</style>