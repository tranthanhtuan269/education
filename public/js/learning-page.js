const baseURL = $('base').attr('href');




let isAutoplay;
if(localStorage.getItem('autoplay') != null){
    isAutoplay = localStorage.getItem('autoplay')
}else{
    localStorage.setItem('autoplay', 'false')
    isAutoplay = localStorage.getItem('autoplay')
}

$(document).ready(function () {
    //Check browser có phải là firefox hay không để hiện thông báo
    

    var options = {
        controls: true,
        preload: 'auto',
        autoplay : false,
        controlBar: {
            volumePanel: { inline: false }
        },
        playbackRates: [0.5, 1, 1.5, 2]
    }

    // Set up the player
    var isPlayerAutoplay = false
    if(isAutoplay == null){
        $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-off'></i>")
    }else if(isAutoplay == "true"){
        isPlayerAutoplay = true
        $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-on'></i>")
        $(".learning-desc-panel").hide()

    }else if(isAutoplay == "false"){
        isPlayerAutoplay = false
        $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-off'></i>")
    }


    $(".ln-btn-autoplay").click(function () {
        if(localStorage.getItem('autoplay') == "true"){
            localStorage.setItem('autoplay', false)
            options.autoplay = false;
            $(".ln-btn-autoplay .fa-toggle-on").remove()
            $(".vjs-subtitle-control.btn.vjs-control.vjs-button button .fa-toggle-on").remove()
            $(".vjs-subtitle-control.btn.vjs-control.vjs-button button").prepend("<i class='fas fa-toggle-off' id='btnAutoplay'></i>")
            $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-off'></i>")
        }else if(localStorage.getItem('autoplay') == "false"){
            localStorage.setItem('autoplay', true)
            options.autoplay = true;
            $(".ln-btn-autoplay .fa-toggle-off").remove()
            $(".vjs-subtitle-control.btn.vjs-control.vjs-button button .fa-toggle-off").remove()
            $(".vjs-subtitle-control.btn.vjs-control.vjs-button button").prepend("<i class='fas fa-toggle-on' id='btnAutoplay'></i>")
            $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-on'></i>")
        }else{
            localStorage.setItem('autoplay', true)
            options.autoplay = true;
            $(".ln-btn-autoplay .fa-toggle-off").remove()
            $(".vjs-subtitle-control.btn.vjs-control.vjs-button button .fa-toggle-off").remove()
            $(".vjs-subtitle-control.btn.vjs-control.vjs-button button").prepend("<i class='fas fa-toggle-on' id='btnAutoplay'></i>")
            $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-on'></i>")
        }
    })
    var player = videojs('my-video', options)

    initPlay();
    function initPlay(){
        prePlay(360);
        initializePlayerControlBar()
        toggleBigPlayButton()
        clickToPlay()
    }

    updateLink();

    function updateLink(){
        player = videojs('my-video', options);
        prePlay(360);
        player.load();
        // player.pause();
        $(".learning-desc-panel").fadeIn()
    }

    player.on('loadeddata', function(){
        if(localStorage.getItem('autoplay') == "true"){
            $(".learning-desc-panel").hide()
            player.play();
        }else{
            player.pause();
        }
    })

    player.on('ended', function(){
        if(localStorage.getItem('autoplay') == "true" || localStorage.getItem('autoplay') == true){
            $("#btnContinue").click()
        }
    })
    // $('.vjs-fullscreen-control.vjs-control.vjs-button').on('click', function () {
    //     var isFullscreen = player.isFullscreen()
    //     if(isFullscreen){
    //         $('.group-btn-utilities div').hide()
    //     }else{
    //         $('.group-btn-utilities div').show()
    //     }
    // })

    player.on('fullscreenchange', function(){
        var isFullscreen = player.isFullscreen()
        if(isFullscreen){
            $('.group-btn-utilities div').hide()
        }else{
            $('.group-btn-utilities div').show()
        }
    })


    var imageAddr = "https://3.bp.blogspot.com/-p4_qEVLk2dk/V5ZOdoiObWI/AAAAAAAAB74/8F9sCzKkNSY/chien-binh-sieu-am-thanh.jpg";
    // var imageAddr = "http://www.kenrockwell.com/contax/images/g2/examples/31120037-5mb.jpg";
    var downloadSize = 40128; //bytes

	function InitiateSpeedDetection() {
        window.setTimeout(MeasureConnectionSpeed, 1);
	};

	if (window.addEventListener) {
	    window.addEventListener('load', InitiateSpeedDetection, false);
	} else if (window.attachEvent) {
	    window.attachEvent('onload', InitiateSpeedDetection);
    }

    function prePlay(autoSelected){
        var source = []

        for(var key in window.videoSource){
            if(key == autoSelected){
                source.push({
                    src: window.videoSource[key],
                    type: 'application/x-mpegURL',
                    label: key,
                    selected: true,
                })
            }else{
                source.push({
                    src: window.videoSource[key],
                    type: 'application/x-mpegURL',
                    label: key
                })
            }
        }
        player.src(source)
    }

	function MeasureConnectionSpeed() {
	    var startTime, endTime;
	    var download = new Image();
	    download.onload = function () {
	        endTime = (new Date()).getTime();
	        showResults();
	    }

	    download.onerror = function (err, msg) {
	        // ShowProgressMessage("Invalid image, or error downloading");
	    }

	    startTime = (new Date()).getTime();
	    var cacheBuster = "?nnn=" + startTime;
	    download.src = imageAddr + cacheBuster;

	    function showResults() {
	        var duration = (endTime - startTime) / 1000;
	        var bitsLoaded = downloadSize * 8;
	        var speedBps = (bitsLoaded / duration).toFixed(2);
	        var speedKbps = (speedBps / 1024).toFixed(2);
            var speedMbps = (speedKbps / 1024).toFixed(2);
            if(speedMbps < 2){
                prePlay(360)
            }else if(speedMbps < 3){
                prePlay(480)
            }else if(speedMbps < 4){
                prePlay(720)
            }else{
                prePlay(1080)
            }
	    }
	}

    function checkIfVideoIsPlaying(){
        console.log(player.paused());
    }
    // player.on('error', function(e){
    //     var mediaError = player.error() 
    //     if(mediaError.code == 4){
    //         return Swal.fire({
    //             type: 'info',
    //             text: 'Video bài giảng chưa được duyệt!'
    //         })
    //     }
         
    // })

    videojs('my-video').ready(function () {
        
        this.on('timeupdate', function () {
            if(this.bufferedPercent() > 0){                
                $(".player-current-time").text(convertSecondToTimeFormat(this.currentTime()) + ' / ')
                $(".player-end-time").text(convertSecondToTimeFormat(player.duration()))
            }
        })
        
    });
    $(document).on('click',"#btnAutoplay", function(){
        if(localStorage.getItem('autoplay') == 'true'){
            localStorage.setItem('autoplay', 'false')
            isAutoplay = false;
            $("#btnAutoplay").removeClass("fa-toggle-on")
            $("#btnAutoplay").addClass("fa-toggle-off")
        }else if(localStorage.getItem('autoplay') == 'false'){
            localStorage.setItem('autoplay', 'true')
            isAutoplay = true;
            $("#btnAutoplay").removeClass("fa-toggle-off")
            $("#btnAutoplay").addClass("fa-toggle-on")
        }else{
            localStorage.setItem('autoplay', 'true')
            isAutoplay = true;
            $("#btnAutoplay").removeClass("fa-toggle-off")
            $("#btnAutoplay").addClass("fa-toggle-on")
        }
    })

    $(".lecture-title").click(function () {
        // toggleLectureList()
    })
    $("#btnCloseSidebar").click(function () {
        // toggleLectureList()
    })
    $(".ln-btn-complete").click(function (event) {
        event.stopPropagation()
        // tickCompleteLecture()
    })
    $("#btnForward").click(function () {
        seekTime(5)
    })
    $("#btnRewind").click(function () {
        seekTime(-5)
    })
    $(".ln-btn-discuss").click(function () {
        toggleDiscussion()
    })
    $("#btnCloseDiscussion").click(function (){
        toggleDiscussion()
    })
    $(".ln-btn-file").click(function (){
        toggleFiles()
    })
    $("#btnCloseFiles").click(function (){
        toggleFiles()
    })
    $(".ln-btn-note").click(function (){
        toggleNotes()
    })
    $("#btnCloseNotes").click(function (){
        toggleNotes()
    })

    $('.ln-lect-list-header').click(function(){
        $('.ln-lect-list-body').removeClass('in')
    })

    $(".video-list-item, .fa-stack-1x").click(function (e) {
        e.stopImmediatePropagation()
        e.stopPropagation()
        e.preventDefault()

        $(".vjs-custom-big-play-button").fadeOut()
        var video_id = $(this).attr("data-parent")
        console.log('#listItem'+ video_id + ' .fa-stack-2x')
        localStorage.setItem("indexCurrentVideo", video_id);

        var section_dom = $(this).parent()
        var isStudent = $(this).attr("data-isstudent")
        var video_name = $(this).attr("data-name")
        var video_info = "Phần " + $(this).attr("data-unit") + ", Bài " + $(this).attr("data-video")

        section_dom.each(function (index, value){
            // alert(index)
        })
        if(isStudent){
            // alert(isStudent)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                method: 'POST',
                url: "/user-course/update-watched",
                data: {
                    'video_id' : video_id
                },
                dataType: "json"
            });
            request.done(function(data){
                window.videoSource = JSON.parse(data.video_url);
                updateLink();

                // $video_urls = json_decode($main_video->url_video, true);
                if(data.update_viewed == 1){
                    $("#viewed_count").html(parseInt($("#viewed_count").html()) + 1)
                    $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
                }
                $('.video-list-item').removeClass('video-selected')
                $('#listItem'+ video_id).addClass('video-selected')

                if($('#listItem'+ video_id + ' .fa-stack-2x').hasClass('video_viewed')){
                    $('#lnDescBtnViewed').hide()
                    $('#lnDescBtnNotViewed').show()
                }else{
                    $('#listItem'+ video_id + ' .fa-stack-2x').addClass('video_viewed').removeClass('video_not_viewed');
                    $('#listItem'+ video_id + ' .fa-stack-1x').addClass('video_viewed').removeClass('video_not_viewed');
                    $('#videoDoneOneSect' + $('#listItem' + video_id).attr('data-unit')).html(parseInt($('#videoDoneOneSect' + $('#listItem' + video_id).attr('data-unit')).html()) + 1);
                    
                    $('#lnDescBtnViewed').hide()
                    $('#lnDescBtnNotViewed').show()
                }
                $('.ln-desc-title').html('<p>' + video_name + '</p>');
                $('.ln-desc-subtitle').html('<p>' + video_info + '</p>');
            })
        }else{
            window.location.href = ("/learning-page/"+ course_id +"/lecture/"+ video_id)
        }
    })

    $('#lnDescBtnNext').on('click', function(e){
        e.preventDefault()
        e.stopPropagation()
        var current_video_id = localStorage.getItem("indexCurrentVideo");
        var video_id_index = null
        video_id_list.forEach(video_id => {
            if(video_id == localStorage.getItem("indexCurrentVideo")){
                video_id_index = video_id_list.indexOf(video_id)
                return 
            }
        });

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
        request.done(function(data){
            window.videoSource = JSON.parse(data.video_url);
            updateLink();

            var video_info = "Phần " + $('#listItem'+ video_id_list[video_id_index + 1]).attr("data-unit") + ", Bài " + $('#listItem'+ video_id_list[video_id_index + 1]).attr("data-video")

            // $video_urls = json_decode($main_video->url_video, true);
            if(data.update_viewed == 1){
                $("#viewed_count").html(parseInt($("#viewed_count").html()) + 1)
                $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
            }
            $('.video-list-item').removeClass('video-selected')
            $('#listItem'+ video_id_list[video_id_index + 1]).addClass('video-selected')
            $('#listItem'+ video_id_list[video_id_index + 1] + ' .fa-stack-2x').addClass('video_viewed').removeClass('video_not_viewed');
            $('#listItem'+ video_id_list[video_id_index + 1] + ' .fa-stack-1x').addClass('video_viewed').removeClass('video_not_viewed');

            $('.ln-desc-title').html('<p>' + $('#listItem'+ video_id_list[video_id_index + 1]).attr('data-name') + '</p>');
            $('.ln-desc-subtitle').html('<p>' + video_info + '</p>');
            localStorage.setItem("indexCurrentVideo", video_id_list[video_id_index + 1])
        })
    })

    $('#lnDescBtnPrevious').on('click', function(e){
        e.preventDefault()
        e.stopPropagation()
        var video_id_index = null
        video_id_list.forEach(video_id => {
            if(video_id == localStorage.getItem("indexCurrentVideo")){
                video_id_index = video_id_list.indexOf(video_id)
                return 
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var request = $.ajax({
            method: 'POST',
            url: "/user-course/update-watched",
            data: {
                'video_id' : video_id_list[video_id_index - 1]
            },
            dataType: "json",
        });
        request.done(function(data){
            window.videoSource = JSON.parse(data.video_url);
            updateLink();

            var video_info = "Phần " + $('#listItem'+ video_id_list[video_id_index - 1]).attr("data-unit") + ", Bài " + $('#listItem'+ video_id_list[video_id_index - 1]).attr("data-video")

            // $video_urls = json_decode($main_video->url_video, true);
            if(data.update_viewed == 1){
                $("#viewed_count").html(parseInt($("#viewed_count").html()) - 1)
                $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
            }
            $('.video-list-item').removeClass('video-selected')
            $('#listItem'+ video_id_list[video_id_index - 1]).addClass('video-selected')
            $('#listItem'+ video_id_list[video_id_index - 1] + ' .fa-stack-2x').addClass('video_viewed').removeClass('video_not_viewed');
            $('#listItem'+ video_id_list[video_id_index - 1] + ' .fa-stack-1x').addClass('video_viewed').removeClass('video_not_viewed');

            $('.ln-desc-title').html('<p>' + $('#listItem'+ video_id_list[video_id_index - 1]).attr('data-name') + '</p>');
            $('.ln-desc-subtitle').html('<p>' + video_info + '</p>');
            localStorage.setItem("indexCurrentVideo", video_id_list[video_id_index - 1])
        })
    })

    $('#btnContinue').click(function (e) {
        e.preventDefault()
        e.stopPropagation()
        $(".vjs-custom-big-play-button").fadeOut()
        var current_video_id = localStorage.getItem("indexCurrentVideo");
        var video_id_index = null
        video_id_list.forEach(video_id => {
            if(video_id == localStorage.getItem("indexCurrentVideo")){
                video_id_index = video_id_list.indexOf(video_id)
                return 
            }
        });

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
        request.done(function(data){
            window.videoSource = JSON.parse(data.video_url);
            updateLink();

            var video_info = "Phần " + $('#listItem'+ video_id_list[video_id_index + 1]).attr("data-unit") + ", Bài " + $('#listItem'+ video_id_list[video_id_index + 1]).attr("data-video")

            // $video_urls = json_decode($main_video->url_video, true);
            if(data.update_viewed == 1){
                $("#viewed_count").html(parseInt($("#viewed_count").html()) + 1)
                $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
            }
            $('.video-list-item').removeClass('video-selected')
            $('#listItem'+ video_id_list[video_id_index + 1]).addClass('video-selected')
            $('#listItem'+ video_id_list[video_id_index + 1] + ' .fa-stack-2x').addClass('video_viewed').removeClass('video_not_viewed');
            $('#listItem'+ video_id_list[video_id_index + 1] + ' .fa-stack-1x').addClass('video_viewed').removeClass('video_not_viewed');

            $('.ln-desc-title').html('<p>' + $('#listItem'+ video_id_list[video_id_index + 1]).attr('data-name') + '</p>');
            $('.ln-desc-subtitle').html('<p>' + video_info + '</p>');
            localStorage.setItem("indexCurrentVideo", video_id_list[video_id_index + 1])
        })
    })

    function seekTime(secs) {
        var seekingTime   = player.currentTime() + secs
        var videoDuration = player.duration()

        if (seekingTime < 0) {
            seekingTime = 0
        } else if (seekingTime > videoDuration) {
            seekingTime = videoDuration - 1
        }

        return player.currentTime(seekingTime)
    }

    function clickToPlay() {
        //btn continue
        $("#lnDescBtnPlay").click(function () {
            player.play()
            $(".learning-desc-panel").fadeOut()
        })

        //big play button
        $(".vjs-custom-big-play-button").click(function () {
            player.play()
            $(".vjs-custom-big-play-button").fadeOut()
        })
    }


    function toggleBigPlayButton() {
        $(".vjs-custom-big-play-button").hide()
        $(".vjs-play-control").bind("click", function () {
            if ($(".vjs-play-control").hasClass("vjs-paused")) {
                $(".vjs-custom-big-play-button").fadeOut()
            } else {
                $(".vjs-custom-big-play-button").fadeIn()
            }
        })

        $("video").bind("click", function () {
            if ($(".vjs-play-control").hasClass("vjs-paused")) {
                $(".vjs-custom-big-play-button").fadeOut()
            } else {
                $(".vjs-custom-big-play-button").fadeIn()
            }
        })
    }

    function toggleLectureList() {
        if (!$(".learning-lecture-list").hasClass('active')) {

            $(".learning-lecture-list").addClass('active')
            $(".learning-notes").removeClass("active")
            $(".learning-discussion").removeClass("active")
            $(".learning-files").removeClass("active")

            $("#my-video").removeClass('rightbarActive')
            $("#my-video").addClass('leftbarActive')

            $(".learning-desc-panel-body").removeClass('rightbarActive')
            $(".learning-desc-panel-body").addClass('leftbarActive')

            $(".ln-desc-bottom").removeClass("rightbarActive")
            $(".ln-desc-bottom").addClass("leftbarActive")

            $(".vjs-custom-big-play-button").removeClass('rightbarActive')
            $(".vjs-custom-big-play-button").addClass('leftbarActive')

            $(".ln-btn-note span").hide()
            $(".ln-btn-discuss span").hide()
            $(".ln-btn-file span").hide()
            $(".ln-btn-autoplay span").hide()
            $(".ln-btn-report span").hide()
        } else {

            $(".learning-lecture-list").removeClass('active')
            $("#my-video").removeClass('leftbarActive')

            $(".learning-desc-panel-body").removeClass('leftbarActive')
            $(".ln-desc-bottom").removeClass("leftbarActive")


            $(".vjs-custom-big-play-button").removeClass('leftbarActive')

            $(".ln-btn-note span").show()
            $(".ln-btn-discuss span").show()
            $(".ln-btn-file span").show()
            $(".ln-btn-autoplay span").show()
            $(".ln-btn-report span").show()
        }
    }

    function toggleDiscussion(){
        if(!$(".learning-discussion").hasClass('active')){
            // activeRightBar()
            var video_id = localStorage.getItem("indexCurrentVideo");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const request = $.ajax({
                method: 'GET',
                url: "/videos/getDiscussion",
                data: {
                    'video_id': video_id
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        console.log(response.commentVideo.data)

                        var html = '';
                        $.each(response.commentVideo.data, function( index, value ) {
                            var id = value.id
                            var avatar = (value.avatar == null) ? 'images/avatar.jpg' : value.avatar;
                            var username = value.username
                            var userType = value.userType
                            var createdAt = value.created_at
                            var children = value.children
                            var content = value.content

                            html += '<div class="ln-disc-post-wrapper">';
                                html += '<div data-toggle="collapse" data-target="#discWrapper'+ id +'">';
                                    html += '<div class="ln-disc-post-left">';
                                        html += '<img src="frontend/'+ avatar +'" width="60px" alt="">';
                                    html += '</div>';
                                    html += '<div class="ln-disc-post-right">';
                                        html += '<div class="ln-disc-post-username">';
                                        html += '<p>'+ username +' - ';
                                        html += userType;
                                        html += '</p>';
                                        html += '<span style="font-size: 0.9em;"><em>Vừa xong</em></span>';
                                        html += '</div>';
                                        html += '<div class="ln-disc-post-short-content" id="discComment'+ id +'">';
                                            html += '<p>'+ content +'</p>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</div>';

                                html += '<div id="discWrapper'+ id +'" data-parent="'+ id +'" class="ln-disc-comment-wrapper collapse">';
                                    
                                    $.each(children.data, function( indexChild, valueChild ) {
                                        var avatarChild = (valueChild.avatar == null) ? 'images/avatar.jpg' : valueChild.avatar;
                                        var usernameChild = valueChild.username
                                        var userTypeChild = valueChild.userType
                                        var createdAtChild = valueChild.created_at
                                        var contentChild = valueChild.content

                                        html += '<div class="ln-disc-comment">';
                                            html += '<div class="ln-disc-comment-left">';
                                                html += '<img src="frontend/'+ avatarChild +'" width="40px" alt="">';
                                            html += '</div>';
                                            html += '<div class="ln-disc-comment-right">';
                                                html += '<div class="ln-disc-comment-username">';
                                                    html += '<p>'+ usernameChild +' - '+ userTypeChild +'</p>';
                                                    html += '<span style="font-size: 0.75em;"><em>Vừa xong</em></span>';
                                                html += '</div>';
                                                html += '<div class="ln-disc-comment-content">';
                                                    html += '<p>'+ contentChild +'</p>';
                                                html += '</div>';
                                            html += '</div>';
                                        html += '</div>';
                                    });

                                    html += '<div class="ln-disc-comment-input input-group" id="#discSubCommentInput'+ id +'" data-parent="'+id+'">';
                                        html += '<input id="input-'+ id +'" data-child="'+ id +'" type="text" class="form-control" placeholder="Bình luận...">';
                                        html += '<span class="input-group-btn">';
                                            html += '<button data-child="'+ id +'" class="btn btn-default" type="button">Gửi</button>';
                                        html += '</span>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</div>';
                        });

                        $('.ln-disc-post-list').html(html);
                        discussEditor.setData("")
                    }
                },
                error: function () {

                }
            });

            $(".learning-discussion").addClass("active")
            $(".learning-notes").removeClass("active")
            $(".learning-files").removeClass("active")
            $(".learning-lecture-list").removeClass('active')
        } else {
            unActiveRightBar()
            $(".learning-discussion").removeClass("active")

        }
    }

    function toggleFiles() {
        if(!$(".learning-files").hasClass('active')){
            // activeRightBar()
            $(".learning-files").addClass("active")
            $(".learning-notes").removeClass("active")
            $(".learning-discussion").removeClass("active")
            $(".learning-lecture-list").removeClass('active')
            loadDocumentOfCurrentVideo();
        } else {
            unActiveRightBar()
            $(".learning-files").removeClass("active")

        }
    }

    function toggleNotes() {
        if(!$(".learning-notes").hasClass('active')){
            loadNoteOfCurrentVideo()
            player.pause()
            // activeRightBar()
            $(".learning-notes").addClass("active")
            $(".learning-files").removeClass("active")
            $(".learning-discussion").removeClass("active")
            $(".learning-lecture-list").removeClass('active')
        } else {
            unActiveRightBar()
            $(".learning-notes").removeClass("active")
        }
    }

    function loadDocumentOfCurrentVideo(){
        var currentVideo = localStorage.getItem("indexCurrentVideo");
        // get note of video
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        request = $.ajax({
            method: 'GET',
            url: "/videos/getDocument",
            data: {
                'video_id': currentVideo
            },
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    var html = '';
                    if(response.documentVideos.length > 0){
                        $.each(response.documentVideos, function( index, value ) {
                            var title = value.title
                            var url_document = value.url_document
                            html += '<div class="ln-files-wrapper">';
                            html += '<div>';
                            html += '<a href="/uploads/files/'+url_document+'" target="_blank">';
                            html += '<p>';
                            html += '<i class="fas fa-link"></i>&nbsp;';
                            html += title;
                            html += '</p>';
                            html += '</a>';
                            html += '</div>';
                            html += '</div>';
                        });
                    }else{
                        html = '<div class="text-center">Bài giảng này không có tài liệu nào!</div>';              
                    }

                    $('.ln-files-list').html(html);
                }
            },
            error: function () {

            }
        });
    }


    function loadNoteOfCurrentVideo(){
        var currentVideo = localStorage.getItem("indexCurrentVideo");
        // get note of video
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        request = $.ajax({
            method: 'GET',
            url: "/videos/getNote",
            data: {
                'video_id': currentVideo
            },
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    var html = '';
                    $.each(response.noteVideo.data, function( index, value ) {
                        var content = value.content
                        var created_at = value.created_at
                        var time_tick = value.timeTick

                        html += '<div class="ln-notes-wrapper">';
                        html += '<div>';
                        html += '<p></p><p>'+content+'</p>';
                        html += '<p></p>';
                        html += '<div>';
                        html += '<span style="font-size: smaller;"><strong>'+time_tick+'</strong></span>';
                        html += '<span style="font-size: smaller;"><i>'+created_at+'</i></span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });

                    $('.ln-notes-list').html(html);
                }
            },
            error: function () {

            }
        });
    }

    function activeRightBar(){
        $(".learning-lecture-list").removeClass('active')
        // $("#my-video").removeClass('leftbarActive')
        $("#my-video").addClass('rightbarActive')

        // $(".learning-desc-panel-body").removeClass('leftbarActive')
        $(".learning-desc-panel-body").addClass('rightbarActive')

        // $(".ln-desc-bottom").removeClass("leftbarActive")
        $(".ln-desc-bottom").addClass("rightbarActive")

        // $(".vjs-custom-big-play-button").removeClass('leftbarActive')
        $(".vjs-custom-big-play-button").addClass('rightbarActive')
        // $(".vjs-custom-big-play-button").fadeIn()

        $(".ln-btn-note span").fadeOut()
        $(".ln-btn-discuss span").fadeOut()
        $(".ln-btn-file span").fadeOut()
        $(".ln-btn-autoplay span").fadeOut()
        $(".ln-btn-report span").fadeOut()
        $("#btnContinue span").fadeOut()

        checkIfVideoIsPlaying()
    }
    function unActiveRightBar(){

        $("#my-video").removeClass('rightbarActive')
        $(".learning-desc-panel-body").removeClass('rightbarActive')
        $(".ln-desc-bottom").removeClass("rightbarActive")

        $(".vjs-custom-big-play-button").removeClass('rightbarActive')

        $(".ln-btn-note span").fadeIn()
        $(".ln-btn-discuss span").fadeIn()
        $(".ln-btn-file span").fadeIn()
        $(".ln-btn-autoplay span").fadeIn()
        $(".ln-btn-report span").fadeIn()
        $("#btnContinue span").fadeIn()

        $(".learning-lecture-list").addClass('active')

        checkIfVideoIsPlaying()

    }


    function initializePlayerControlBar() {
        //Time Controller Buttons
        var btnRewind = "<div class='btn' id='btnRewind' data-toggle='tooltip' data-placement='top' title='Lùi 5 giây'><i class='fas fa-undo-alt'></i></div>"
        var btnSpeed = $(".vjs-playback-rate.vjs-control")
        var btnForward = "<div class='btn' id='btnForward' data-toggle='tooltip' data-placement='top' title='Tới 5 giây'><i class='fas fa-redo-alt'></i></div>"

        $(".vjs-play-control").after(btnRewind)
        $("#btnRewind").after(btnSpeed)
        $(".vjs-playback-rate.vjs-control").after(btnForward)
        $(".vjs-playback-rate.vjs-control button").addClass("btn")


        //Displaying Time
        var groupPlayerTimeDiv = "<div class='group-player-time btn'></div>"
        var currentTimeSpan = "<span class='player-current-time'></span>"
        var endTimeSpan = "<span class='player-end-time'></span>"

        $("#btnForward").after(groupPlayerTimeDiv)
        $(".group-player-time").append(currentTimeSpan)
        $(".group-player-time").attr('title', 'Thời gian')
        $(".player-current-time").after(endTimeSpan)

        //Three utility buttons in the middle
        var groupBtnUtilities = "<div class='group-btn-utilities'></div>"
        var btnNote = "<div class='btn ln-btn-note' id='btnNote' data-toggle='tooltip' data-placement='top' title='Ghi chú'><i class='fas fa-sticky-note'></i><span>&nbsp;&nbsp;Ghi chú</span></div>"
        var btnDiscuss = "<div class='btn ln-btn-discuss' id='btnDiscuss' data-toggle='tooltip' data-placement='top' title='Thảo luận'><i class='fas fa-comments'></i><span>&nbsp;&nbsp;Thảo luận</span></div>"
        var btnFile = "<div class='btn ln-btn-file' id='btnFile' data-toggle='tooltip' data-placement='top' title='Tài liệu'><i class='fas fa-file-alt'></i><span>&nbsp;&nbsp;Tài liệu</span></div>"

        $(".group-player-time").after(groupBtnUtilities)
        $(".group-btn-utilities").append(btnNote)
        $("#btnNote").after(btnDiscuss)
        $("#btnDiscuss").after(btnFile)

        //Button Continue
        var btnContinue = "<div class='btn' id='btnContinue' data-toggle='tooltip' data-placement='top' title='Bài sau'><span>Bài sau&nbsp;&nbsp</span><i class='fas fa-step-forward'></i></div>"
        $(".vjs-volume-panel").before(btnContinue)

        //Video Quality Selector
        player.controlBar.addChild('QualitySelector');
        var qualitySelector = $(".vjs-quality-selector")
        var qualitySelectorIcon = "<button class='btn'><i class='fas fa-cog' id='qualitySelectorIcon'></i></button>"
        $(".vjs-fullscreen-control").before(qualitySelector)
        $(".vjs-quality-selector .vjs-icon-placeholder").remove()
        $(".vjs-quality-selector .vjs-menu-button").append(qualitySelectorIcon)

        //Button Autoplay
        var btnAutoplay
        if(localStorage.getItem('autoplay') == "true"){
            btnAutoplay = "<div class='vjs-subtitle-control btn vjs-control vjs-button' data-toggle='tooltip' data-placement='top' title='Tự động chạy'><button class='btn'><i class='fas fa-toggle-on' id='btnAutoplay'></i></button></div>"
            $(".vjs-quality-selector").after(btnAutoplay)
        }else{
            btnAutoplay = "<div class='vjs-subtitle-control btn vjs-control vjs-button' data-toggle='tooltip' data-placement='top' title='Tự động chạy'><button class='btn'><i class='fas fa-toggle-off' id='btnAutoplay'></i></button></div>"
            $(".vjs-quality-selector").after(btnAutoplay)
        }

        // $('.vjs-mute-control.vjs-control.vjs-button .vjs-control-text').text('Tắt âm')
        $('.vjs-mute-control.vjs-control.vjs-button').attr('title', 'Âm lượng')
        $('.vjs-fullscreen-control.vjs-control.vjs-button').attr('title', 'Toàn màn hình')
        $('.vjs-menu-button.vjs-menu-button-popup.vjs-button').attr('title', 'Chât lượng video')
        $('.vjs-play-control.vjs-control.vjs-button.vjs-playing').attr('title', 'Tạm dừng')
        $('.vjs-play-control.vjs-control.vjs-button.vjs-paused').attr('title', 'Chạy')

    }

    function tickCompleteLecture(e) {
        // if($('.ln-btn-complete i').hasClass("fa-circle")){
        //     $(".ln-btn-complete i").remove()
        //     $(".ln-btn-complete").append("<i class='fas fa-check-circle'></i>")
        // }else if($('.ln-btn-complete i').hasClass("fa-check-circle")){
        //     $(".ln-btn-complete i").remove()
        //     $(".ln-btn-complete").append("<i class='fas fa-circle'></i>")
        // }

        alert("This Function is still in development!!")
    }

    //Tắt autoplay tên firefox
    var isFirefox = typeof InstallTrigger !== 'undefined';
    if(isFirefox){
        $('#btnAutoplay').parent().parent().remove()
        $('.btn.ln-btn-autoplay').remove()
    }

    if($('.video-selected .fa-stack-1x').hasClass('video_not_viewed')){
        $('#lnDescBtnNotViewed').hide();
        $('#lnDescBtnViewed').show();
    }

});

function convertSecondToTimeFormat(time) {
    var hr = ~~(time / 3600);
    var min = ~~((time % 3600) / 60);
    var sec = time % 60;
    var sec_min = "";
    if (hr > 0) {
       sec_min += "" + hr + ":" + (min < 10 ? "0" : "");
    }
    sec_min += "" + min + ":" + (sec < 10 ? "0" : "");
    sec_min += "" + Math.floor(sec);
    return sec_min;
}
