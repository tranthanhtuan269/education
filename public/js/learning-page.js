$( document ).ready(function() {
    initializePlayerControlBar()
    $(".lecture-title").click(function(){
        toggleLectureList()
    })
    $("#btnCloseSidebar").click(()=>{
        toggleLectureList()

    })


    var player = videojs('my-video');
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
        
    }
    
});