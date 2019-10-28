<div class="learning-desc-panel ">
    <div class="learning-desc-panel-body align-items-center leftbarActive">
        <div class="ln-desc-title">
            <p>{{$main_video->name}}</p>
        </div>
        <div class="ln-desc-subtitle">
            <p>Phần {{$main_video->unit->index}}, Bài {{$main_video->index}}</p>
        </div>
        {{-- <div class="ln-desc-content">
        {!!$main_video->description!!}
        </div> --}}
        @if ($isStudent)
        <div class="ln-desc-achv">
            <p>Đã hoàn thành <strong id="viewed_count">{{$video_done_count}}</strong> trên <strong id="videos_count">{{$video_count}}</strong> bài học</p>
            <div class="ln-progress-bar">
                <div class="progress lecture-progress" style="width: 30vw">
                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: {{$video_done_percent}}%" aria-valuenow="{{$video_done_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                &nbsp;
                @if ($video_done_percent == 100)
                    <div class="cup-progress">
                        <div class="progress" style="width: 5vw">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <i class="fas fa-trophy" style="color: goldenrod"></i>
                    </div>
                @else
                    <div class="cup-progress">
                        <div class="progress" style="width: 5vw">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <i class="fas fa-trophy"></i>
                    </div>
                @endif
            </div>
        </div>
            
        @endif
        <br>
        <div class="ln-desc-btn-play">
            <button class="btn btn-warning" id="lnDescBtnPlay" title='Chạy bài giảng'><i class="fas fa-play-circle"></i> Chạy bài giảng</button>
            <button class="btn btn-warning" id="lnDescBtnNotViewed" title='Chưa xem'><i class="fas fa-eye-slash"></i> Đánh dấu chưa xem</button>
            <button class="btn btn-warning" id="lnDescBtnViewed" title='Đã xem' style="display:none"><i class="fas fa-eye"></i> Đánh dấu đã xem</button>
        </div>
    </div>

    <div class="ln-desc-bottom leftBarActive" >
        <div class="ln-desc-btm-center">
            <div class="ln-desc-btm-group-track">
                @if (($main_video_id_key) > 0)
                <a>
                    <button class="btn" id="lnDescBtnPrevious" data-toggle='tooltip' data-placement='top' title='Bài trước'><i class="fas fa-step-backward"></i></button>
                </a>
                @endif
                @if (($main_video_id_key) < (count($video_id_list) - 1) )
                <a >
                    <button class="btn" id="lnDescBtnNext" data-toggle='tooltip' data-placement='top' title='Bài sau'><i class="fas fa-step-forward"></i></button>
                </a>
                @endif
            </div>
            <div class="ln-desc-group-btn-utilities">
                {{-- <div class="btn ln-btn-server" data-toggle='tooltip' data-placement='top' title='Servers'>
                    <i class="fas fa-server"></i>
                    <span>&nbsp;Máy chủ video</span>
                </div> --}}
                <div class="btn ln-btn-note" data-toggle='tooltip' data-placement='top' title='Ghi chú'>
                    <i class="fas fa-sticky-note"></i>
                    <span>&nbsp;Ghi chú</span>
                </div>
                <div class="btn ln-btn-discuss" data-toggle='tooltip' data-placement='top' title='Thảo luận'>
                    <i class="fas fa-comments"></i>
                    <span>&nbsp;Thảo luận</span>
                </div>
                <div class="btn ln-btn-file" data-toggle='tooltip' data-placement='top' title='Tài liệu'>
                    <i class="fas fa-file-alt"></i>
                    <span>&nbsp;Tài liệu</span>
                </div>
            </div>
            <div class="ln-desc-group-btn-utilities-2" data-toggle='tooltip' data-placement='top' title='Tự động chạy'>
                <div class="btn ln-btn-autoplay">
                    <span>&nbsp;Tự động chạy</span>
                </div>
                <div class="btn ln-btn-report" data-toggle="modal" data-target="#playerReportModal" data-toggle='tooltip' data-placement='top' title='Báo lỗi'>
                    <i class="fas fa-exclamation-circle"></i>
                    <span>&nbsp;Báo lỗi</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('#lnDescBtnNotViewed').on('click', function(e){
            e.preventDefault()
            e.stopPropagation()
            var video_id_index = null
            video_id_list.forEach(video_id => {
                if(video_id == {{$main_video->id}}){
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
                url: "/user-course/update-not-watched",
                data: {
                    'video_id' : video_id_list[video_id_index]
                },
                dataType: "json",
            });
            request.done(function(){
                // alert('one');
                $("#viewed_count").html(parseInt($("#viewed_count").html()) - 1)
                $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
                
                $('#lnDescBtnViewed').show()
                $('#lnDescBtnNotViewed').hide()
                $('#lnBtnComplete' + (video_id_index + 1)).find('.fa-stack-2x').css('color', 'rgb(200, 201, 202)');
                $('#lnBtnComplete' + (video_id_index + 1)).find('.fa-stack-1x').css('color', 'rgb(200, 201, 202)');
                $('#lnBtnComplete' + (video_id_index + 1)).attr('id', 'lnBtnNotComplete'+ (video_id_index + 1));
                // alert("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
                // window.location.href = ("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
            })
        })

        $('#lnDescBtnViewed').on('click', function(e){
            e.preventDefault()
            e.stopPropagation()
            var sefl = this;
            var video_id_index = null
            video_id_list.forEach(video_id => {
                if(video_id == {{$main_video->id}}){
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
                    'video_id' : video_id_list[video_id_index]
                },
                dataType: "json",
            });
            request.done(function(){
                // alert('one');
                console.log(video_id_index);
                $('#lnDescBtnViewed').hide()
                $('#lnDescBtnNotViewed').show()

                $('#lnBtnNotComplete' + (video_id_index + 1)).find('.fa-stack-2x').css('color', '#44b900');
                $('#lnBtnNotComplete' + (video_id_index + 1)).find('.fa-stack-1x').css('color', '#ffffff');
                $('#lnBtnNotComplete' + (video_id_index + 1)).attr('id', 'lnBtnComplete'+ (video_id_index + 1));
                // alert("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
                // window.location.href = ("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
            })
        })
        
        $('#lnDescBtnNext').on('click', function(e){
            e.preventDefault()
            e.stopPropagation()
            var video_id_index = null
            video_id_list.forEach(video_id => {
                if(video_id == {{$main_video->id}}){
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
            request.done(function(){
                // alert("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
                window.location.href = ("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
            })
        })

        $('#lnDescBtnPrevious').on('click', function(e){
            e.preventDefault()
            e.stopPropagation()
            var video_id_index = null
            video_id_list.forEach(video_id => {
                if(video_id == {{$main_video->id}}){
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
            request.done(function(){
                // alert("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index + 1]+"")
                window.location.href = ("/learning-page/"+course_id+"/lecture/"+video_id_list[video_id_index - 1 ]+"")
            })
        })
    })
</script>