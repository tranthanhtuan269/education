<div class="tab-pane" id="tab_add_teacher">
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Tên <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchName" name="name">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchEmail" name="email">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Sô điện thoại <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchPhone" name="phone">                                       
        </div>
        <script>
            
        </script>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Ngày sinh <span class="text-danger">*</span></label>
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
        <label  class="col-sm-4 col-form-label">Giới tính <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select id="addTchGender" name="gender" class="form-control">
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="3">Khác</option>
            </select>                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Địa chỉ <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchAddress" name="address">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Chuyên môn <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="addTchExpert" name="expert">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">CV <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <textarea type="text" class="form-control" id="addTchCv" name="addTchCv"></textarea>                                    
        </div>
        <script>
                CKEDITOR.replace( 'addTchCv', {
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
        <label  class="col-sm-4 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="addTchPassword" name="password">                                       
        </div>
    </div>
    <div class="form-group row">
        <label  class="col-sm-4 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="addTchCfPassword" name="confirm-password" >                                       
        </div>
    </div>
    <div>
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
    $('#createTeacher').click(function(){
        var  name = $("#addTchName").val()
        var email = $('#addTchEmail').val()
        var phone = $('#addTchPhone').val()
        var dob = $('#addTchDob').val()
        var gender = $('#addTchGender').val()
        var address = $('#addTchAddress').val()
        var expert = $('#addTchExpert').val()
        var cv = $('#addTchCv').val()
        var password = $('#addTchPassword').val()
        var confirmPassword = $('#addTchCfPassword').val()

        var formData = new FormData;
        formData.append('name', name)
        formData.append('email', email)
        formData.append('phone', phone)
        formData.append('dob', dob)
        formData.append('gender', gender)
        formData.append('address', address)
        formData.append('expert', expert)
        formData.append('cv', cv)
        formData.append('password', password)
        formData.append('confirm_password', confirmPassword)

        $.ajax({
            method: 'POST',
            url: "{{ url('/admincp/users/add-teacher') }}",
            data: formData,
            processData: false,
            contentType: false,
        })


        

    })
})
</script>