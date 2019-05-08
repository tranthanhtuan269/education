<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Learning Page</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
        <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
        <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
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
        <div class="learning-desc-panel ">
            <div class="learning-desc-panel-body align-items-center">
                <div class="ln-desc-title">
                    <p>Unreal Engine C++ Development</p>
                </div>
                <div class="ln-desc-subtitle">
                    <p>Section 2, Lecture 17</p>
                </div>
                <div class="ln-desc-content">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
                <div class="ln-desc-achv">
                    <p>79 of 284 items completed</p>
                    <div class="ln-progress-bar">
                        <div class="progress lecture-progress" style="width: 30vw">
                            <div class="progress-bar progress-bar-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        &nbsp;
                        <div class="cup-progress">
                            <div class="progress" style="width: 5vw">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                </div>
                <br>
                <div class="ln-desc-btn-play">
                    <button class="btn btn-warning" id="lnDescBtnPlay"><i class="fas fa-play-circle"></i> Continue</button>
                </div>
            </div>

            <div class="ln-desc-bottom">
                <div class="ln-desc-btm-center">
                    <div class="ln-desc-btm-group-track">
                        <button class="btn" id="lnDescBtnPrevious"><i class="fas fa-step-backward"></i></button>
                        <button class="btn" id="lnDescBtnNext"><i class="fas fa-step-forward"></i></button>
                    </div>
                    <div class="ln-desc-group-btn-utilities">
                        <div class="btn ln-btn-server">
                            <i class="fas fa-server"></i>
                            <span>&nbsp;Server Video</span>
                        </div>
                        <div class="btn ln-btn-note">
                            <i class="fas fa-sticky-note"></i>
                            <span>&nbsp;Note</span>
                        </div>
                        <div class="btn ln-btn-discuss">
                            <i class="fas fa-comments"></i>
                            <span>&nbsp;Discussion</span>
                        </div>
                        <div class="btn ln-btn-file">
                            <i class="fas fa-file-alt"></i>
                            <span>&nbsp;Files</span>
                        </div>
                    </div>
                    <div class="ln-desc-group-btn-utilities-2">
                        <div class="btn ln-btn-note">
                            <i class="fas fa-toggle-on"></i>
                            <span>&nbsp;Autoplay</span>
                        </div>
                        <div class="btn ln-btn-discuss">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>&nbsp;Report</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- VIDEO PLAYER --}}
        <div class="learning-video">
            <video id='my-video' class='video-js vjs-big-play-centered'>
                <source src='http://45.56.82.249:1935/vod/_definst_/killthislove1080.mp4/playlist.m3u8' type='application/x-mpegURL' label="1080p">
                <source src='http://45.56.82.249:1935/vod/_definst_/killthislove720.mp4/playlist.m3u8' type='application/x-mpegURL' label="720p">
                <source src='http://45.56.82.249:1935/vod/_definst_/killthislove480.mp4/playlist.m3u8' type='application/x-mpegURL' label="480p">
                <source src='http://45.56.82.249:1935/vod/_definst_/killthislove360.mp4/playlist.m3u8' type='application/x-mpegURL' label="360p">

                    
                <p class='vjs-no-js'>
                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                    <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
                </p>
            </video>
        </div>
        
        {{-- LEFT SIDEBAR aka LECTURE LIST --}}
        <div class="learning-lecture-list">
            <div class="learning-lecture-list-searchbar">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for lectures">
                    
                    <span class="input-group-addon" ><i class="fas fa-search"></i></span>
                    
                </div>
                <button class="btn" id="btnCloseSidebar"><i class="fas fa-times-circle"></i></button>
                
            </div>
            
            <div class="learning-lecture-list-body">
                <div class="ln-lect-list-item">
                    <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody1">
                        <div class="ln-lect-list-header-row-1">
                            <p class="ln-lect-list-sect-number">Section 1</p>
                            <p class="ln-lect-list-sect-counter">0/18</p>
                        </div>
                        <div class="ln-lect-list-header-row-2">
                            <h4 class="ln-lect-list-sect-title">Thanh Tuan xau trai</h4>
                        </div>
                    </div>
                    <div id="sectionBody1" class="ln-lect-list-body collapse">
                        <ul>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                                    <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset Ronaldo Khedira Alibaba Antonio Valencia </span>
                                    <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                                    <button class="ln-btn-complete "><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ln-lect-list-item">
                    <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody2">
                        <div class="ln-lect-list-header-row-1">
                            <p class="ln-lect-list-sect-number">Section 1</p>
                            <p class="ln-lect-list-sect-counter">0/18</p>
                        </div>
                        <div class="ln-lect-list-header-row-2">
                            <h4 class="ln-lect-list-sect-title">Thanh Tuan xau trai</h4>
                        </div>
                    </div>
                    <div id="sectionBody2" class="ln-lect-list-body collapse">
                        <ul>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                                    <button class="ln-btn-complete"><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset Ronaldo Khedira Alibaba Antonio Valencia </span>
                                    <button class="ln-btn-complete"><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                                    <button class="ln-btn-complete"><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ln-lect-list-item">
                    <div class="ln-lect-list-header" data-toggle="collapse" data-target="#sectionBody3">
                        <div class="ln-lect-list-header-row-1">
                            <p class="ln-lect-list-sect-number">Section 1</p>
                            <p class="ln-lect-list-sect-counter">0/18</p>
                        </div>
                        <div class="ln-lect-list-header-row-2">
                            <h4 class="ln-lect-list-sect-title">Thanh Tuan xau trai</h4>
                        </div>
                    </div>
                    <div id="sectionBody3" class="ln-lect-list-body collapse">
                        <ul>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                                    <button class="ln-btn-complete"><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset Ronaldo Khedira Alibaba Antonio Valencia </span>
                                    <button class="ln-btn-complete"><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <button class="ln-lect-list-lect-title-icon"><span><i class="fas fa-play-circle"></i></span></button>
                                    <span class="ln-lect-list-lect-title">1. Intro, Notes & Section 2 Asset </span>
                                    <button class="ln-btn-complete"><i class="fas fa-circle"></i></button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- DISCUSSION PANEL --}}
        <div class="learning-discussion">
            
        </div>
        
        {{-- BIG PLAY BUTTON --}}
        <div class="vjs-custom-big-play-button">
            <div class="btn">
                <i class="fas fa-play"></i>
            </div>
        </div>

        <script src='https://vjs.zencdn.net/7.5.4/video.js'></script>
        <script src="https://unpkg.com/silvermine-videojs-quality-selector/dist/js/silvermine-videojs-quality-selector.min.js"></script>           
        <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.15.0/videojs-contrib-hls.js"></script>
    </body>
</html>
        