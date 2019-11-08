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
    </div>
</div>