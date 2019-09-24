<div class="form-group row">
    <label  class="col-sm-4 col-form-label">Tên <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="hidden" id="userID_upd" value="">
        <input type="text" class="form-control" id="userName_upd" value="">
        <div id="nameErrorUpd" class="alert-errors d-none" role="alert">
          
        </div>
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="userEmail_upd" disabled>
        <div id="emailErrorUpd" class="alert-errors d-none" role="alert">
          
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label">Mật khẩu <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="userPassword_upd" name="password" value="">
        <div id="passwordErrorUpd" class="alert-errors d-none" role="alert">
          
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label">Nhập lại mật khẩu <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="passConfirm_upd" name="confirmpassword" value="">
        <div id="confirmpasswordErrorUpd" class="alert-errors d-none" role="alert">
          
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="userEmail_upd" class="col-sm-4 col-form-label">Vai trò <span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <select id="role-list-ins-edit" multiple="multiple">
            @foreach ($roles as $role)
                @if ($role->id != 2 && $role->id != 3)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endif
            @endforeach
        </select>
        <div class="alert-errors d-none" role="alert" id="role_idErrorIns"></div>
    </div>
</div>