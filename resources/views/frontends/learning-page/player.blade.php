<div class="learning-video">
    <video id='my-video' class='video-js vjs-big-play-centered' src=""> 
        @foreach ($video_urls as $key => $url)
            @php
                $generated_url = \App\Helper::createSecurityTokenForVideoLink(\Auth::id(), $main_video->id, $url);                
            @endphp
            <source src='{{$generated_url}}' type='application/x-mpegURL' label="{{$key}}p">
        @endforeach
        {{-- <source src='http://45.56.82.249:1935/vod/_definst_/killthislove720.mp4/playlist.m3u8' type='application/x-mpegURL' label="720p">
        <source src='http://45.56.82.249:1935/vod/_definst_/killthislove480.mp4/playlist.m3u8' type='application/x-mpegURL' label="480p">
        <source src='http://45.56.82.249:1935/vod/_definst_/killthislove360.mp4/playlist.m3u8' type='application/x-mpegURL' label="360p"> --}}

            
        <p class='vjs-no-js'>
            To view this video please enable JavaScript, and consider upgrading to a web browser that
            <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
        </p>
    </video>
</div>