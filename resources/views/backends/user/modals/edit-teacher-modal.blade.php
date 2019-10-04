<div class="form-group row">
    <label class="col-sm-3 col-form-label">Ảnh đại diện <span class="text-danger">*</span></label>
    <div class="col-sm-8 image-cropit-editor">
        <div>
            <img id="imageEditTch" style="height:200px;" src="">
            <input type="file" id="editTchImgInput" style="display:none;">
        </div>
        <div style="margin-top: 0.5em">
            <button id="btnSelectImageEdit" class="btn btn-primary">Chọn ảnh</button>
        </div>
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Tên <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="editTchName" name="name">                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input disabled type="text" class="form-control" id="editTchEmail" name="email">                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Sô điện thoại <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="editTchPhone" name="phone">                                       
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
            <input type="text" class="form-control pull-right" id="editTchDob"  name="dob">
        </div>                                   
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Giới tính <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <select id="editTchGender" name="gender" class="form-control">
                <option value="1">Nam</option>
                <option value="2">Nữ</option>
                <option value="3">Khác</option>
        </select>                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Địa chỉ <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="editTchAddress" name="address">                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Chuyên môn <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="editTchExpert" name="expert">                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Link youtube <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="editTchYoutube" name="youtube">                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">CV <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <textarea type="text" class="form-control" id="editTchCv" name="editTchCv"></textarea>                                    
    </div>
    <script>
            CKEDITOR.replace( 'editTchCv', {
                defaultLanguage: 'vi',
                extraPlugins : 'wordcount,notification',
                wordcount : {
                    showParagraphs: false,
                    maxWordCount: 700,
                },
                toolbar : [
                    { name: 'basicstyles', items: ['Styles', 'Format', 'Bold', 'Italic'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                ],
            });
            var editTchCvEditor = CKEDITOR.instances.editTchCv;
    </script>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Mật khẩu </label>
    <div class="col-sm-8">
        <input type="password" class="form-control" id="editTchPassword" name="password">                                       
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">Nhập lại mật khẩu </label>
    <div class="col-sm-8">
        <input type="password" class="form-control" id="editTchCfPassword" name="confirm-password" >                                       
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="saveEditTeacher">Lưu giảng viên</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeEditTeacher">Hủy bỏ</button>
</div> 

<script>

$(document).ready(function(){
    

    $('#editTchDob').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        endDate: new Date(),
        startDate: '01/01/1950',
        assumeNearbyYear: true
    })

    $("#btnSelectImageEdit").click(function(){
        $("#editTchImgInput").click()
    })

    $('#editTchImgInput').on('change', function(){
        file = $("#editTchImgInput").prop('files')[0]
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
            cropperEdit.reset()
            cropperEdit.replace(reader.result)
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            $("#imageTchEdit").attr('src', "")
        }
    })

    $("#saveEditTeacher").click(function(e){
        e.preventDefault()
        e.stopPropagation()
        var user_id          = $(this).attr('data-user-id')
        var name             = $("#editTchName").val().trim()
        // var email            = $('#editTchEmail').val().trim()
        var phone            = $('#editTchPhone').val().trim()
        var dob              = $('#editTchDob').val().trim()
        var gender           = $('#editTchGender').val().trim()
        var address          = $('#editTchAddress').val().trim()
        var expert           = $('#editTchExpert').val().trim()
        var youtube          = $('#editTchYoutube').val().trim()
        var cv               = editTchCvEditor.getData()
        var password         = $('#editTchPassword').val()
        var confirmPassword  = $('#editTchCfPassword').val()

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
        
        var wordCount = editTchCvEditor.wordCount.wordCount
        if(wordCount < 30){
            return Swal.fire({
                type : 'warning',
                text : 'CV phải có ít nhất 30 từ',                
            })
        }

        var editFormData = new FormData
        if(cropperEdit.getCroppedCanvas() != null){
            var avatar           = cropperEdit.getCroppedCanvas().toDataURL()
            console.log($("#editTchImgInput").prop('files')[0])
            
            // editFormData.append('ava_last_modified', 1552883815528);
            editFormData.append('avatar', avatar)
        }

        editFormData.append('_method', 'PUT')
        editFormData.append('user_id', user_id)
        editFormData.append('name', name)
        // editFormData.append('email', email)
        editFormData.append('phone', phone)
        editFormData.append('dob', dob)
        editFormData.append('gender', gender)
        editFormData.append('address', address)
        editFormData.append('expert', expert)
        editFormData.append('youtube', youtube)
        editFormData.append('cv', cv)
        if(password != ""){
            editFormData.append('password', password)
            editFormData.append('confirm_password', confirmPassword)
        }

        $.ajaxSetup(
            {
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({
            method: 'POST',
            url: `{{ url('/admincp/') }}/users/update-teacher`,
            data: editFormData,
            processData: false,
            contentType: false,
            success: response => {
                if(response.status == 200){
                    Swal.fire({
                        type:'success',
                        text: response.message
                    }).then( result => {
                        location.reload()
                    })                 
                    $("#editTchImgInput").val("")
                    $("#editTchPassword").val("")
                    $("#editTchCfPassword").val("")
                    cropperEdit.destroy()
                    $("#edit_user_modal").modal('hide')
                }
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

    $('#closeEditTeacher').click(function(){
        $('#editTchPassword').val("")
        $('#editTchCfPassword').val("")
    })
    
})
</script>

{{-- <script src="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script> --}}