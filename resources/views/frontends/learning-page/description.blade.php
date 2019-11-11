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
                <div class="cup-progress">
                    <div class="progress" style="width: 5vw">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>
            
        @endif
        <br>
        <div class="ln-desc-btn-play">
            <button class="btn btn-warning" id="lnDescBtnPlay" title='Chạy bài giảng'><i class="fas fa-play-circle"></i> Chạy bài giảng</button>
            @if(!(Auth::user()->isAdmin() || $main_video->unit->course->Lecturers()[0]->user->id == Auth::user()->id))
            <button class="btn btn-warning" id="lnDescBtnNotViewed" title='Chưa xem'><i class="fas fa-eye-slash"></i> Đánh dấu chưa xem</button>
            <button class="btn btn-warning" id="lnDescBtnViewed" title='Đã xem' style="display:none"><i class="fas fa-eye"></i> Đánh dấu đã xem</button>
            @endif
        </div>
        <div class="ln-desc-bottom leftBarActive" >
        <div class="ln-desc-btm-center">
            <div class="ln-desc-btm-group-track">
                <a class="lnDescBtnPreviousLink">
                    <button class="btn" id="lnDescBtnPrevious" data-toggle='tooltip' data-placement='top' title='Bài trước'><i class="fas fa-step-backward"></i></button>
                </a>
                <a class="lnDescBtnNextLink">
                    <button class="btn" id="lnDescBtnNext" data-toggle='tooltip' data-placement='top' title='Bài sau'><i class="fas fa-step-forward"></i></button>
                </a>
            </div>
            <div class="ln-desc-group-btn-utilities">
                {{-- <div class="btn ln-btn-server" data-toggle='tooltip' data-placement='top' title='Servers'>
                    <i class="fas fa-server"></i>
                    <span>&nbsp;Máy chủ video</span>
                </div> --}}
                <div class="btn ln-btn-note" data-toggle='tooltip' data-placement='top' title='Ghi chú'>
                <i class="fas fa-sticky-note"></i><span class="note-count"></span>
                    <span class="note">Ghi chú</span>
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
</div>