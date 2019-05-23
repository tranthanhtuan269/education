@extends('frontends.layouts.app') 
@section('content')
<div class="u-dashboard-top" style="background-image:  url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.menu')
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;&nbsp;Profile</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                                <div class="row">
                                    <form id="w0" action="/dashboard/user/profile" method="post" enctype="multipart/form-data">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group" style="margin-bottom: 47px;">
                                                <label style="margin-bottom: 10px;">Choose Image</label>
                                                <br>
                                                <link rel="stylesheet" href="https://learncodeweb.com/demo/web-development/drag-drop-images-with-bootstrap-4-and-reorder-using-php-jquery-and-ajax/dropzone/dropzone.css" type="text/css">
                                                <div class="dropzone dz-clickable" id="myDrop">
                                                    <div class="dz-default dz-message" data-dz-message="">
                                                        <span>Drop files here to upload</span>
                                                    </div>
                                                </div>
                                                {{-- <p style="margin-top:10px;">(Ảnh vuông và &lt;500KB)</p> --}}
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <div class="form-group field-muser-address">
                                                    <textarea class="form-control" rows="5" cols="50" name="address">{{ Auth::user()->name }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group" style="padding-top: 19px;">
                                                <button class="btn btn-success" id="save-profile" type="button"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Full name</label>
                                                <div class="form-group field-muser-fullname required">
                                                    <input type="text" id="muser-fullname" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><i title="Email chưa xác thực" class="fa fa-envelope color-red"></i> Email </label>
                                                <div class="form-group field-muser-email required">
                                                    <input type="email" id="muser-email" class="form-control" name="email" value="{{ Auth::user()->email }}" disabled>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <div class="form-group field-muser-phone required">
                                                    <input type="text" id="muser-phone" class="form-control" name="phone" value="{{ Auth::user()->phone }}">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Birthday</label>
                                                <div class="form-group field-selector_id">
                                                    <input type="text" class="form-control" name="birthday" value="{{ Auth::user()->birthday }}" placeholder="vd : 01/01/1990">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div class="form-group field-muser-gender required">
                                                    <select class="form-control" name="gender">
                                                        <option value="0">Female</option>
                                                        <option value="1" selected="">Male</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://learncodeweb.com/demo/web-development/drag-drop-images-with-bootstrap-4-and-reorder-using-php-jquery-and-ajax/dropzone/dropzone.js"></script>
<script>
    $(document).ready(function(){
        $('.reorder').on('click',function(){
            $("ul.nav").sortable({ tolerance: 'pointer' });
            $('.reorder').html('Save Reordering');
            $('.reorder').attr("id","updateReorder");
            $('#reorder-msg').slideDown('');
            $('.img-link').attr("href","javascript:;");
            $('.img-link').css("cursor","move");
        });
            

        //Dropzone script
        Dropzone.autoDiscover = false;
        var link_base64;
        var myDropzone = new Dropzone("div#myDrop", 
        { 
                paramName: "files", // The name that will be used to transfer the file
                addRemoveLinks: true,
                uploadMultiple: false,
                autoProcessQueue: true,
                parallelUploads: 50,
                maxFilesize: 5, // MB
                acceptedFiles: ".png, .jpeg, .jpg, .gif",
                url: "{{ url('upload-image-demo') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response){
                    // alert(response);
                },
                accept: function(file, done) {
                    // alert(2)
                    done();
                },
                error: function(file, msg){
                    // alert(msg);
                },
                sending: function(file, xhr, formData) {
                    // $.each($('form').serializeArray(), function(key,value) {
                    //     formData.append(this.name, this.value);
                    // });
                    // data_request = formData;
                    // alert(data);
                    // console.log(formData);

                },
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }

                    });

                },
                // error: function (file, response){
                //     alert(1);
                //     if ($.type(response) === "string")
                //         var message = response; //dropzone sends it's own error messages in string
                //     else
                //         var message = response.message;
                //     file.previewElement.classList.add("dz-error");
                //     _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                //     _results = [];
                //     for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                //         node = _ref[_i];
                //         _results.push(node.textContent = message);
                //     }
                //     return _results;
                // },

                // reset: function () {
                //     console.log("resetFiles");
                //     this.removeAllFiles(true);
                // }
        });

        $("#save-profile").click(function(){
            $.ajaxSetup(
            {
                headers:
                {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data = {
                    link_base64:link_base64,
                    name: $('input[name=name]').val().trim(),
                    phone: $('input[name=phone]').val().trim(),
                    birthday: $('input[name=birthday]').val().trim(),
                    gender: $('select[name=gender]').val(),
                    address: $('textarea[name=address]').val().trim(),
                };

            $.ajax({
                method: "POST",
                url: "{{ url('upload-image') }}",
                data: data,
                dataType: 'json',
                // beforeSend: function() {
                //     $("#pre_ajax_loading").show();
                // },
                // complete: function() {
                //     $("#pre_ajax_loading").hide();
                // },
                success: function (response) {
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            html: response.success,

                        });
                    }else{
                        Swal.fire({
                            type: 'error',
                            html: 'Error',
                        })
                    }
                },
                error: function (error) {
                    var obj_errors = error.responseJSON.errors;
                    // console.log(obj_errors)
                    var txt_errors = '';
                    for (k of Object.keys(obj_errors)) {
                        txt_errors += obj_errors[k][0] + '</br>';
                    }
                    Swal.fire({
                        type: 'error',
                        html: txt_errors,
                    })
                }
            });

            return;
        });  
                  
                      
        myDropzone.on("sending", function(file, xhr, formData) {
            var filenames = [];
            
            $('.dz-preview .dz-filename').each(function() {
                filenames.push($(this).find('span').text());
            });
            
            formData.append('filenames', filenames);
        });
            
        /* Add Files Script*/
        myDropzone.on("success", function(file, message){
            $("#msg").html(message);
            //setTimeout(function(){window.location.href="index.php"},200);
        });
            
        myDropzone.on("error", function (data) {
            $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
        });
            
        myDropzone.on("complete", function(file) {
            //myDropzone.removeFile(file);
        });
            
        myDropzone.on('thumbnail', function(file, dataUri) {
            link_base64 = dataUri;
        });
            
    });
</script>
@endsection