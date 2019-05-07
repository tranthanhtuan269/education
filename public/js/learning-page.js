$( document ).ready(function() {
    $(".lecture-title").click(function(){
        toggleLectureList()
    })
    $("#btnCloseSidebar").click(function(){
        toggleLectureList()

    })


    $(".ln-btn-complete").click(function(){
        tickCompleteLecture()
    })
    

    
    var player = videojs('my-video', {controls:true, preload: 'auto',controlBar: {
        volumePanel: {inline: false}
    },})
    initializePlayerControlBar()
    
    $(".vjs-play-control").bind("click", function(){
            if($(".vjs-play-control").hasClass("vjs-paused")){
                $(".learning-desc-panel").fadeOut()       
            }else{
                $(".learning-desc-panel").fadeIn()       
            }
    })
    $("video").bind("click", function(){
        if($(".vjs-play-control").hasClass("vjs-paused")){
            $(".learning-desc-panel").fadeIn()       
        }else{
            $(".learning-desc-panel").fadeOut()       
        }
    })

    $("#lnDescBtnPlay").click(function(){
        player.play()
        $(".learning-desc-panel").fadeOut()
    })



    function toggleLectureList(){
        if(!$(".learning-lecture-list").hasClass('active')){
            
            $(".learning-lecture-list").addClass('active')
            $("#my-video").addClass('sidebarActive')
            $(".learning-desc-panel-body").addClass('sidebarActive')
        }else{

            $(".learning-lecture-list").removeClass('active')
            $("#my-video").removeClass('sidebarActive')
            $(".learning-desc-panel-body").removeClass('sidebarActive')
        }
    }

    function initializePlayerControlBar(){
        //Time Controller Buttons
        var speedGroup = "<div class='group-btn-control-time'></div>"
        var btnRewind = "<button class='btn' id='btnRewind'><i class='fas fa-undo-alt'></i></button>"
        var btnSpeed = "<button id='btnSpeed' class='btn btn-primary'>1x</button>"
        var btnForward = "<button class='btn' id='btnRewind'><i class='fas fa-redo-alt'></i></button>"
        
        $(".vjs-play-control").after(speedGroup)
        $(".group-btn-control-time").append(btnRewind)
        $("#btnRewind").after(btnSpeed)
        $("#btnSpeed").after(btnForward)


        //Displaying Time
        var groupPlayerTimeDiv = "<div class='group-player-time btn'></div>"
        var currentTimeSpan = "<span class='player-current-time'>00:00 /</span>"
        var endTimeSpan  = "<span class='player-end-time'> 17:09</span>"

        $(".group-btn-control-time").after(groupPlayerTimeDiv)
        $(".group-player-time").append(currentTimeSpan)
        $(".player-current-time").after(endTimeSpan)

        //Three utility buttons in the middle
        var groupBtnUtilities = "<div class='group-btn-utilities'></div>"
        var btnNote = "<div class='btn' id='btnNote'><i class='fas fa-sticky-note'></i>&nbsp;&nbsp;Note</div>"
        var btnDiscuss = "<div class='btn' id='btnDiscuss'><i class='fas fa-comments'></i>&nbsp;&nbsp;Discussion</div>"
        var btnFile = "<div class='btn' id='btnFile'><i class='fas fa-file-alt'></i>&nbsp;&nbsp;Files</div>"

        $(".group-player-time").after(groupBtnUtilities)
        $(".group-btn-utilities").append(btnNote)
        $("#btnNote").after(btnDiscuss)
        $("#btnDiscuss").after(btnFile)


        var btnContinue = "<div class='btn' id='btnContinue'>Continue&nbsp;&nbsp<i class='fas fa-step-forward'></i></div>"
        $(".vjs-volume-panel").before(btnContinue)

        
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