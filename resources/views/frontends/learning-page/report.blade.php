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
                    Báo lỗi
                </h4>
            </div>
            <div class="modal-body">
                <h5>Tiêu đề:</h5>
                <input class="form-control" type="text" name="title" id="videoReportTitle">
                <h5>Mô tả lỗi:</h5>
                <textarea name="content" id="reportEditor"></textarea>
                <script>
                        // var reportEditor;
                        //     ClassicEditor
                        //         .create( document.querySelector( '#reportEditor' ),{
                        //             toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                        //         } )
                        //         .then(editor =>{
                        //             reportEditor = editor
                        //         } )
                        //         .catch( error => {
                        //             console.error( error );
                        //         } );
                                CKEDITOR.replace( 'reportEditor', {
                            toolbar : [
                                { name: 'basicstyles', items: [ 'Bold', 'Italic'] },
                                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList'] },
                            ],
                        });   
                        var reportEditor = CKEDITOR.instances.reportEditor
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSubmitVideoReport" class="btn btn-primary">Gửi</button>
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
                text: "Bạn chưa nhập mô tả lỗi!"
            })
        } else if($("#videoReportTitle").val() == ""){
            return Swal.fire({
                type: "warning",
                text: "Bạn chưa nhập tiêu đề!"
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
                },
                dataType: 'json',
                success: (response) => {
                    if(response.status == 200){
                        Swal.fire({
                            type: "success",
                            text : response.message,
                            confirmButtonText: 'Đồng ý'
                        }).then(function (result){
                            if(result.value){
                                $("#videoReportTitle").val("")
                                reportEditor.setData("")
                                $("#playerReportModal").modal("hide")
                            }
                        })                        
                    }
                },
                error: (error) =>{
                    $(".ajax_waiting").removeClass("loading");
                    if(error){
                        var obj_errors = error.responseJSON.errors;
                        var txt_errors = '';
                        for (k of Object.keys(obj_errors)) {
                            txt_errors += obj_errors[k][0] + '</br>';
                        }
                        Swal.fire({
                            type: 'warning',
                            html: txt_errors,
                            allowOutsideClick: false,
                            confirmButtonText: 'Đồng ý'
                        })
                    }
                }
            })
        }
    }
</script>