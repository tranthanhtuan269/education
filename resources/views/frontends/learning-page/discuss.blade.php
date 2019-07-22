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
                    var discussEditor;
                        ClassicEditor
                            .create( document.querySelector( '#discussionEditor' ),{
                                toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                            } )
                            .then(editor =>{
                                discussEditor = editor
                            } )
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
                        <img src="frontend/{{$comment_video->userRole->user->avatar}}" width="60px" alt="">
                    </div>
                    <div class="ln-disc-post-right">
                        <div class="ln-disc-post-username">
                            @php
                                $comment_user_role_id = $comment_video->userRole->role_id;
                            @endphp
                            <p>{{$comment_video->userRole->user->name}} - {{ $comment_user_role_id == 1 ? "Student" : ($comment_user_role_id == 2 ? "Teacher" : "Affliate") }}    
                            </p>
                        @if ( ($momentNow->diff($comment_video->created_at, 'months')) <= 1  )
                            <span><i>{{$momentNow->from($comment_video->created_at)}}</i></span>                    
                        @else
                            <span><i>{{ $comment_video->created_at->format("d F Y") }}</i></span>                        
                        @endif
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
                            <img src="frontend/{{$sub_comment_video->userRole->user->avatar}}" alt="">
                            </div>
                            <div class="ln-disc-comment-right">
                                <div class="ln-disc-comment-username">
                                        @php
                                            $sub_comment_user_role_id = $sub_comment_video->userRole->role_id;
                                        @endphp
                                    <p>{{$sub_comment_video->userRole->user->name}} - 
                                    @php
                                        // 1: Student, 2:Teacher
                                        echo $sub_comment_user_role_id == 1 ? "Student" : ($sub_comment_user_role_id == 2 ? "Teacher" : "Affliate");
                                    @endphp 
                                    </p>
                                    @if ( ($momentNow->diff($sub_comment_video->created_at, 'months')) <= 1  )
                                        <span><i>{{$momentNow->from($sub_comment_video->created_at)}}</i></span>                    
                                    @else
                                        <span><i>{{ $sub_comment_video->created_at->format("d F Y") }}</i></span>                        
                                    @endif
                                </div>
                                <div class="ln-disc-comment-content">
                                    {!!$sub_comment_video->content!!}
                                </div>
                                {{-- <div class="ln-disc-reply">
                                    <a><strong>Reply</strong></a>
                                </div> --}}
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
    
    $(document).on("click", ".ln-disc-input-bar .btn-submit button", function () {
        addComment()
    })
    $(document).on("click", ".ln-disc-comment-input button" ,function () {
        var parentId = $(this).attr("data-child")
        addSubComment(parentId)
    })


    function addComment(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if( discussEditor.getData() == ""){
            Swal.fire({
                type: "warning",
                text:"Content cannot be empty!"
            })         
            // Swal.fire('Any fool can use a computer')
    
        }else{
            var request = $.ajax({
            url: "{{ url('comments/store') }}",
            method: "POST",
            data: {
                videoId: {{ $main_video->id }},
                content: discussEditor.getData(),
                type : "discussionComment",
            },
            dataType: "json"
            });

            request.done(function( response ) {
                if(response.status == 200){
                    var id = response.commentVideo.data.id
                    var avatar = response.commentVideo.data.avatar
                    var username = response.commentVideo.data.username
                    var userType = response.commentVideo.data.userType
                    var createdAt = response.commentVideo.data.created_at
                    var content = response.commentVideo.data.content

                    var html = '';
                    html += '<div class="ln-disc-post-wrapper">';
                        html += '<div data-toggle="collapse" data-target="#discWrapper'+ id +'">';
                            html += '<div class="ln-disc-post-left">';
                                html += '<img src="frontend/'+ avatar +'" width="60px" alt="">';
                            html += '</div>';
                            html += '<div class="ln-disc-post-right">';
                                html += '<div class="ln-disc-post-username">';
                                html += '<p>'+ username +' - ';
                                html += userType;
                                html += '</p>';
                                html += '<span><em>Just now</em></span>';
                                html += '</div>';
                                html += '<div class="ln-disc-post-short-content" id="discComment'+ id +'">';
                                    html += '<p>'+ content +'</p>';
                                html += '</div>';
                            html += '</div>';
                        html += '</div>';
                        
                        html += '<div id="discWrapper'+ id +'" data-parent="'+ id +'" class="ln-disc-comment-wrapper collapse">';
                            html += '<div class="ln-disc-comment-input input-group" id="#discSubCommentInput'+ id +'" data-parent="'+id+'">';
                                html += '<input id="input-'+ id +'" data-child="'+ id +'" type="text" class="form-control" placeholder="Comment...">';
                                html += '<span class="input-group-btn">';
                                    html += '<button data-child="'+ id +'" class="btn btn-default" type="button">Go</button>';
                                html += '</span>';
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';
                    

                    $('.ln-disc-post-list').prepend(html);
                    discussEditor.setData("")
                }
            });
        }
        
        
        request.fail(function( jqXHR, textStatus ) {
            return false;
        });        
    }

    function addSubComment(parentId){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if($('input[data-child="'+parentId+'"]').val() == ""){
            Swal.fire({
                text:"Content cannot be empty!"
            })
        }else{
            var request = $.ajax({
                url: "{{ url('comments/store') }}",
                method: "POST",
                data: {
                    videoId: {{ $main_video->id }},
                    content: $('input[data-child="'+parentId+'"]').val(),
                    type : "discussionComment",
                    parentId : parentId,
                },
                dataType: "json",
            })
            
            request.done(function( response ) {
                if(response.status == 200){
                    // console.log(response);
                    
                    var avatar = response.commentVideo.data.avatar
                    var username = response.commentVideo.data.username
                    var userType = response.commentVideo.data.userType
                    var createdAt = response.commentVideo.data.created_at
                    var content = response.commentVideo.data.content

                    var html = '';
                    html += '<div class="ln-disc-comment">';
                        html += '<div class="ln-disc-comment-left">';
                            html += '<img src="frontend/'+ avatar +'" width="40px" alt="">';
                        html += '</div>';
                        html += '<div class="ln-disc-comment-right">';
                            html += '<div class="ln-disc-comment-username">';
                                html += '<p>'+ username +' - '+ userType +'</p>';
                                html += '<span><em>Just now</em></span>';
                            html += '</div>';
                            html += '<div class="ln-disc-comment-content">';
                                html += '<p>'+ content +'</p>';
                            html += '</div>';
                            // html += '<div class="ln-disc-reply">';
                            //     html += '<a><strong>Reply</strong></a>';
                            // html += '</div>';
                        html += '</div>';
                    html += '</div>';
                    // $("input[data-child="+response.commentVideo.data.parentId+"]").before(html)
                    $('.ln-disc-comment-input[data-parent="'+parentId+'"]').before(html);
                    $('input[data-child="'+parentId+'"]').val("")
                }
            });
            
            request.fail(function( jqXHR, textStatus ) {
                return false;
            });
        }
    }
</script>