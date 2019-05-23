var isAutoplay = localStorage.getItem('autoplay')
var baseURL = $('base').attr('href');
$(document).ready(function () {
    
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
            $(".fa-toggle-on").remove()
            $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-off'></i>")
        }else if(localStorage.getItem('autoplay') == "false"){
            localStorage.setItem('autoplay', true)
            $(".fa-toggle-off").remove()
            $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-on'></i>")
        }else{
            localStorage.setItem('autoplay', true)   
            $(".fa-toggle-off").remove()
            $(".ln-btn-autoplay").prepend("<i class='fas fa-toggle-on'></i>")
        }
    })
    
    var options = {
        controls: true,
        preload: 'auto',
        autoplay : isPlayerAutoplay,
        controlBar: {
            volumePanel: { inline: false }
        },
        playbackRates: [0.5, 1, 2]
    }
    var player = videojs('my-video', options)
    initializePlayerControlBar()
    toggleBigPlayButton()
    clickToPlay()
    
    function checkIfVideoIsPlaying(){
        console.log(player.paused());
        if(player.paused()){
            $(".vjs-custom-big-play-button").css("display", "block !important")
        }else{
            $(".vjs-custom-big-play-button").css("display", "none !important")
        }
        
    }
    

    videojs('my-video').ready(function () {
        this.on('timeupdate', function () {
            // console.log(this.currentTime());
            $(".player-current-time").html(convertSecondToTimeFormat(this.currentTime()) + ' / ')
            $(".player-end-time").html(convertSecondToTimeFormat(this.duration()))
        })
    });

    $("#btnAutoplay").click(function () {
        if(localStorage.getItem('autoplay') == "true"){
            localStorage.setItem('autoplay', false)
            $("#btnAutoplay").removeClass("fa-toggle-on")
            $("#btnAutoplay").addClass("fa-toggle-off")
            // alert(1)
        }else if(localStorage.getItem('autoplay') == "false"){
            localStorage.setItem('autoplay', true)
            $("#btnAutoplay").removeClass("fa-toggle-off")
            $("#btnAutoplay").addClass("fa-toggle-on")
        }else{
            localStorage.setItem('autoplay', true)   
            $("#btnAutoplay").removeClass("fa-toggle-off")
            $("#btnAutoplay").addClass("fa-toggle-on")
        }
    })

    $(".lecture-title").click(function () {
        toggleLectureList()
    })
    $("#btnCloseSidebar").click(function () {
        toggleLectureList()
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
    $(".video-list-item").click(function () {
        var video_id = $(this).attr("data-parent")
        window.location.replace("http://courdemy.local/learning-page/"+ course_id +"/lecture/"+ video_id) 
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             var request = $.ajax({
                method: 'POST',
                url: "/user-course/update-watched",
                data: {
                    'video_id' : main_video_id
                },
                dataType: "json",
            });

            request.done(function (response){
                if(response.status){
                    if($("#lnBtnNotComplete"+main_video_id+ " button").length == 1){
                        $("#lnBtnNotComplete"+main_video_id+ " button").remove()
                        var html = ""
                            html += '<button >';
                                html += '<span class="fa-stack">';
                                    html += '<i class="fas fa-circle fa-stack-2x" style="color: #44b900;"></i>';
                                    html += '<i class="fas fa-check fa-stack-1x" style="color: #ffffff;"></i>';
                                html += '</span>';
                            html += '</button>';
                        $("#lnBtnNotComplete"+main_video_id).prepend(html)

                        var key = $("#lnBtnNotComplete"+main_video_id).attr("data-child")
                        var videoDoneOneSect =  parseInt($("#videoDoneOneSect"+key).html(), 10)
                        $("#videoDoneOneSect"+key).text(videoDoneOneSect+1)
                    }
                }
            })
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
            activeRightBar()

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
            activeRightBar()
            $(".learning-files").addClass("active")
            $(".learning-notes").removeClass("active")
            $(".learning-discussion").removeClass("active")            
            $(".learning-lecture-list").removeClass('active')
        } else {
            unActiveRightBar()
            $(".learning-files").removeClass("active")
            
        }
    }

    function toggleNotes() {
        if(!$(".learning-notes").hasClass('active')){
            player.pause()
            activeRightBar()
            $(".learning-notes").addClass("active")
            $(".learning-files").removeClass("active")
            $(".learning-discussion").removeClass("active")            
            $(".learning-lecture-list").removeClass('active')
        } else {
            unActiveRightBar()
            $(".learning-notes").removeClass("active")
            
        }
    }

    function activeRightBar(){
        $("#my-video").removeClass('leftbarActive')
        $("#my-video").addClass('rightbarActive')

        $(".learning-desc-panel-body").removeClass('leftbarActive')
        $(".learning-desc-panel-body").addClass('rightbarActive')

        $(".ln-desc-bottom").removeClass("leftbarActive")
        $(".ln-desc-bottom").addClass("rightbarActive")
        
        $(".vjs-custom-big-play-button").removeClass('leftbarActive')
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

        checkIfVideoIsPlaying()

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
        var btnContinue = "<div class='btn' id='btnContinue'><span>Continue&nbsp;&nbsp</span><i class='fas fa-step-forward'></i></div>"
        $(".vjs-volume-panel").before(btnContinue)

        //Video Quality Selector
        player.controlBar.addChild('QualitySelector');
        var qualitySelector = $(".vjs-quality-selector")
        var qualitySelectorIcon = "<button class='btn'><i class='fas fa-cog' id='qualitySelectorIcon'></i></button>"
        $(".vjs-fullscreen-control").before(qualitySelector)
        $(".vjs-quality-selector .vjs-icon-placeholder").remove()
        $(".vjs-quality-selector .vjs-menu-button").append(qualitySelectorIcon)

        //Button Subtitile
        var btnAutoplay = "<div class='vjs-subtitle-control btn vjs-control vjs-button'><button class='btn'><i class='fas fa-toggle-on' id='btnAutoplay'></i></button></div>"
        $(".vjs-quality-selector").after(btnAutoplay)
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