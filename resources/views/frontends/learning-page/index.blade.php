@php 
    $momentNow = new MomentPHP\MomentPHP();
    $isStudent;

    
    $user_role_course_instance_video = json_decode($user_role_course_instance->videos);
    // dd($user_role_course_instance_video);
    $video_count = $course->video_count;
    if($user_role_course_instance_video){
        $isStudent = true;
    }else{
        $isStudent = false;
    }
    if($isStudent){
        $video_done_units = $user_role_course_instance_video->videos;
        $video_done_count = 0;
        foreach ($video_done_units as $key => $unit) {
            if(isset(array_count_values($unit)[1])){
                $video_done_count += array_count_values($unit)[1];
            }
        }
        // dd($video_done_count);
        $video_done_percent = (int)(($video_done_count/(int)$video_count)*100);
    }
    $video_urls = json_decode($main_video->url_video, true);
    // $urls = [];
    foreach ($video_urls as $key => $video_url) {
        $video_urls[$key] = \App\Helper::createSecurityTokenForVideoLink(\Auth::id(), $main_video->id, $video_url);
    }    
    $video_urls = json_encode($video_urls);

    $check_course_of_user = false;
    if( $course->userRoles[0]->user_id == Auth::user()->id ){
        $check_course_of_user = true;
    }
    // dd($check_course_of_user);

@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>{{$course->name}} | Courdemy</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <!-- Scripts -->
        {{-- <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script> --}}
        <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

        {{-- <script src="https://cdn.tiny.cloud/1/lt4hs1j5octreut3946kr2zrr6g1q6tadfsvm28b7cv6gp84/tinymce/5/tinymce.min.js"></script> --}}
        {{-- <script src="{{asset('frontend/js/ckeditor5-classic-12.4.0.js')}}"></script> --}}
        {{-- <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/decoupled-document/ckeditor.js"></script> --}}
        {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script> --}}
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ asset('js/learning-page.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        {{-- <script src="{{asset('js/app.js')}}"></script> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css"> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> --}}
        {{-- <link rel="stylesheet" href="sweetalert2.min.css"> --}}
        
        
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('/css/learning-page.css')}}">
        <link href="https://vjs.zencdn.net/7.5.4/video-js.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <base href="{{ url('/') }}">
    </head>
    <body>

        {{-- TOP BAR --}}
        <div class="learning-top">
            {{-- <div class="lecture-title">
                <i class="fas fa-list-ul"></i>
                <p>{{$main_video->name}}</p>
            </div> --}}
            <div class="lecture-subtitle">
                <a href="{{ url("/course/{$course->id}/{$course->slug}") }}">
                    <p>TRỞ VỀ TRANG KHOÁ HỌC</p>
                </a>
            </div>
        </div>

        {{-- DESCRIPTION PANEL --}}
        @include('frontends.learning-page.description')
        
        {{-- VIDEO PLAYER --}}
        @include('frontends.learning-page.player')
        
        {{-- LECTURE LIST aka LEFT SIDEBAR --}}
        @include('frontends.learning-page.lecture-list')

        {{-- DISCUSSION PANEL --}}
        @include('frontends.learning-page.discuss')
        
        {{-- SUPPORT FILES --}}
        @include('frontends.learning-page.files')

        {{-- NOTE --}}
        @include('frontends.learning-page.notes')

        {{-- REPORT MODAL --}}
        @include('frontends.learning-page.report')

        {{-- BIG PLAY BUTTON --}}
        <div class="vjs-custom-big-play-button leftbarActive">
            <div class="btn">
                <i class="fas fa-play"></i>
            </div>
        </div>
        <script>
            var course_id = {{$course->id}}
            // var main_video_id = {{$main_video->id}}
            var video_id_list = {{json_encode($video_id_list)}}

            var main_video_id = {{$main_video->id}}
            
            var main_video_id_key = {{$main_video_id_key}}

            var main_video_state = {{$main_video->state}}

            var videoSource = {!!$video_urls!!}

            var check_course_of_user = {{ $check_course_of_user }}
            // console.log(check_course_of_user);
            


            $(document).ready(function () {
                $('.ln-disc-comment-wrapper').on('shown.bs.collapse', function () {
                    $("#discComment" + $(this).attr('data-parent') + " p").addClass('active');
                    return false;
                })
                $('.ln-dilearningsc-comment-wrapper').on('hidden.bs.collapse', function () {                    
                    $("#discComment" + $(this).attr('data-parent') + " p").removeClass('active');
                    return false;
                })
                
                if( check_course_of_user == 1 ){
                    if(main_video_state != 1) { //1 nghĩa là video active
                        $('#lnDescBtnPlay').remove()
                        Swal.fire({
                            type: 'warning',
                            text: 'Video bài giảng chưa được duyệt!',
                            confirmButtonText: 'Chấp nhận'
                        })
                    }
                }

                var video_id_index = null
                video_id_list.forEach(video_id => {
                    if(video_id == {{$main_video->id}}){
                        video_id_index = video_id_list.indexOf(video_id)
                        return 
                    }
                });

                $('#btnContinue').click(function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        method: 'POST',
                        url: "/user-course/update-watched",
                        data: {
                            'video_id' : video_id_list[video_id_index + 1]
                        },
                        dataType: "json",
                    });
                    request.done(function(){
                        // alert("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
                        window.location.href = ("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
                    })
                })
            })
            
        </script>
        <script src='https://vjs.zencdn.net/7.5.4/video.js'></script>
        <script src="https://unpkg.com/silvermine-videojs-quality-selector/dist/js/silvermine-videojs-quality-selector.min.js"></script>           
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.15.0/videojs-contrib-hls.js"></script> --}}
    </body>
</html>