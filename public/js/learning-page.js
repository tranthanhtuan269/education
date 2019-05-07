$( document ).ready(function() {
    // Set up the player
    var options = {
        controls:true, 
        preload: 'auto',
        controlBar: {
            volumePanel: {inline: false}
        },
        playbackRates : [0.5, 1, 2]
    }
    var player = videojs('my-video', options)
    initializePlayerControlBar()
    toggleBigPlayButton()
    clickToPlay()
    console.log($(".vjs-playback-rate").get(0));
    
    
    
    
    
    $(".lecture-title").click(function(){
        toggleLectureList()
    })
    $("#btnCloseSidebar").click(function(){
        toggleLectureList()
    })
    $(".ln-btn-complete").click(function(){
        tickCompleteLecture()
    })
    $("#btnForward").click(function(){
        seekTime(5)
    })
    $("#btnRewind").click(function(){
        seekTime(-5)
    })


    function seekTime(secs){
        var seekingTime = player.currentTime() + secs
        var videoDuration = player.duration()

        if(seekingTime < 0){
            seekingTime = 0
        }else if(seekingTime > videoDuration){
            seekingTime = videoDuration - 1
        }

        return player.currentTime(seekingTime)
    }

    function clickToPlay(){
        //btn continue 
        $("#lnDescBtnPlay").click(function(){
            player.play()
            $(".learning-desc-panel").fadeOut()
        })
        
        //big play button
        $(".vjs-custom-big-play-button").click(function(){
            player.play()
            $(".vjs-custom-big-play-button").fadeOut()
        })
    }


    function toggleBigPlayButton(){
        $(".vjs-custom-big-play-button").hide()
        $(".vjs-play-control").bind("click", function(){
                if($(".vjs-play-control").hasClass("vjs-paused")){
                    $(".vjs-custom-big-play-button").fadeOut()       
                }else{
                    $(".vjs-custom-big-play-button").fadeIn()       
                }
        })

        $("video").bind("click", function(){
            if($(".vjs-play-control").hasClass("vjs-paused")){
                $(".vjs-custom-big-play-button").fadeIn()       
            }else{
                $(".vjs-custom-big-play-button").fadeOut()       
            }
        })
    }

    function toggleLectureList(){
        if(!$(".learning-lecture-list").hasClass('active')){
            
            $(".learning-lecture-list").addClass('active')
            $("#my-video").addClass('sidebarActive')
            $(".learning-desc-panel-body").addClass('sidebarActive')
            $(".vjs-custom-big-play-button").addClass('active')
            $("#btnNote span").hide()
            $("#btnDiscuss span").hide()
            $("#btnFile span").hide()
        }else{

            $(".learning-lecture-list").removeClass('active')
            $("#my-video").removeClass('sidebarActive')
            $(".learning-desc-panel-body").removeClass('sidebarActive')
            $(".vjs-custom-big-play-button").removeClass('active')
            $("#btnNote span").show()
            $("#btnDiscuss span").show()
            $("#btnFile span").show()

        }
    }

    function initializePlayerControlBar(){
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
        var currentTimeSpan = "<span class='player-current-time'>00:00 /</span>"
        var endTimeSpan  = "<span class='player-end-time'> 17:09</span>"

        $("#btnForward").after(groupPlayerTimeDiv)
        $(".group-player-time").append(currentTimeSpan)
        $(".player-current-time").after(endTimeSpan)

        //Three utility buttons in the middle
        var groupBtnUtilities = "<div class='group-btn-utilities'></div>"
        var btnNote = "<div class='btn' id='btnNote'><i class='fas fa-sticky-note'></i><span>&nbsp;&nbsp;Note</span></div>"
        var btnDiscuss = "<div class='btn' id='btnDiscuss'><i class='fas fa-comments'></i><span>&nbsp;&nbsp;Discussion</span></div>"
        var btnFile = "<div class='btn' id='btnFile'><i class='fas fa-file-alt'></i><span>&nbsp;&nbsp;Files</span></div>"

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

    function tickCompleteLecture(){
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