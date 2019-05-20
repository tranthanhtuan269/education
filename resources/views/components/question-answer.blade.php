<div class="box clearfix">
    <div class="col-sm-3">
        <img class="avatar" src="" alt="" />
        <div class="info-account">
            <p class="interval"></p>
            <p class="name">PHP</p>
        </div>
    </div>
    <div class="col-sm-9">
        @include(
            'components.vote', 
            [
                'rate' => 2,
            ]
        )
        <div class="comment">
            AAAAAA
        </div>
        <div class="btn-action">
            <button type="button" class="btn btn-default">
                <i class="fas fa-comment"></i>
                <span>Reply</span>
            </button>
            <button type="button" class="btn btn-default">
                <i class="fas fa-thumbs-up"></i>
                <span>Like</span>
            </button>
            <button type="button" class="btn btn-default">
                <i class="fas fa-thumbs-down"></i>
                <span>Dislike</span>
            </button>
        </div>
        {{-- @if ( $key == 0 )
        <div class="editor-reply-comment {{  $comment->id }}">
            <textarea name="content" id="editor-reply-comment" placeholder="Comment..."></textarea>
            <div class="btn-submit">
                <input class="submit-question" type="submit" value="REPLY" id="reply-comment"/>
            </div>
            <script>
                ClassicEditor
                    .create( document.querySelector( '#editor-reply-comment' ) )
                    .then( editor => {
                        content = editor;
                    } )
                    .catch( error => {
                            console.error( error );
                } );
                $('#create-comment-new').click(function(){
                    var data    = {
                        _method           : "POST",
                        content : content.getData(),
                        course_id : {{ $info_course->id }},
                        parent_id : 0,
                        state : 0,
                    };

                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN'    : $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: '{{ url("/comment/comment-course") }}',
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.alert-errors').html('');
                        },
                        complete: function(data) {
                            if (data.responseJSON.status == 200) {
                                // alert('ok');
                                $().toastmessage('showSuccessToast', data.responseJSON.message);
                                setTimeout(function() {
                                    window.location.href = '{{ url()->current() }}';
                                }, 1000);
                            } else {
                                if (data.status == 422) {
                                    $().toastmessage('showErrorToast', 'Errors');
                                    var tmp = 0;
                                    $.each(data.responseJSON.errors, function(index, value) {
                                        $('.alert-' + index).html(value);
                                        if (tmp == 0) {
                                            $('.alert-' + index).attr("tabindex", -1).focus();
                                        }
                                        tmp++;
                                    });
                                } else {
                                    if (data.status == 401) {
                                        window.location.replace(baseURL);
                                    } else {
                                        $().toastmessage('showErrorToast', errorConnect);
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
        @endif --}}
        {{-- <div class="comment-reply">
            <div>
                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                <div class="info-account">
                    <p class="interval">1 week ago</p>
                    <p class="name">Bảo Minh</p>
                </div>
            </div>
            <p class="comment">
                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
            </p>
            <div class="btn-action">
                <button type="button" class="btn btn-default">
                    <i class="fas fa-comment"></i>
                    <span>Share</span>
                </button>
                <button type="button" class="btn btn-default">
                    <i class="fas fa-thumbs-up"></i>
                    <span>Reply</span>
                </button>
                <button type="button" class="btn btn-default">
                    <i class="fas fa-thumbs-down"></i>
                    <span>Dislike</span>
                </button>
            </div>
        </div> --}}
    </div>
    <div class="col-sm-12">
        <hr>
    </div>
</div>

{{-- <div class="box clearfix">
    <div class="col-sm-3">
        <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
        <div class="info-account">
            <p class="interval">1 week ago</p>
            <p class="name">Bảo Minh</p>
        </div>
    </div>
    <div class="col-sm-9">
        @include(
            'components.vote', 
            [
                'rate' => 2,
            ]
        )
        <p class="comment">
            Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
        </p>
        <div class="btn-action">
            <button type="button" class="btn btn-default">
                <i class="fas fa-comment"></i>
                <span>Share</span>
            </button>
            <button type="button" class="btn btn-default">
                <i class="fas fa-thumbs-up"></i>
                <span>Reply</span>
            </button>
            <button type="button" class="btn btn-default">
                <i class="fas fa-thumbs-down"></i>
                <span>Dislike</span>
            </button>
        </div>
        <div class="comment-reply">
            <div>
                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                <div class="info-account">
                    <p class="interval">1 week ago</p>
                    <p class="name">Bảo Minh</p>
                </div>
            </div>
            <p class="comment">
                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
            </p>
            <div class="btn-action">
                <button type="button" class="btn btn-default">
                    <i class="fas fa-comment"></i>
                    <span>Share</span>
                </button>
                <button type="button" class="btn btn-default">
                    <i class="fas fa-thumbs-up"></i>
                    <span>Reply</span>
                </button>
                <button type="button" class="btn btn-default">
                    <i class="fas fa-thumbs-down"></i>
                    <span>Dislike</span>
                </button>
            </div>
        </div>
        <div class="comment-reply">
            <div>
                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                <div class="info-account">
                    <p class="interval">1 week ago</p>
                    <p class="name">Bảo Minh</p>
                </div>
            </div>
            <p class="comment">
                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
            </p>
            <div class="btn-action">
                <button type="button" class="btn btn-default">
                    <i class="fas fa-comment"></i>
                    <span>Share</span>
                </button>
                <button type="button" class="btn btn-default">
                    <i class="fas fa-thumbs-up"></i>
                    <span>Reply</span>
                </button>
                <button type="button" class="btn btn-default">
                    <i class="fas fa-thumbs-down"></i>
                    <span>Dislike</span>
                </button>
            </div>
        </div>
    </div>
</div> --}}