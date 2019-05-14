<div class="learning-notes">
    <div class="ln-notes-header">
        <div id="btnCloseNotes"><i class="fas fa-times-circle"></i></div>
        <p>Notes</p>
        <p></p>
    </div>
    <div class="ln-notes-body">
        <div class="ln-notes-input-bar">
            <div class="input-group">
                <textarea name="content" id="notesEditor"></textarea>
                <div class="btn-submit">
                    <button class="btn">Save</button>
                    <button class="btn"> 0:51</button>
                </div>
                <script>
                        ClassicEditor
                            .create( document.querySelector( '#notesEditor' ),{
                                toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                            } )
                            .catch( error => {
                                console.error( error );
                            } );                                
                </script>
            </div>
        </div>

        <div class="ln-notes-list">
            @for ($i = 0; $i < 5; $i++)
            <div class="ln-notes-wrapper">
                <div>
                    <p>Having played competitively since 2005, Lindberg, going by the pseudonym of "f0rest", has widely gained a reputation within the electronic sports scene as one of the best-performing Counter-Strike players in the world.
                    </p>
                    <div>
                        <span><strong>0:51</strong></span>
                        <span><i>20/11/2019, 20:15</i></span>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>