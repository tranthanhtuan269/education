<div class="modal" id="playerReportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                                <i class="fas fa-times-circle"></i>
                        </span>
                    </button>
                <h4 class="modal-title">
                    Report
                </h4>
            </div>
            <div class="modal-body">
                <h5>Title:</h5>
                <input class="form-control" type="text" name="title" id="videoReportTitle">
                <h5>Your message:</h5>
                <textarea name="content" id="reportEditor"></textarea>
                <script>
                        var reportEditor;
                            ClassicEditor
                                .create( document.querySelector( '#reportEditor' ),{
                                    toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                                } )
                                .then(editor =>{
                                    reportEditor = editor
                                } )
                                .catch( error => {
                                    console.error( error );
                                } );                                
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSubmitVideoReport" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#btnSubmitVideoReport").click(function () {
        submitReport()
    })
    function submitReport(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(reportEditor.getData() == ""){
            return Swal.fire({
                type: "warning",
                text: "Message cannot be empty!"
            })
        } else if($("#videoReportTitle").val() == ""){
            return Swal.fire({
                type: "warning",
                text: "Title cannot be empty!"
            })
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                url : "{{url('reports/store')}}",
                method: "POST",
                data : {
                    videoId : {{$main_video->id}},
                    title   : $("#videoReportTitle").val(),
                    message : reportEditor.getData(),
                }
            })

            request.done(function (response) {
                if(response.status == 200){
                    Swal.fire({
                        type: "success",
                        text : response.message,
                    }).then(function (result){
                        if(result.value){
                            $("#videoReportTitle").val("")
                            reportEditor.setData("")
                            $("#playerReportModal").modal("hide")
                        }
                    })
                    
                }
            })
        }
    }
</script>