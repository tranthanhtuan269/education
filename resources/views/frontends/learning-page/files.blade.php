<div class="learning-files">
    <div class="ln-files-header">
        <div id="btnCloseFiles"><i class="fas fa-times-circle"></i></div>
        <p>Files</p>
        <p></p>
    </div>
    <div class="ln-files-body">
        <div class="ln-files-list">
            @foreach ($files as $file)
                <div class="ln-files-wrapper">
                    <div>
                    <a href="{{$file->url_document}}" target="_blank">
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