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
                <p class="ln-lect-list-sect-counter">0/{{$unit->video_count}}</p>
                </div>
                <div class="ln-lect-list-header-row-2">
                    <h4 class="ln-lect-list-sect-title">{{$unit->name}}</h4>
                </div>
            </div>
            <div id="sectionBody{{ $key+1 }}" class="ln-lect-list-body collapse">
                <ul>
                    @foreach($unit->videos as $video)
                        <li class="duong" id="listItem{{$video->id}}" data-parent="{{$video->id}}">
                            <a href="/learning-page/{{$unit->course_id}}/lecture/{{$video->id}}">
                                <span class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></span>
                                <span class="ln-lect-list-lect-title">{{$video->index}}.  {{ $video->name }}</span>
                            </a>
                            <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
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
#listItem{{$main_video->id}}>a span{
    color: #ffffff !important;
    font-weight: bold;
}
</style>