<div class="tab-pane" id="tab_add_teacher">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Ảnh đại diện <span class="text-danger">*</span></label>
        <div class="col-sm-8 image-cropit-editor">
            <div>
                <img id="imageTch" style="height:150px;" src="">
                <input type="file" id="addTchImgInput" style="display:none;">
            </div>
            <div style="margin-top: 0.5em">
                <button id="btnSelectImage" class="btn btn-primary">Chọn ảnh</button>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Tên <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchName" name="name">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchEmail" name="email">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Sô điện thoại <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchPhone" name="phone">                                       
        </div>
        <script>
            
        </script>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Ngày sinh <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="addTchDob"  name="dob">
            </div>                                   
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Giới tính <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select id="addTchGender" name="gender" class="form-control">
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="3">Khác</option>
            </select>                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Địa chỉ </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchAddress" name="address">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Chuyên môn <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchExpert" name="expert">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Link youtube <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchYoutube" name="youtube">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">CV <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <textarea type="text" class="form-control" id="addTchCv" name="addTchCv"></textarea>                                    
        </div>
        <script>
                CKEDITOR.replace( 'addTchCv', {
                    defaultLanguage: 'vi',
                    extraPlugins : 'wordcount,notification',
                    wordcount : {
                        showParagraphs: false,
                        maxWordCount: 700,
                    },
                    filter: new CKEDITOR.htmlParser.filter({
                        elements: {
                            div: function( element ) {
                                console.log(element);
                                
                                if(element.attributes.class == 'mediaembed') {
                                    return false;
                                }
                            }
                        }
                    }),
                    toolbar : [
                        { name: 'basicstyles', items: ['Styles', 'Format', 'Bold', 'Italic'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                    ],
                    height: '5em',
                });
                var addTchCvEditor = CKEDITOR.instances.addTchCv;
        </script>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="addTchPassword" name="password">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="addTchCfPassword" name="confirm-password" >                                       
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="createTeacher">Thêm mới</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeCreateTeacher">Hủy bỏ</button>
    </div> 
</div>

<script src="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script>
$('#addTchDob').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy',
    endDate: new Date(),
    startDate: '01/01/1950',
    assumeNearbyYear: true
})
$(document).ready(function() {

    $("#btnSelectImage").click(function(){
        $('#addTchImgInput').click()
    })
    const image = document.getElementById('imageTch');
    const cropper = new Cropper(image, {
        viewMode: 1,
        aspectRatio: 1,
        autoCropArea: 1,
        scalable: true,
        zoomable: true,
        zoomOnTouch: false,
        cropBoxResizable: false,
        rotatable: true,
        dragMode: 'none',
        // modal: false,
    });

    $('#addTchImgInput').on('change', function(){
        file = $("#addTchImgInput").prop('files')[0]
        var fileType = file['type']
        var reader = new FileReader()
        
        var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png","image/JPG", "image/JPEG", "image/PNG"];
            
        if ($.inArray(fileType, ValidImageTypes) >= 0) {
            if (file['size'] == 0) {
                $('#selectFileButton').val("");
                Swal.fire({
                        type:'error',
                        text: 'Vui lòng chọn file ảnh!'
                    })
                return;
            }
        }else{
            Swal.fire({
                    type:'error',
                    text: 'Vui lòng chọn file ảnh!'
            })
            return;
        }

        reader.onloadend = function() {
            cropper.replace(reader.result)
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            $("#imageTch").attr('src', "")
        }
    })
        
    
    $('#createTeacher').click(function(){
        
        var name             = $("#addTchName").val().trim()
        var email            = $('#addTchEmail').val().trim()
        var phone            = $('#addTchPhone').val().trim()
        var dob              = $('#addTchDob').val().trim()
        var gender           = $('#addTchGender').val().trim()
        var address          = $('#addTchAddress').val().trim()
        var expert           = $('#addTchExpert').val().trim()
        var youtube          = $('#addTchYoutube').val().trim()
        var cv               = addTchCvEditor.getData()
        var password         = $('#addTchPassword').val()
        var confirmPassword  = $('#addTchCfPassword').val()
        

        if (youtube != undefined || youtube != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = youtube.match(regExp);
            if (match && match[2].length == 11) {
            }else{
                Swal.fire({
                    type: 'warning',
                    html: 'Link Video không hợp lệ!',
                })
                return false;
            }
        }
        
        var wordCount = addTchCvEditor.wordCount.wordCount
        if(wordCount < 30){
            return Swal.fire({
                type : 'warning',
                text : 'CV phải có ít nhất 30 từ',                
            })
        }

        var formData = new FormData
        if(cropper.getCroppedCanvas() != null){
            var avatar           = cropper.getCroppedCanvas().toDataURL()
            console.log($("#addTchImgInput").prop('files')[0])
             
            formData.append('avatar', avatar)
        }
        formData.append('name', name)
        formData.append('email', email)
        formData.append('phone', phone)
        formData.append('dob', dob)
        formData.append('gender', gender)
        formData.append('address', address)
        formData.append('expert', expert)
        formData.append('youtube', youtube)
        formData.append('cv', cv)
        formData.append('password', password)
        formData.append('confirm_password', confirmPassword)
        

        $.ajax({
            method: 'POST',
            url: "{{ url('/admincp/users/store-teacher') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: response => {
                if(response.status == 200){
                    Swal.fire({
                        type:'success',
                        text: response.message
                    })
                    dataTable.ajax.reload();
                    clearAddTeacherForm()                    
                }
                $("#add_user_modal").modal('hide')
            },
            error: error => {
                var obj_errors = error.responseJSON.errors;
                var txt_errors = '';
                for (k of Object.keys(obj_errors)) {
                    txt_errors += obj_errors[k][0] + '</br>';
                }
                Swal.fire({
                    type: 'warning',
                    html: txt_errors,
                    allowOutsideClick: false,
                })
            }
        })

    })

    function clearAddTeacherForm(){
        cropper.clear()
        $("#addTchName").val("")
        $('#addTchEmail').val("")
        $('#addTchPhone').val("")
        $('#addTchDob').val("")
        $('#addTchGender').val("")
        $('#addTchAddress').val("")
        $('#addTchExpert').val("")
        $('#addTchYoutube').val("")
        addTchCvEditor.setData("")
        $('#addTchPassword').val("")
        $('#addTchCfPassword').val("")
        cropper.destroy()
    }
})
</script>