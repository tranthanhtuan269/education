@php
    // dd($comments_video);
@endphp
<div class="learning-discussion">
    <div class="ln-disc-header">
        <div id="btnCloseDiscussion"><i class="fas fa-times-circle"></i></div>
        <p>Discussion</p>
        <p></p>
    </div>
    <div class="ln-disc-body">
        <div class="ln-disc-input-bar">
            <div class="input-group">
                <textarea name="content" id="discussionEditor"></textarea>
                <div class="btn-submit">
                    <button class="btn">Ask a question or share your opinions</button>
                </div>
                <script>
                    var myEditor;
                        ClassicEditor
                            .create( document.querySelector( '#discussionEditor' ),{
                                toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                            } )
                            .then(editor =>{
                                myEditor = editor
                            })
                            .catch( error => {
                                console.error( error );
                            } );                                
                </script>
            </div>
        </div>
        <div class="ln-disc-post-list">
            @foreach ($comments_video as $comment_video)

            <div class="ln-disc-post-wrapper">
                <div data-toggle="collapse" data-target="#discWrapper{{$comment_video->id}}">
                    <div class="ln-disc-post-left">
                        <img src="/{{$comment_video->userRole->user->avatar}}" width="60px" alt="">
                    </div>
                    <div class="ln-disc-post-right">
                        <div class="ln-disc-post-username">
                            @php
                                $comment_user_role_id = $comment_video->userRole->role_id;
                            @endphp
                        <p>{{$comment_video->userRole->user->name}} - 
                        @php
                            echo $comment_user_role_id == 1 ? "Student" : ($comment_user_role_id == 2 ? "Teacher" : "Affliate");
                        @endphp 
                        </p>
                        <span><em>{{$comment_video->created_at}}</em></span>
                        </div>
                        <div class="ln-disc-post-short-content" id="discComment{{$comment_video->id}}">
                            {!!$comment_video->content!!}
                        </div>
                    </div>
                </div>
                
                {{-- Sub-comments --}}
                <div id="discWrapper{{$comment_video->id}}" data-parent="{{$comment_video->id}}" class="ln-disc-comment-wrapper collapse">
                    @foreach ($sub_comments_video as $sub_comment_video)
                        @if ($sub_comment_video->parent_id == $comment_video->id)
                        <div class="ln-disc-comment">
                            <div class="ln-disc-comment-left">
                            <img src="/{{$sub_comment_video->userRole->user->avatar}}" width="40px" alt="">
                            </div>
                            <div class="ln-disc-comment-right">
                                <div class="ln-disc-comment-username">
                                        @php
                                            $sub_comment_user_role_id = $sub_comment_video->userRole->role_id;
                                        @endphp
                                    <p>{{$sub_comment_video->userRole->user->name}} - 
                                    @php
                                        echo $sub_comment_user_role_id == 1 ? "Student" : ($sub_comment_user_role_id == 2 ? "Teacher" : "Affliate");
                                    @endphp 
                                    </p>
                                    <span><em>{{$sub_comment_video->created_at}}</em></span>
                                </div>
                                <div class="ln-disc-comment-content">
                                    {!!$sub_comment_video->content!!}
                                </div>
                                <div class="ln-disc-reply">
                                    <a><strong>Reply</strong></a>
                                </div>
                            </div>
                        </div>                            
                        @endif
                    @endforeach
                    
                    <div class="ln-disc-comment-input input-group" id="discSubCommentInput{{$comment_video->id}}" data-parent="{{$comment_video->id}}">
                        <input data-child="{{$comment_video->id}}"  type="text" class="form-control" placeholder="Comment...">
                        <span class="input-group-btn">
                            <button data-child="{{$comment_video->id}}"  class="btn btn-default" type="button">Go</button>
                        </span>
                    </div>
                </div>
            </div>         

            @endforeach
                
        </div>
    </div>
</div>

<script >
    $(".ln-disc-input-bar .btn-submit button").click(function () {
        addComment()
    })
    $(".ln-disc-comment-input button").click(function () {
        var parentId = $(this).attr("data-child")
        alert(1)
        addSubComment(parentId)
    })
    
    function addComment(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var request = $.ajax({
        url: "{{ url('comments') }}",
        method: "POST",
        data: {
            videoId: {{ $main_video->id }},
            content: myEditor.getData(),
            type : "discussionComment",
        },
        dataType: "json"
        });
        
        request.done(function( response ) {
            if(response.status == 200){
                var html = '';
                html += '<div class="ln-disc-post-wrapper">';
                    html += '<div data-toggle="collapse" data-target="#discWrapper'+($('.ln-disc-post-wrapper').length + 1) +'">';
                        html += '<div class="ln-disc-post-left">';
                            html += '<img src="/'+response.commentVideo.data.avatar+'" width="60px" alt="">';
                        html += '</div>';
                        html += '<div class="ln-disc-post-right">';
                            html += '<div class="ln-disc-post-username">';
                            html += '<p>'+response.commentVideo.data.username+' - ';
                            html += response.commentVideo.data.userType;
                            html += '</p>';
                            html += '<span><em>'+response.commentVideo.data.created_at+'</em></span>';
                            html += '</div>';
                            html += '<div class="ln-disc-post-short-content" id="discComment'+($('.ln-disc-post-wrapper').length + 1) +'">';
                                html += '<p>'+response.commentVideo.data.content+'</p>';
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';
                    
                    html += '<div id="discWrapper'+($('.ln-disc-post-wrapper').length + 1) +'" data-parent="'+($('.ln-disc-post-wrapper').length + 1) +'" class="ln-disc-comment-wrapper collapse">';
                        html += '<div class="ln-disc-comment-input input-group">';
                            html += '<input type="text" class="form-control" placeholder="Comment...">';
                            html += '<span class="input-group-btn">';
                                html += '<button class="btn btn-default" type="button">Go</button>';
                            html += '</span>';
                        html += '</div>';
                    html += '</div>';
                html += '</div>';
                $('.ln-disc-post-list').prepend(html);
            }
        });
        
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });        
    }

    function addSubComment(parentId){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var request = $.ajax({
            url: "{{ url('comments') }}",
            method: "POST",
            data: {
                videoId: {{ $main_video->id }},
                content: $("#discSubCommentInput"+parentId+" input").val(),
                type : "discussionComment",
                parentId : parentId,
            },
            dataType: "json",
        })
        
        request.done(function( response ) {
            if(response.status == 200){
                console.log(response);
                
                var html = '';
                html += '<div class="ln-disc-comment">';
                    html += '<div class="ln-disc-comment-left">';
                        html += '<img src="/'+response.commentVideo.data.avatar +'" width="40px" alt="">';
                    html += '</div>';
                    html += '<div class="ln-disc-comment-right">';
                        html += '<div class="ln-disc-comment-username">';
                            html += '<p>'+response.commentVideo.data.username +' - '+response.commentVideo.data.userType +'</p>';
                            html += '<span><em>'+response.commentVideo.data.created_at +'</em></span>';
                        html += '</div>';
                        html += '<div class="ln-disc-comment-content">';
                            html += '<p>'+response.commentVideo.data.content +'</p>';
                        html += '</div>';
                        html += '<div class="ln-disc-reply">';
                            html += '<a><strong>Reply</strong></a>';
                        html += '</div>';
                    html += '</div>';
                html += '</div>';
                // $("input[data-child="+response.commentVideo.data.parentId+"]").before(html)
                $('#discSubCommentInput'+response.commentVideo.data.parentId).before(html);
            }
        });
        
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });    
    }
</script>