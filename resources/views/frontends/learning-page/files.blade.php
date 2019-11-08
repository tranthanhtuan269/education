<div class="learning-files">
    <div class="btn-showhide btn-show btn-files"><i class="fa fa-angle-double-left" aria-hidden="true"></i></div>
    <div class="btn-showhide btn-hide btn-files"><i class="fa fa-angle-double-right" aria-hidden="true"></i></div>
    <div class="ln-files-header">
        <div id="btnCloseFiles"><i class="fas fa-times-circle"></i></div>
        <p>Tài liệu</p>
        <p></p>
    </div>
    <div class="ln-files-body">
        <div class="ln-files-list">
            @if ($files->count() == 0)
                <div class="text-center">
                    Không có tài liệu nào tương ứng
                </div>
            @endif
            @foreach ($files as $file)
                <div class="ln-files-wrapper">
                    <div>
                    <a href="/uploads/files/{{$file->url_document}}" target="_blank">
                            <p>
                                <i class="fas fa-link"></i>&nbsp;
                                {{$file->title}}
                            </p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>