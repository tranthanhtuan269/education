<div class="learning-desc-panel ">
    <div class="learning-desc-panel-body align-items-center">
        <div class="ln-desc-title">
            <p>{{$main_video->name}}</p>
        </div>
        <div class="ln-desc-subtitle">
            <p>Section {{$main_video->unit->index}}, Lecture {{$main_video->index}}</p>
        </div>
        <div class="ln-desc-content">
        <p>{{$main_video->description}}</p>
        </div>
        <div class="ln-desc-achv">
            <p>10 of {{$course->video_count}} items completed</p>
            <div class="ln-progress-bar">
                <div class="progress lecture-progress" style="width: 30vw">
                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                &nbsp;
                <div class="cup-progress">
                    <div class="progress" style="width: 5vw">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>
        <br>
        <div class="ln-desc-btn-play">
            <button class="btn btn-warning" id="lnDescBtnPlay"><i class="fas fa-play-circle"></i> Continue</button>
        </div>
    </div>

    <div class="ln-desc-bottom">
        <div class="ln-desc-btm-center">
            <div class="ln-desc-btm-group-track">
                @if (($main_video_id_key) > 0)
                <a href="{{$video_id_list[$main_video_id_key-1]}}">
                    <button class="btn" id="lnDescBtnPrevious"><i class="fas fa-step-backward"></i></button>
                </a>
                @endif
                @if (($main_video_id_key) < (count($video_id_list) - 1) )
                <a href="{{$video_id_list[$main_video_id_key + 1]}}">
                    <button class="btn" id="lnDescBtnNext"><i class="fas fa-step-forward"></i></button>
                </a>
                @endif
            </div>
            <div class="ln-desc-group-btn-utilities">
                <div class="btn ln-btn-server">
                    <i class="fas fa-server"></i>
                    <span>&nbsp;Server Video</span>
                </div>
                <div class="btn ln-btn-note">
                    <i class="fas fa-sticky-note"></i>
                    <span>&nbsp;Note</span>
                </div>
                <div class="btn ln-btn-discuss">
                    <i class="fas fa-comments"></i>
                    <span>&nbsp;Discussion</span>
                </div>
                <div class="btn ln-btn-file">
                    <i class="fas fa-file-alt"></i>
                    <span>&nbsp;Files</span>
                </div>
            </div>
            <div class="ln-desc-group-btn-utilities-2">
                <div class="btn ln-btn-autoplay">
                    <i class="fas fa-toggle-on"></i>
                    <span>&nbsp;Autoplay</span>
                </div>
                <div class="btn ln-btn-report">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>&nbsp;Report</span>
                </div>
            </div>
        </div>
    </div>
</div>