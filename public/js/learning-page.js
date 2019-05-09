$(document).ready(function () {
    // Set up the player
    var options = {
        controls: true,
        preload: 'auto',
        controlBar: {
            volumePanel: { inline: false }
        },
        playbackRates: [0.5, 1, 2]
    }
    var player = videojs('my-video', options)
    initializePlayerControlBar()
    toggleBigPlayButton()
    clickToPlay()

    
    videojs('my-video').ready(function () {
        this.on('timeupdate', function () {
            // console.log(this.currentTime());
            $(".player-current-time").html(convertSecondToTimeFormat(this.currentTime()) + ' / ')
            $(".player-end-time").html(convertSecondToTimeFormat(this.duration()))
        })
    });

    
    // $(".ln-disc-post-wrapper>div:first-child").click(function () {
        
    //     if(!$(".ln-disc-post-right p").hasClass("active")){
    //         $(".ln-disc-post-right p").addClass("active")
    //         // $(".ln-disc-comment-wrapper").addClass("active")
    //         // $(".ln-disc-comment-input").addClass("active")
    //     }else{
    //         // $(".ln-disc-comment-wrapper").removeClass("active")
    //         $(".ln-disc-post-right p").removeClass("active")
    //         // $(".ln-disc-comment-input").removeClass("active")
    //     }
    // })


    $(".lecture-title").click(function () {
        toggleLectureList()
    })
    $("#btnCloseSidebar").click(function () {
        toggleLectureList()
    })
    $(".ln-btn-complete").click(function () {
        tickCompleteLecture()
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


    function convertSecondToTimeFormat(time) {
        var hr = ~~(time / 3600);
        var min = ~~((time % 3600) / 60);
        var sec = time % 60;
        var sec_min = "";
        if (hr > 0) {
           sec_min += "" + hrs + ":" + (min < 10 ? "0" : "");
        }
        sec_min += "" + min + ":" + (sec < 10 ? "0" : "");
        sec_min += "" + Math.floor(sec);
        return sec_min;
    }
    
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
                $(".vjs-custom-big-play-button").fadeIn()
            } else {
                $(".vjs-custom-big-play-button").fadeOut()
            }
        })
    }

    function toggleLectureList() {
        if (!$(".learning-lecture-list").hasClass('active')) {

            $(".learning-lecture-list").addClass('active')
            $(".learning-discussion").removeClass("active")
            
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

            $(".learning-discussion").addClass("active")
            $(".learning-lecture-list").removeClass('active')

            $("#my-video").removeClass('leftbarActive')
            $("#my-video").addClass('rightbarActive')

            $(".learning-desc-panel-body").removeClass('leftbarActive')
            $(".learning-desc-panel-body").addClass('rightbarActive')

            $(".ln-desc-bottom").removeClass("leftbarActive")
            $(".ln-desc-bottom").addClass("rightbarActive")
            
            $(".vjs-custom-big-play-button").removeClass('leftbarActive')
            $(".vjs-custom-big-play-button").addClass('rightbarActive')

            $(".ln-btn-note span").hide()
            $(".ln-btn-discuss span").hide()
            $(".ln-btn-file span").hide()
            $(".ln-btn-autoplay span").hide()
            $(".ln-btn-report span").hide()
        } else {

            $(".learning-discussion").removeClass("active")
            $("#my-video").removeClass('rightbarActive')

            $(".learning-desc-panel-body").removeClass('rightbarActive')
            $(".ln-desc-bottom").removeClass("rightbarActive")

            $(".vjs-custom-big-play-button").removeClass('rightbarActive')

            $(".ln-btn-note span").show()
            $(".ln-btn-discuss span").show()
            $(".ln-btn-file span").show()
            $(".ln-btn-autoplay span").show()
            $(".ln-btn-report span").show()
        }
    }

    function initializePlayerControlBar() {
        //Time Controller Buttons
        var btnRewind = "<div class='btn' id='btnRewind'><i class='fas fa-undo-alt'></i></div>"
        var btnSpeed = $(".vjs-playback-rate.vjs-control")
        var btnForward = "<div class='btn' id='btnForward'><i class='fas fa-redo-alt'></i></div>"

        $(".vjs-play-control").after(btnRewind)
        $("#btnRewind").after(btnSpeed)
        $(".vjs-playback-rate.vjs-control").after(btnForward)
        $(".vjs-playback-rate.vjs-control button").addClass("btn")


        //Displaying Time
        var groupPlayerTimeDiv = "<div class='group-player-time btn'></div>"
        var currentTimeSpan = "<span class='player-current-time'>00:00 / </span>"
        var endTimeSpan = "<span class='player-end-time'> 00:00</span>"

        $("#btnForward").after(groupPlayerTimeDiv)
        $(".group-player-time").append(currentTimeSpan)
        $(".player-current-time").after(endTimeSpan)

        //Three utility buttons in the middle
        var groupBtnUtilities = "<div class='group-btn-utilities'></div>"
        var btnNote = "<div class='btn ln-btn-note' id='btnNote'><i class='fas fa-sticky-note'></i><span>&nbsp;&nbsp;Note</span></div>"
        var btnDiscuss = "<div class='btn ln-btn-discuss' id='btnDiscuss'><i class='fas fa-comments'></i><span>&nbsp;&nbsp;Discussion</span></div>"
        var btnFile = "<div class='btn ln-btn-file' id='btnFile'><i class='fas fa-file-alt'></i><span>&nbsp;&nbsp;Files</span></div>"

        $(".group-player-time").after(groupBtnUtilities)
        $(".group-btn-utilities").append(btnNote)
        $("#btnNote").after(btnDiscuss)
        $("#btnDiscuss").after(btnFile)

        //Button Continue
        var btnContinue = "<div class='btn' id='btnContinue'>Continue&nbsp;&nbsp<i class='fas fa-step-forward'></i></div>"
        $(".vjs-volume-panel").before(btnContinue)

        //Video Quality Selector
        player.controlBar.addChild('QualitySelector');
        var qualitySelector = $(".vjs-quality-selector")
        var qualitySelectorIcon = "<button class='btn'><i class='fas fa-cog' id='qualitySelectorIcon'></i></button>"
        $(".vjs-fullscreen-control").before(qualitySelector)
        $(".vjs-quality-selector .vjs-icon-placeholder").remove()
        $(".vjs-quality-selector .vjs-menu-button").append(qualitySelectorIcon)


        //Button Subtitile
        var btnSubtitle = "<div class='vjs-subtitle-control btn vjs-control vjs-button'><button class='btn'><i class='fas fa-closed-captioning' id='btnSubtitle'></i></button></div>"
        $(".vjs-quality-selector").after(btnSubtitle)



    }

    function tickCompleteLecture() {
        // if($('.ln-btn-complete i').hasClass("fa-circle")){
        //     $(".ln-btn-complete i").remove()
        //     $(".ln-btn-complete").append("<i class='fas fa-check-circle'></i>")
        // }else if($('.ln-btn-complete i').hasClass("fa-check-circle")){
        //     $(".ln-btn-complete i").remove()
        //     $(".ln-btn-complete").append("<i class='fas fa-circle'></i>")
        // }
        alert("This Function is still in development!!")
    }
});