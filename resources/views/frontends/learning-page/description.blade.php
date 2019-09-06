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
            <p>Đã hoàn thành {{$video_done_count}} trên {{$video_count}} bài học</p>
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
        </div>
    </div>

    <div class="ln-desc-bottom leftBarActive" >
        <div class="ln-desc-btm-center">
            <div class="ln-desc-btm-group-track">
                @if (($main_video_id_key) > 0)
                <a href="/learning-page/{{$main_video->unit->course->id}}/lecture/{{$video_id_list[$main_video_id_key-1]}}">
                    <button class="btn" id="lnDescBtnPrevious" data-toggle='tooltip' data-placement='top' title='Bài trước'><i class="fas fa-step-backward"></i></button>
                </a>
                @endif
                @if (($main_video_id_key) < (count($video_id_list) - 1) )
                <a href="/learning-page/{{$main_video->unit->course->id}}/lecture/{{$video_id_list[$main_video_id_key + 1]}}">
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