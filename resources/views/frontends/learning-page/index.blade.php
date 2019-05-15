@php
    // dd($course);
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>Learning Page</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ asset('js/learning-page.js') }}"></script>

        

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('/css/learning-page.css')}}">
        <link href="https://vjs.zencdn.net/7.5.4/video-js.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    </head>
    <body>

        {{-- TOP BAR --}}
        <div class="learning-top">
            <div class="lecture-title">
                <i class="fas fa-list-ul"></i>
                <p>Lecture list</p>
            </div>
            <div class="lecture-subtitle">
                <p>Go to Dashboard</p>
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


        {{-- BIG PLAY BUTTON --}}
        <div class="vjs-custom-big-play-button">
            <div class="btn">
                <i class="fas fa-play"></i>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.ln-disc-comment-wrapper').on('shown.bs.collapse', function () {
                    $('#' + $(this).attr('data-parent')).addClass('active');
                    return false;
                })
                $('.ln-disc-comment-wrapper').on('hidden.bs.collapse', function () {
                    $('#' + $(this).attr('data-parent')).removeClass('active');
                    return false;
                })

                
            })
        </script>

        <script src='https://vjs.zencdn.net/7.5.4/video.js'></script>
        <script src="https://unpkg.com/silvermine-videojs-quality-selector/dist/js/silvermine-videojs-quality-selector.min.js"></script>           
        <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.15.0/videojs-contrib-hls.js"></script>
    </body>
</html>
        