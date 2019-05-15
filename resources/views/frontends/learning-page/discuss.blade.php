
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
                        <img src="/sktt1_logo.png" width="60px" alt="">
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
                    <div class="ln-disc-comment">
                        <div class="ln-disc-comment-left">
                            <img src="/pvb_logo.jpg" width="40px" alt="">
                        </div>
                        <div class="ln-disc-comment-right">
                            <div class="ln-disc-comment-username">
                                <p>Phong Vũ Buffalo - Teacher</p>
                                <span><em>3 days ago</em></span>
                            </div>
                            <div class="ln-disc-comment-content">
                                <p>Võ "Naul" Thành Luân is the mid laner for Phong Vũ Buffalo. He was previously known as Hafa.</p>
                            </div>
                            <div class="ln-disc-reply">
                                <a><strong>Reply</strong></a>
                            </div>
                        </div>
                    </div>
                    <div class="ln-disc-comment">
                        <div class="ln-disc-comment-left">
                            <img src="/g2_logo.png" width="40px" alt="">
                        </div>
                        <div class="ln-disc-comment-right">
                            <div class="ln-disc-comment-username">
                                <p>G2 Esports - Student</p>
                                <span><em>8 hours ago</em></span>
                            </div>
                            <div class="ln-disc-comment-content">
                                <p>Rasmus Winther, known by his in-game name Caps, is a Danish League of Legends player who is the Mid Laner for G2 Esports, of the LEC.</p>
                            </div>
                            <div class="ln-disc-reply">
                                <a><strong>Reply</strong></a>
                            </div>
                        </div>
                    </div>
                    <div class="ln-disc-comment-input input-group">
                        <input type="text" class="form-control" placeholder="Comment...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go</button>
                        </span>
                    </div>
                </div>
            </div>         

            @endforeach
                
        </div>
    </div>
</div>

<script >
    $(".ln-disc-input-bar .btn-submit").click(function () {
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
    })
</script>