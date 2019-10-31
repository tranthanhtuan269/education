<?php 
$i = 0;
foreach ($notes as $key => $note) {
    # code...
    $i++;
}
// dd($i);
?>
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
                <i class="fas fa-sticky-note"></i><span class="note-count"></span>
                    <span class="note">&nbsp;Ghi chú</span>
                </div>
                <div class="btn ln-btn-discuss" data-toggle='tooltip' data-placement='top' title='Thảo luận'>
                    <i class="fas fa-comments"></i><span class="comment-count"></span>
                    <span class="comment">&nbsp;Thảo luận</span>
                </div>
                <div class="btn ln-btn-file" data-toggle='tooltip' data-placement='top' title='Tài liệu'>
                    <i class="fas fa-file-alt"></i><span class="document-count"></span>
                    <span class="document">&nbsp;Tài liệu</span>
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
<style>
    .ln-btn-note .note-count, .ln-btn-file .document-count ,.ln-btn-discuss .comment-count{
        background-color: #FF8F00;
        border-radius: 50%;
        font-size: 10px;
        position: absolute;
        top: -2px;
        left: 20px;
        font-weight: bold;
        width: 15px;
        height: 15px;
    }
    .ln-btn-note .note, .ln-btn-file .document .ln-btn-discuss .comment{
        padding-left: 5px;
    }
    .ln-btn-note, .ln-btn-discuss, .ln-btn-file{
        position: relative;
    }
</style>
<script>
    $(document).ready(function (){
        $('#lnDescBtnNotViewed').on('click', function(e){
            e.preventDefault()
            e.stopPropagation()
            var video_id_index = localStorage.getItem("indexCurrentVideo")

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                method: 'POST',
                url: "/user-course/update-not-watched",
                data: {
                    'video_id' : video_id_index
                },
                dataType: "json",
            });
            request.done(function(){
                $("#viewed_count").html(parseInt($("#viewed_count").html()) - 1)
                $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
                $('#lnDescBtnViewed').show()
                $('#lnDescBtnNotViewed').hide()
                $('#lnBtnComplete' + video_id_index + ' .fa-stack-2x').addClass('video_not_viewed').removeClass('video_viewed');
                $('#lnBtnComplete' + video_id_index + ' .fa-stack-1x').addClass('video_not_viewed').removeClass('video_viewed');
                $('#lnBtnComplete' + video_id_index).attr('id', 'lnBtnNotComplete'+ video_id_index);
            })
        })

        $('#lnDescBtnViewed').on('click', function(e){
            e.preventDefault()
            e.stopPropagation()
            var sefl = this;
            var video_id_index = localStorage.getItem("indexCurrentVideo")

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                method: 'POST',
                url: "/user-course/update-watched",
                data: {
                    'video_id' : video_id_index
                },
                dataType: "json",
            });
            request.done(function(){
                $("#viewed_count").html(parseInt($("#viewed_count").html()) + 1)
                $(".progress-bar-success").css('width', parseInt($("#viewed_count").html() / $("#videos_count").html() * 100) + "%");
                $('#lnDescBtnViewed').hide()
                $('#lnDescBtnNotViewed').show()
                $('#lnBtnNotComplete' + video_id_index).find('.fa-stack-2x').removeClass('video_not_viewed').addClass('video_viewed');
                $('#lnBtnNotComplete' + video_id_index).find('.fa-stack-1x').removeClass('video_not_viewed').addClass('video_viewed');
                $('#lnBtnNotComplete' + video_id_index).attr('id', 'lnBtnComplete'+ video_id_index);
            })
        })
    })
</script>