    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Ảnh đại diện <span class="text-danger">*</span></label>
        <div class="col-sm-8 image-cropit-editor">
            <div>
                <img id="imageStu" style="height:150px;" src="">
                <input type="file" id="addStuImgInput" style="display:none;">
            </div>
            <div style="margin-top: 0.5em">
                <button id="btnSelectAddStuImage" class="btn btn-primary">Chọn ảnh</button>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Tên <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addStuName" name="name">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addStuEmail" name="email">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Sô điện thoại <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addStuPhone" name="phone">                                       
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
                <input type="text" class="form-control pull-right" id="addStuDob"  name="dob">
            </div>                                   
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Giới tính <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select id="addStuGender" name="gender" class="form-control">
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="3">Khác</option>
            </select>                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Địa chỉ <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addStuAddress" name="address">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="addStuPassword" name="password">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="addStuCfPassword" name="confirm-password" >                                       
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="createStudent">Thêm mới</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeCreateTeacher">Hủy bỏ</button>
    </div> 

<script src="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script>
$('#addStuDob').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy',
    endDate: new Date(),
    startDate: '01/01/1950',
    assumeNearbyYear: true
})
$(document).ready(function() {

    $("#btnSelectAddStuImage").click(function(){
        $('#addStuImgInput').click()
    })
    const imageAddStu = document.getElementById('imageStu');
    const cropperAddStu = new Cropper(imageAddStu, {
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

    $('#addStuImgInput').on('change', function(){
        file = $("#addStuImgInput").prop('files')[0]
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
            cropperAddStu.replace(reader.result)
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            $("#imageStu").attr('src', "")
        }
    })
        
    
    $('#createStudent').click(function(){
        
        var name             = $("#addStuName").val().trim()
        var email            = $('#addStuEmail').val().trim()
        var phone            = $('#addStuPhone').val().trim()
        var dob              = $('#addStuDob').val().trim()
        var gender           = $('#addStuGender').val().trim()
        var address          = $('#addStuAddress').val().trim()
        var password         = $('#addStuPassword').val()
        var confirmPassword  = $('#addStuCfPassword').val()
        
        var formData = new FormData
        if(cropperAddStu.getCroppedCanvas() != null){
            var avatar           = cropperAddStu.getCroppedCanvas().toDataURL()
        //     console.log($("#addStuImgInput").prop('files')[0])
             
            formData.append('avatar', avatar)
        }
        formData.append('name', name)
        formData.append('email', email)
        formData.append('phone', phone)
        formData.append('dob', dob)
        formData.append('gender', gender)
        formData.append('address', address)
        formData.append('password', password)
        formData.append('confirm_password', confirmPassword)
        $.ajaxSetup(
            {
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({
            method: 'POST',
            url: "{{ url('/admincp/users/store-student') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: response => {
                if(response.status == 200){
                    Swal.fire({
                        type:'success',
                        text: response.message
                    })
                    clearAddStudentForm()
                    dataTable.ajax.reload();                    
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

    function clearAddStudentForm(){
        cropperAddStu.clear()
        $("#addStuName").val("")
        $('#addStuEmail').val("")
        $('#addStuPhone').val("")
        $('#addStuDob').val("")
        $('#addStuGender').val("")
        $('#addStuAddress').val("")
        $('#addStuPassword').val("")
        $('#addStuCfPassword').val("")
        cropperAddStu.destroy()

    }
})
</script>