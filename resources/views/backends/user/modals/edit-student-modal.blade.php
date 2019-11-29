<div class="form-group row">
        <label class="col-sm-3 col-form-label">Ảnh đại diện <span class="text-danger">*</span></label>
        <div class="col-sm-8 image-cropit-editor">
            <div>
                <img id="imageEditStu" style="height:200px;" src="">
                <input type="file" id="editStuImgInput" style="display:none;">
            </div>
            <div style="margin-top: 0.5em">
                <button id="btnSelectEditStuImage" class="btn btn-primary">Chọn ảnh</button>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Tên <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="editStuName" name="name">                                       
            <div class="form-html-validate name"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" disabled class="form-control" id="editStuEmail" name="email">                                       
            <div class="form-html-validate email"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Sô điện thoại <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="editStuPhone" name="phone">                                       
            <div class="form-html-validate phone"></div>
        </div>
        <script>
            
        </script>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Ngày sinh <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="editStuDob"  name="dob">
            </div>                                   
            <div class="form-html-validate dob"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Giới tính <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select id="editStuGender" name="gender" class="form-control">
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="3">Khác</option>
            </select>                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Địa chỉ <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="editStuAddress" name="address">                                       
            <div class="form-html-validate address"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Mật khẩu </label>
        <div class="col-sm-8 form-html">
            <input type="password" class="form-control" id="editStuPassword" name="password">                                       
            <div class="form-html-validate password"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Nhập lại mật khẩu </label>
        <div class="col-sm-8 form-html">
            <input type="password" class="form-control" id="editStuCfPassword" name="confirm-password" >                                       
            <div class="form-html-validate confirm_password"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editStudent">Lưu học viên</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeEditStudent">Hủy bỏ</button>
    </div> 

<script src="{{asset('backend/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script>
$('#editStuDob').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy',
    endDate: new Date(),
    startDate: '01/01/1950',
    assumeNearbyYear: true
})
$(document).ready(function() {

    $("#btnSelectEditStuImage").click(function(){
        $('#editStuImgInput').click()
    })
    

    $('#editStuImgInput').on('change', function(){
        file = $("#editStuImgInput").prop('files')[0]
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
            cropperEditStu.replace(reader.result)
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            $("#imageEditStu").attr('src', "")
        }
    })
        
    
    $('#editStudent').click(function(){
        var user_id          = $(this).attr('data-user-id')
        var name             = $("#editStuName").val().trim()
        var email            = $('#editStuEmail').val().trim()
        var phone            = $('#editStuPhone').val().trim()
        var dob              = $('#editStuDob').val().trim()
        var gender           = $('#editStuGender').val().trim()
        var address          = $('#editStuAddress').val().trim()
        var password         = $('#editStuPassword').val()
        var confirmPassword  = $('#editStuCfPassword').val()
        
        var formData = new FormData
        if(cropperEditStu.getCroppedCanvas() != null){
            var avatar           = cropperEditStu.getCroppedCanvas().toDataURL()
        //     console.log($("#editStuImgInput").prop('files')[0])
             
            formData.append('avatar', avatar)
        }
        formData.append('user_id', user_id)
        formData.append('name', name)
        formData.append('email', email)
        formData.append('phone', phone)
        formData.append('dob', dob)
        formData.append('gender', gender)
        formData.append('address', address)
        formData.append('_method', 'PUT')
        if(password != ''){
            formData.append('password', password)
            formData.append('confirm_password', confirmPassword)
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
            url: "{{ url('/admincp/users/update-student') }}",
            data: formData,
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
                    clearEditStudentForm()      
                    $('#edit_user_modal').modal('hide')
                }
                $("#add_user_modal").modal('hide')
            },
            error: error => {
                var obj_errors = error.responseJSON.errors;
                $('.form-html-validate').css('display', 'block')
                $('.form-html-validate').html('')
                $.each(obj_errors, function( index, value ) {
                    var content = '<i class="fa fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                    $('.form-html-validate.' + index).html(content);
                })
                $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
            }
        })

    })

    $('#closeEditStudent').click(function(){
        clearEditStudentForm()
    })

    function clearEditStudentForm(){
        cropperEditStu.clear()
        $("#editStuName").val("")
        $('#editStuEmail').val("")
        $('#editStuPhone').val("")
        $('#editStuDob').val("")
        $('#editStuGender').val("")
        $('#editStuAddress').val("")
        $('#editStuPassword').val("")
        $('#editStuCfPassword').val("")
        cropperEditStu.destroy()

    }
})
</script>