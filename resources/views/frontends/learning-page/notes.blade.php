
<div class="learning-notes">
    <div class="ln-notes-header">
        <div id="btnCloseNotes"><i class="fas fa-times-circle"></i></div>
        <p>Ghi chú</p>
        <p></p>
    </div>
    <div class="ln-notes-body">
        <div class="ln-notes-input-bar">
            <div class="input-group">
                <textarea name="content" id="notesEditor"></textarea>
                <div class="btn-submit">
                    <button class="btn">Lưu</button>
                    {{-- <button class="btn"> 0:51</button> --}}
                </div>
                <script>
                    var noteEditor;
                        ClassicEditor
                            .create( document.querySelector( '#notesEditor' ),{
                                toolbar: ['bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ],
                            } )
                            .then(editor =>{
                                noteEditor = editor
                            })
                            .catch( error => {
                                console.error( error );
                            } );                                
                </script>
            </div>
        </div>

        <div class="ln-notes-list">
            @foreach ($notes as $note)
            <div class="ln-notes-wrapper">
                <div>
                    <p>{!!$note->content!!}
                    </p>
                    <div>
                        <span><strong>{{\Helper::convertSecondToTimeFormat($note->time_tick)}}</strong></span>

                    @if ( ($momentNow->diff($note->created_at, 'months')) <= 1  )
                        <span><i>{{$momentNow->from($note->created_at)}}</i></span>                    
                    @else
                        <span><i>{{ $note->created_at->format("d F Y") }}</i></span>                        
                    @endif
                    
                    {{-- <span><i>{{ $note->created_at->format('d F Y') }}</i></span>              --}}
                    </div>
                </div>
            </div>                
            @endforeach
        </div>
    </div>
</div>

<script>
    $(".ln-notes-input-bar .btn-submit>button:first-child").click(function () {
        addNotes()
    })

    function addNotes(){
        var player = videojs('my-video')
        var currentTime = parseInt(player.currentTime())
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if( noteEditor.getData() == ""){
            Swal.fire({
                type:"warning",
                text:"Content cannot be empty!"
            })
                   
        }else{
            var request = $.ajax({
                url: "{{ url('notes/store') }}",
                method: "POST",
                data: {
                    videoId: {{ $main_video->id }},
                    content: noteEditor.getData(),
                    timeTick: currentTime
                },
                dataType: "json"
            });
            request.done(function (response) {
                console.log(response);
                
                var content = response.note.data.content
                var createdAt = response.note.data.created_at
                var timeTick =  response.note.data.timeTick

                var html = '';
                html += '<div class="ln-notes-wrapper">'
                    html += '<div>'
                        html += '<p>'+content+'</p>'
                        html += '<div>'
                            html += '<span><strong>'+timeTick+'</strong></span>'
                            html += '<span><i>Vừa xong</i></span>'
                        html += '</div>'
                    html += '</div>'
                html += '</div>'
                noteEditor.setData("")
                $(".ln-notes-list").prepend(html)
            })
        }
    }
</script>