<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Learning Page</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
        <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
        <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('/css/learning-page.css')}}">
        <link href="https://vjs.zencdn.net/7.5.4/video-js.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


        
    </head>
    <body>
        <div class="learning-top">
            <div class="lecture-title">
                <i class="fas fa-list-ul"></i>
                <p>Lac nhau co phai muon doi</p>
            </div>
            <div class="lecture-subtitle">
                <p>Go to Dashboard</p>
            </div>
        </div>
        <div class="learning-video">
            <video id='my-video' class='video-js vjs-big-play-centered' controls preload='auto' data-setup='{}'>
                <source src='http://45.56.82.249:1935/vod/_definst_/neuanhdi.mp4/playlist.m3u8' type='application/x-mpegURL'>
                    
                    
                    <p class='vjs-no-js'>
                        To view this video please enable JavaScript, and consider upgrading to a web browser that
                        <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
                    </p>
                </video>
                
        </div>

        <div class="learning-lecture-list">
            <div class="learning-lecture-list-searchbar">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for lectures">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <button class="btn float-right"><i class="fas fa-times-circle"></i></button>
                </div>
            </div>
        </div>

        <script src='https://vjs.zencdn.net/7.5.4/video.js'></script>                    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.15.0/videojs-contrib-hls.js"></script>
        <script>
            $( document ).ready(function() {
                function toggleLectureList(){
                    if($(".learning-lecture-list").width() === 0){
                        $(".learning-lecture-list").css({'width': '35vw', 'display': 'block'})
                        $("#my-video").css({"width": "65vw", "float": "right"})
                        $(".learning-top").css({"width": "65vw", "left": "35vw", "transition": "0.5s"})
                    }else{
                        $("#my-video").css({"width": "100vw"})
                        $(".learning-top").css({"width": "100vw", "left": "0", "transition": "0.5s"})
                        $(".learning-lecture-list").css({'width': '0', 'display': 'none'})
                    }
                }
                $(".lecture-title").click(function(){
                    toggleLectureList()
                })

            });
        </script>
    </body>
</html>
        