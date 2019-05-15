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
            @for ($i = 1; $i < 5; $i++)
            <div class="ln-disc-post-wrapper">
                <div data-toggle="collapse" data-target="#discWrapper{{$i}}">
                    <div class="ln-disc-post-left">
                        <img src="/sktt1_logo.png" width="60px" alt="">
                    </div>
                    <div class="ln-disc-post-right">
                        <div class="ln-disc-post-username">
                            <p>SKT T1 - Student</p>
                            <span><em>03/02/2019, 18:15</em></span>
                        </div>
                    <div class="ln-disc-post-short-content">
                            <p id="discComment{{$i}}">Lee Sang-hyeok, được biết đến với nghệ danh Faker, sinh ngày 7 tháng 5 năm 1996 tại Seoul, là thành viên của đội tuyển thể thao điện tử SK Telecom T1 với game Liên Minh Huyền Thoại. Sang-Hyeok được giới chơi Liên Minh Huyền Thoại coi là một trong những người chơi Liên Minh Huyền Thoại hay nhất hiện nay.</p>
                        </div>
                    </div>
                </div>
                
                <div id="discWrapper{{$i}}" data-parent="discComment{{$i}}" class="ln-disc-comment-wrapper collapse">
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
                
            @endfor
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
            "_token": "{{ csrf_token() }}"
            
        },
        dataType: "json"
        });
        
        request.done(function( msg ) {
        $( "#log" ).html( msg );
        });
        
        request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
        });        
    })
</script>