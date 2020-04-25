<div class="tab-pane" id="tab_add_teacher">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Ảnh đại diện </label>
        <div class="col-sm-8 image-cropit-editor">
            <div>
                <img id="imageTch" style="height:0px;" src="">
                <input type="file" id="addTchImgInput" style="display:none;">
            </div>
            <div style="margin-top: 0.5em" class="form-html">
                <button id="btnSelectImage" class="btn btn-primary">Chọn ảnh</button>
                <div class="form-html-validate teacherImage"></div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Tên <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchName" name="name" autocomplete="addTchName">
            <div class="form-html-validate name"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchEmail" name="email" autocomplete="addTchEmail">
            <div class="form-html-validate email"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Số điện thoại <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchPhone" name="phone" autocomplete="addTchPhone">
            <div class="form-html-validate phone"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Ngày sinh <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="addTchDob"  name="dob" autocomplete="addTchDob">
            </div>
            <div class="form-html-validate dob"></div>
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
        <label  class="col-sm-3 col-form-label">Địa chỉ <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchAddress" name="address" autocomplete="addTchAddress">
            <div class="form-html-validate address"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Chuyên môn <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchExpert" name="expert" autocomplete="addTchExpert">
            <div class="form-html-validate expert"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Link youtube <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchYoutube" name="youtube" autocomplete="addTchYoutube">
            <div class="form-html-validate youtube"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Facebook </label>
        <div class="col-sm-8 form-html">
            <input type="text" class="form-control" id="addTchFacebook" name="facebook" autocomplete="addTchFacebook">
            <div class="form-html-validate facebook"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">CV <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <textarea type="text" class="form-control" id="addTchCv" name="addTchCv"></textarea>
            <div class="form-html-validate cv"></div>
        </div>
        <script>
                CKEDITOR.replace( 'addTchCv', {
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
                var addTchCvEditor = CKEDITOR.instances.addTchCv;
        </script>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="password" class="form-control" id="addTchPassword" name="password" autocomplete="off">
            <div class="form-html-validate password"></div>
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-3 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8 form-html">
            <input type="password" class="form-control" id="addTchCfPassword" name="confirm-password" autocomplete="addTchCfPassword">
            <div class="form-html-validate confirm_password"></div>
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
        var facebook         = $('#addTchFacebook').val().trim()
        var cv               = addTchCvEditor.getData()
        var password         = $('#addTchPassword').val()
        var confirmPassword  = $('#addTchCfPassword').val()
        
        var flag = true
        $('.form-html-validate').html('')
        if ( name == '' ){
            alertValidate('Bạn chưa nhập Tên.', 'name')
            flag = false
        }
        // if ( email == '' ){
        //     alertValidate('Bạn chưa nhập Email.', 'email')
        //     flag = false
        // }

        var email_number =/^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(email !==''){
            if (email_number.test(email) == false) 
            {
                alertValidate('Email sai định dạng!', 'email');
                flag = false
            }
        }else{
            alertValidate('Bạn chưa nhập Email.', 'email');
            flag = false
        }
        // if ( phone == '' ){
        //     alertValidate('Bạn chưa nhập Số điện thoại.', 'phone')
        //     flag = false
        // }
        var phone_number =/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/;
        if(phone !==''){
            if (phone_number.test(phone) == false) 
            {
                alertValidate('Số điện thoại của bạn không đúng định dạng!', 'phone');
                flag = false
            }if(10> phone.length || phone.length>11){
                alertValidate('Số điện thoại không tồn tại!', 'phone');
                flag = false
            }
        }else{
            alertValidate('Bạn chưa điền số điện thoại!', 'phone');
            flag = false
        }
        if ( dob == '' ){
            alertValidate('Bạn chưa chọn ngày sinh.', 'dob')
            flag = false
        }
        if ( address == '' ){
            alertValidate('Bạn chưa nhập địa chỉ.', 'address')
            flag = false
        }
        if ( expert == '' ){
            alertValidate('Bạn chưa nhập chuyên môn.', 'expert')
            flag = false
        }
        if ( youtube != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = youtube.match(regExp);
            if (match && match[2].length == 11) {
            }else{
                alertValidate('Link Youtube không hợp lệ.', 'youtube')
                flag = false
            }
        }else{
            alertValidate('Bạn chưa nhập Link Youtube.', 'youtube')
            flag = false
        }

        function validate_url(url){
            if (/^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i.test(url)){
                return true;
            }else{ return false }
        }
        if ( facebook != '' ){
            validate_url(facebook)
            if( !validate_url(facebook) ){
                alertValidate('Link Facebook không hợp lệ.', 'facebook')
                flag = false
            }
        }
        // else{
        //     alertValidate('Bạn chưa nhập Facebook.', 'facebook')
        //     flag = false
        // }
        
        var wordCount = addTchCvEditor.wordCount.wordCount
        if ( wordCount > 0 ){
            if(wordCount < 30){
                alertValidate('CV phải có ít nhất 30 từ.', 'cv')
                flag = false
            }
        }else{
            alertValidate('CV phải có ít nhất 30 từ.', 'cv')
            flag = false
        }

        if ( password == '' ){
            alertValidate('Bạn chưa nhập Mật khẩu.', 'password')
            flag = false
        }
        else{
            if(8> password.length){
                alertValidate('Mật khẩu cần có 8 ký tự trở lên.', 'password')
                flag = false
            }
            if(password.length>101){
                alertValidate('Mật khẩu cần có ít hơn 100 ký tự.', 'password')
                flag = false
            }
        }
        if ( confirmPassword == '' ){
            alertValidate('Vui lòng nhập lại mật khẩu.', 'confirm_password')
            flag = false
        }
        else{
            if(confirmPassword !== password){
                alertValidate('Mật khẩu chưa khớp.', 'confirm_password')
                flag = false
            }
        }
        if ( flag == false ) return

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
        formData.append('facebook', facebook)
        formData.append('cv', cv)
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
                $('.form-html-validate').css('display', 'block')
                $('.form-html-validate').html('')
                $.each(obj_errors, function( index, value ) {
                    var content = '<i class="fa fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                    $('.form-html-validate.' + index).html(content);
                })
            }
        })

    })
    $('#closeCreateTeacher').click(function(){
        clearAddTeacherForm()
    })

    function clearAddTeacherForm(){
        cropper.clear()
        $('#imageTch').attr('src','')
        $('#addTchImgInput').val('')
        $("#addTchName").val("")
        $('#addTchEmail').val("")
        $('#addTchPhone').val("")
        $('#addTchDob').val("")
        // $('#addTchGender').val("")
        $('#addTchAddress').val("")
        $('#addTchExpert').val("")
        $('#addTchYoutube').val("")
        $('#addTchFacebook').val("")
        addTchCvEditor.setData("")
        $('#addTchPassword').val("")
        $('#addTchCfPassword').val("")
        cropper.destroy()
        $('.cropper-container').hide()
    }
})
</script>