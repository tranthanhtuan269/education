@extends('frontends.layouts.app')
@section('content')
<!-- Include the plugin's CSS and JS: -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-multiselect.css') }}" type="text/css">
<script type="text/javascript" src="{{ asset('frontend/js/bootstrap-multiselect.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ url('/') }}/frontend/js/jquery.cropit.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>

<div class="u-dashboard-top" style="background-image: url({{ url('frontend/images/bg-db-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('frontends.users.teacher.menu')
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="box-course-hold tabbable-panel">
                {{-- <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#buyed" class="buyed" data-toggle="tab"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Khóa học</a>
                        </li>
                    </ul> --}}
                    <div class="tab-content">
                        <div class="tab-pane active" id="buyed">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <form action="" method="get">
                                        <div class="form-inline box-search-course">
                                            <div class="form-group box-input">
                                                <input type="text" class="form-control" name="u-keyword" placeholder="Tìm kiếm khoá học..." value="{{ Request::get('u-keyword') }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-2">
                                    <div class=""><button class="btn btn-primary" id="create-course-btn"><i class="fas fa-book fa-fw"></i>Tạo khóa học</button></div>
                                </div>
                            </div>
                            <div class="row">
                                @if (count($lifelong_course) > 0)
                                    @foreach ($lifelong_course as $course)
                                    @include(
                                        'components.admin-course',
                                        [
                                            'course' => $course
                                        ]
                                    )
                                    @endforeach
                                    <div class="col-xs-12 text-center">
                                        <div class="u-number-page">{{ $lifelong_course->links() }}</div>
                                    </div>
                                @else
                                    <div class="col-xs-12">
                                        <p class="result-search-u-keyword">
                                            @if (Request::get('u-keyword'))
                                                Không có kết quả tìm kiếm
                                            @else
                                                Bạn chưa tạo khoá học nào!
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <div class="u-number-page">{{ $lifelong_course->links() }}</div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        {{-- <div class="tab-pane" id="membership">
                            <p>Chưa kích hoạt khóa học với thẻ membership</p>
                        </div> --}}
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>

<div id="createCourse" class="box-course modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="exampleModalLabel">Tạo khóa học mới</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="image-cropit-editor">
                        <div class="box-course-preview" id="image-cropper">
                            <div class="cropit-preview text-center preview-image-course" id="cropitPreview" style="display: none">
                            </div>
                            <input type="range" class="cropit-image-zoom-input" id="cropit-zoom-input" style="display: none"/>
                            <input type="file" class="cropit-image-input" style="display:none" value="" id="image-file-input"/>
                            <div class="text-center form-html">
                                <div class="note">(Kích thước nhỏ nhất: 640x360)</div>
                                <div class="btn btn-primary select-image-btn" id="btn-cropit-upload"><i class="fas fa-image fa-fw"></i> Tải lên ảnh khóa học</div>
                                <div class="form-html-validate image"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="row" autocomplete="off" id="formCreateCourse">
                    <div class="col-md-8">
                        {!! \App\Helper\Helper::insertInputForm('text', 'name', 'Tên khóa học:', '', 'name', 'id="course-name"') !!}
                        {!! \App\Helper\Helper::insertInputForm('text', 'short-description', 'Tóm tắt:', '', 'short_description', 'id="short-description"') !!}
                        <div class="form-group form-html">
                            <label for="description" class="control-label">Mô tả:</label>
                            <div class="form-group">
                                <textarea id="course-description" class="form-control" rows="6" cols="50" name="description-course"></textarea>
                            </div>
                            <script>
                                    CKEDITOR.replace( 'description-course',{
                                        height: '300px',
                                    } )
                            </script>
                            <div class="form-html-validate description"></div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="requirement" class="control-label">Yêu cầu:</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="course-requirement" name="requirement" placeholder="Ví dụ 1, ví dụ 2, ví dụ 3">
                                <div class="alert-validate requirement"></div>
                            </div>
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'requirement', 'Yêu cầu:', '', 'requirement', 'id="course-requirement" placeholder="Ví dụ 1, ví dụ 2, ví dụ 3"') !!}
                        {!! \App\Helper\Helper::insertInputForm('text', 'course-intro', 'Video giới thiệu:', '', 'link_intro', 'id="course-intro" placeholder="Link Youtube"') !!}
                        {{-- <div class="form-group">
                            <label for="link_video" class="control-label">Video giới thiệu:</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="course-intro" name="course-intro" value="" placeholder="Link Youtube">
                                <div class="alert-validate link_intro"></div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-4">
                        {{-- <div class="form-group">
                            <label for="price" class="control-label">Giá gốc khóa học: (₫)</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="courseOriginalPrice" name="price" onpaste="return false">
                                <div class="alert-validate original_price"></div>
                            </div>
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('text', 'price', 'Giá gốc khóa học: (₫)', '', 'original_price', 'id="courseOriginalPrice" onpaste="return false"') !!}
                        {!! \App\Helper\Helper::insertInputForm('text', 'price', 'Giá sau khi giảm: (₫)', '', 'discount_price', 'id="courseDiscountPrice" onpaste="return false"') !!}
                        {{-- <div class="form-group">
                            <label for="price" class="control-label">Giá sau khi giảm: (₫)</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="courseDiscountPrice" name="price" onpaste="return false">
                                <div class="alert-validate discount_price"></div>
                            </div>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="approx_time" class="control-label">Thời gian dự kiến hoàn thành: (giờ)</label>
                            <div class="position-relative">
                                <input type="number" class="form-control" id="course-approx-time" name="approx-time" min="0" onpaste="return false">
                                <div class="alert-validate approx_time"></div>
                            </div>
                        </div> --}}
                        {!! \App\Helper\Helper::insertInputForm('number', 'approx-time', 'Thời gian dự kiến hoàn thành: (giờ)', '', 'approx_time', 'id="course-approx-time" min="0" onpaste="return false"') !!}
                        <div class="form-group">
                            <label for="category" class="control-label">Danh mục:</label>
                            <select class="form-control" id="course-category" name="category">
                                @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->children as $child)
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-html">
                            <label for="will-learn" class="control-label">Học viên sẽ học được:</label>
                            <div class="form-group will-learn-class">
                                <textarea id="course-will-learn" class="form-control" rows="6" cols="50" style="height:243px" name="will-learn"></textarea>
                            </div>
                            <script>
                                CKEDITOR.replace( 'will-learn', {
                                    toolbar : [
                                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'NumberedList', 'BulletedList'] },
                                    ],
                                    height: '299px',
                                });
                            </script>
                            <div class="form-html-validate will_learn"></div>
                        </div>
                    </div>
                    <input id="resetForm" type="reset" value="Reset the form" style="display:none">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="clearModal">Hủy</button>
                <button type="button" class="btn btn-primary" id="save-btn">Tạo</button>
            </div>
            {{-- <script>
                $('#clearModal').click(function() {
                    $('#resetForm').click()
                    CKEDITOR.instances['course-description'].setData("")
                    CKEDITOR.instances['course-will-learn'].setData("")
                    $('#cropitPreview').css('display', 'none')
                    $('#cropit-zoom-input').css('display', 'none')
                });
            </script> --}}
        </div>
    </div>
</div>

<div id="listVideo" class="modal fade list-video">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="btn btn-primary pull-right btn-add-video" id="addVideoBtn" ><i class="fas fa-plus fa-fw"></i>Thêm bài giảng</div>
                <h3 class="modal-title">Danh sách bài giảng</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul id="videoSortable" class="video-holder" data-unit-id="0">

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-popup-lecture" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div id="addVideoModal" class="modal fade add-video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm bài giảng</h3>
            </div>
            <div class="modal-body">
                <div class="form-group row form-html">
                    <label class="col-sm-3" for="name">Tên bài giảng:</label>
                    <input class="col-sm-9 form-control add-video-name" type="text" >
                    <div class="form-html-validate name"></div>
                </div>
                <div class="form-group row form-html">
                    <label class="col-sm-3" for="name">Mô tả:</label>
                    <textarea class="col-sm-9 form-control add-video-description" rows="5"></textarea>
                    <div class="form-html-validate description"></div>
                </div>
                <div class="form-group row">
                    <label for="file" class="col-sm-3">Tài liệu:</label>
                    <div class="btn-upload clearfix">
                        <span class="file-wrapper">
                            <input type="file"  id="addVideoDocument" name="document-upload" class="form-control" multiple style="display:none;">
                            <span class="button text-uppercase" id="btnAddVideoDocument" >Thêm tài liệu</span>
                        </span>
                    </div>
                    <div class="document-field col-sm-12">
                        {{-- <div>
                            <span class="pull-left">document.doc</span>
                            <span class="pull-right"><button class="btn btn-danger">Xoá</button></span>
                        </div> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="clearfix form-html">
                        <label class="col-sm-3" for="name">Video bài giảng:</label>
                        <div class="btn-upload clearfix">
                            <span class="file-wrapper">
                              <input type="file" name="file-mp4-upload-off" id="file-mp4-upload-off">
                              <span class="button text-uppercase upload-new-video">Tải lên</span>
                              <span class="button text-lowercase uploading-new-video" style="display: none;">Đang tải lên</span>
                            </span>
                        </div>
                        <div class="form-html-validate link_video"></div>
                    </div>
                    {{-- <input type="file" name="file-mp4-upload-off" id="file-mp4-upload-off"> --}}
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            <span class="sr-only">Hoàn thành 0%</span>
                        </div>
                    </div>
                    <video class="video_player hidden" controls="controls" src="" style="max-width:100%">
                        Your browser does not support the HTML5 Video element.
                    </video>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary save-add-video">Lưu</button>
                <button type="button" class="btn btn-default cancel-add-video" data-dismiss="modal" id="batv">Đóng</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="fileName" name="fileName" value="">
<input type="hidden" id="duration" value="">

<div id="editVideoModal" class="modal fade edit-video-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Chỉnh sửa bài giảng <span id="lecture-name"></span></h3>
            </div>
            <div class="modal-body">
                <div class="form-group row form-html">
                    <label class="col-sm-3" for="name">Tên:</label>
                    <input class="col-sm-9 form-control edit-video-name" type="text">
                    <div class="form-html-validate name"></div>
                </div>
                <div class="form-group row form-html">
                    <label class="col-sm-3" for="name">Mô tả:</label>
                    <textarea class="col-sm-9 form-control edit-video-description" rows="5"></textarea>
                    <div class="form-html-validate description"></div>
                </div>
                <div class="form-group row">
                    <label for="file" class="col-sm-3">Tài liệu:</label>
                    <div class="btn-upload clearfix">
                        <span class="file-wrapper">
                            <input type="file"  id="editVideoDocument" name="document-upload" class="form-control" multiple style="">
                            <span class="button text-uppercase" id="btnEditVideoDocument" >Thêm tài liệu</span>
                        </span>
                    </div>
                    <div class="edit-document-field col-sm-12">
                        {{-- <div>
                            <span class="pull-left">document.doc</span>
                            <span class="pull-right"><button class="btn btn-danger">Xoá</button></span>
                        </div> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="clearfix">
                        <label class="col-sm-3" for="name">Video bài giảng:</label>
                        <div class="btn-upload clearfix">
                            <span class="file-wrapper">
                              <input type="file" name="file-mp4-upload-off" id="file-mp4-upload-off-updated">
                              <span class="button text-uppercase upload-old-video">Tải lên</span>
                              <span class="button text-lowercase uploading-old-video" style="display: none;">Đang tải lên</span>
                            </span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            <span class="sr-only">Hoàn thành 0%</span>
                        </div>
                    </div>
                    <video id="videoInEdit" controls="controls" src="" style="max-width:100%">
                        Your browser does not support the HTML5 Video element.
                    </video>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary save-edit-video request-edit-video">Lưu</button>
                <button type="button" class="btn btn-default cancel-edit-video" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    let filesEditLength = 0;
    var S = jQuery.noConflict();
    var uploading = false;
    $(document).ready(function(){
        document.getElementById('course-approx-time').onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || (e.keyCode == 8)
            || e.keyCode == 190)) {
                return false;
            }
        }
        document.getElementById('courseOriginalPrice').onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8)) {
                return false;
            }
        }
        document.getElementById('courseDiscountPrice').onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8)) {
                return false;
            }
        }

        $('#create-course-btn').click(function(){
            $('#createCourse').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#resetForm').click()
            CKEDITOR.instances['course-description'].setData("")
            CKEDITOR.instances['course-will-learn'].setData("")
            $('#cropitPreview').css('display', 'none')
            $('#cropit-zoom-input').css('display', 'none')

            $('.form-html-validate').css('display', 'none')
        })

        $('.upload-new-video').click(function(){
            $('#file-mp4-upload-off').click();
        })

        $('.upload-old-video').click(function(){
            $('#file-mp4-upload-off-updated').click();
        })

        $('body').on('click','#createCourse .dz-image-preview',function(){
            $("#myDrop0").trigger("click")
        })

        $('#addVideoModal').on('hidden.bs.modal', function () {
            for(var i = 0; i < $('.video_player').length; i++){
               $('.video_player')[i].pause();
            }
            $('#listVideo').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $('#editVideoModal').on('hidden.bs.modal', function () {
            $('#listVideo').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.form-html-validate').css('display', 'none')
        });

        $("#btnEditVideoDocument").click(function(){
            $('#editVideoDocument').click()
        })
        //DUONG NT UPLOAD DOCUMENT
        $("#btnAddVideoDocument").click(function(){
            $('#addVideoDocument').click()
        })
        var inputFile = $('#addVideoDocument')
        let files = [];
        var fileNameList = "; "
        inputFile.change(function(){
            for(let index = 0; index < inputFile[0].files.length; index++) {
                let file = inputFile[0].files[index];
                if(fileNameList.indexOf("; " + file.name + "; ") >= 0){

                }else{
                    // console.log(fileNameList);
                    fileNameList += file.name + "; "
                    // console.log(fileNameList);
                    files.push(file);

                    var filesLength = files.length

                    var html = ''
                    html += `<div class="row" data-index="${filesLength - 1}">`
                        html += `<span class="pull-left">${file.name}</span>`
                        html += `<span class="pull-right btn-delete-document "><button data-index="${filesLength - 1}" class="btn btn-danger" id="btnDeleteDocument">Xoá</button></span>`
                    html += `</div>`

                    $('.document-field').append(html)
                }
            }
            $('#addVideoDocument').val("");
        })
        //End DuongNT upload

        $(document).on('click', '#btnDeleteDocument', function(){
            var indexToRemove = $(this).attr("data-index")
            console.log(fileNameList);
            if(files[indexToRemove] != undefined){
                fileNameList = fileNameList.replace("; " + files[indexToRemove].name, "");
            }
            files.splice(indexToRemove,1)
            $(this).parent().parent().remove()

            //re-index
            $.each($('.document-field .row'), function(index, value){
                console.log($(value));
                $(value).attr('data-index', index)
                $(value).children('span.btn-delete-document').children('button').attr('data-index', index)
            })


            $('#addVideoDocument').val("");
        })

        //DuongNT - Edit Video Document
        var editInputFile = $("#editVideoDocument")
        let editFiles = []
        var fileNameListEdit = "; "
        editInputFile.change(function(){
            // const initialEditFilesLength = $('.edit-document-field .row').length
            for(let index = 0; index < editInputFile[0].files.length; index++) {
                let file = editInputFile[0].files[index];
                if(fileNameListEdit.indexOf("; " + file.name + "; ") >= 0){

                }else{
                    // console.log(fileNameListEdit);
                    fileNameListEdit += file.name + "; "
                    // console.log(fileNameListEdit);
                    editFiles.push(file);

                    // var filesLength = editFiles.length + initialEditFilesLength
                    var filesLength = editFiles.length

                    var html = ''
                    html += `<div class="row" data-index="${filesLength - 1}">`
                        html += `<span class="pull-left">${file.name}</span>`
                        html += `<span class="pull-right btn-delete-edit-document "><button data-index="${filesLength - 1}" data-active="false" data-file-id="${file.id}" class="btn btn-danger" id="btnDeleteDocumentInEdit">Xoá</button></span>`
                    html += `</div>`

                    $('.edit-document-field').append(html)
                }
            }
            $('#editVideoDocument').val("");
        })

        var activeFileToDelete = []
        $(document).on('click', '#btnDeleteDocumentInEdit', function(){
            Swal.fire({
                type: 'warning',
                text: 'Bạn có muốn xoá tài liệu này không?',
                showCancelButton: true,
                cancelButtonText: 'Huỷ'
            }).then( (result) => {
                if(result.value){
                    var indexToRemove = $(this).attr("data-index")
                    var name = $(this).parent().parent().find('.pull-left').text()
                    console.log(name)
                    var fileId = $(this).attr('data-file-id')
                    var isActive = $(this).attr('data-active') //kiểm tra tài liệu có trong database hay không
                    // console.log(fileNameListEdit);
                    if(editFiles[indexToRemove] != undefined){
                        fileNameListEdit = fileNameListEdit.replace("; " + 
                            editFiles[indexToRemove].name, "");
                    }else{
                        fileNameListEdit = fileNameListEdit.replace("; " + 
                            name, "");

                    }
                    editFiles.splice(indexToRemove,1)
                    // console.log(fileNameListEdit);

                    $(this).parent().parent().remove()
                    if (isActive) {
                        activeFileToDelete.push(fileId)
                    }
                    //re-index
                    $.each($('.edit-document-field .row'), function(index, value){
                        $(value).attr('data-index', index)
                        $(value).children('span.btn-delete-edit-document').children('button').attr('data-index', index)
                    })
                    $('#editVideoDocument').val("");
                }
            })



        })

        $('#listVideo').on('shown.bs.modal', function () {
            var unit_id = $(this).attr('data-unit-id');
            $('#addVideoBtn').attr('data-unit-id', unit_id);
            getListVideoAjax(unit_id)
        })

        function getListVideoAjax(unit_id){
            $.ajax({
                method: 'GET',
                url: "{{ url('/') }}/user/units/"+unit_id+"/get-video",
                dataType: 'json',
                success: function (response) {
                    if(response.status == '200'){
                        var html = "";

                        for(var i = 0; i < response.videos.length; i++){                        
                            switch(response.videos[i].state){
                                case 0: // Pending
                                    html += '<li style="display:flex" class="ui-state-default ui-sortable-handle"  data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'">'
                                    html += '<i class="fas fa-sort"></i> '
                                    html += '<span class="video-content">'+response.videos[i].name+'</span><span class="verifing-request"> (Chờ duyệt)</span>'
                                    // html += '<i class="far fa-edit pull-right edit-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'"></i>'
                                    html += '<i class="far fa-trash-alt pull-right remove-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'" title="Xóa bài giảng"></i>'
                                    break;
                                case 1: // Approved
                                    html += '<li class="ui-state-default ui-sortable-handle"  data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'">'
                                    html += '<i class="fas fa-sort"></i> '
                                    html += '<span class="video-content">'+response.videos[i].name+'</span>'
                                    html += '<i class="far fa-trash-alt pull-right remove-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'" title="Xóa bài giảng"></i>'
                                    html += '<i class="far fa-edit pull-right edit-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'" title="Sửa bài giảng"></i>'
                                    break;
                                case 2: // Waiting to delete
                                    html += '<li style="display:flex" class="ui-state-default ui-sortable-handle"  data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'">'
                                    html += '<i class="fas fa-sort"></i> '
                                    html += '<span class="video-content">'+response.videos[i].name+'</span><span class="remove-request"> (Đã gửi yêu cầu xoá)</span>'
                                    break;
                                case 3: // Converting
                                    html += '<li style="display:flex" class="ui-state-default ui-sortable-handle"  data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'">'
                                    html += '<i class="fas fa-sort"></i> '
                                    html += '<span class="video-content">'+response.videos[i].name+'</span><span class="converting-request"> (Đang được convert)</span>'
                                    break;
                                case 4: // Request Edit
                                    html += '<li style="display:flex" class="ui-state-default ui-sortable-handle"  data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'">'
                                    html += '<i class="fas fa-sort"></i> '
                                    html += '<span class="video-content">'+response.videos[i].name+'</span><span class="edit-request"> (Đã gửi yêu cầu sửa)</span>'
                                    html += '<i class="far fa-edit pull-right edit-video" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'" title="Sửa bài giảng"></i>'
                                    html += '<i class="fas fa-eraser pull-right edit-video remove-request-update" data-video-id="'+response.videos[i].id+'" data-unit-id="'+unit_id+'" data-video-index="'+response.videos[i].index+'" title="Hủy yêu cầu sửa"></i>'
                                    break;
                                    
                            }
                            html += '</li>'
                        }
                        $('#videoSortable').html(html);

                        addEventAndSort();
                    }
                },
                error: function (error) {
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
        }

        $('#listVideo').on('hide.bs.modal', function () {
            $('#videoSortable').html("");
            var unit_id = $(this).attr('data-unit-id');
        });

        $('.close-popup-lecture').click(function(){
			$('.active-modal').modal({
                backdrop: 'static',
                keyboard: false
            });;
        })

        $('#addVideoBtn').on('click', function () {
            $('.form-html-validate').html('')
            // $('#listVideo').modal({
            //     backdrop: 'static',
            //     keyboard: false
            // });
            $('#addVideoModal .document-field').empty()
            $('#addVideoDocument').val("");
            files = [];
            fileNameList = "; "

            $('#listVideo').modal('toggle')
            $('#addVideoModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.save-add-video').attr('data-unit-id', $(this).attr('data-unit-id'));
            $('#addVideoModal input.add-video-name').val('');
            $('#addVideoModal textarea.add-video-description').val('');
            $('#addVideoModal video').addClass('hidden');
        })

        function addEventAndSort(){
            $(".progress-bar").html('');
            $(".progress-bar").css("width", "0%");
            $(".progress-bar").attr("aria-valuemax", "0");

            $(".edit-video").off('click')
            $(".edit-video").click(function(){
                $('.form-html-validate').html('')
                editFiles = []
                var video_id = $(this).attr('data-video-id');
                activeFileToDelete = []
                $('#listVideo').modal('hide')
                $('#editVideoModal').attr('data-video-id', video_id).modal({
                    backdrop: 'static',
                    keyboard: false
                });

                $('.edit-document-field').empty()

                $.ajax({
                method: 'GET',
                url: "{{ url('/') }}/user/videos/"+video_id,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if(response.status == '200'){
                        // $('#editVideoModal #lecture-name').text(response.video.name)
                        $('#editVideoModal input.edit-video-name').val(response.video.name);
                        $('#editVideoModal textarea').val(response.video.description);
                        $('#editVideoModal video').attr('src', "{{ url('uploads/videos') }}/" + response.video.link_video);
                        $("#editVideoModal video")[0].load();

                        filesEditLength = response.video.documents.length

                        response.video.documents.forEach( (document, index) => {
                            // console.log(fileNameListEdit);
                            fileNameListEdit += document.title + "; "
                            // console.log(fileNameListEdit);

                            var html = ''
                            html += `<div class="row" data-index="${index}">`
                                html += `<span class="pull-left">${document.title}</span>`
                                html += `<span class="pull-right btn-delete-document "><button data-index="${index}" data-active="true" data-file-id="${document.id}" class="btn btn-danger" id="btnDeleteDocumentInEdit">Xoá</button></span>`
                            html += `</div>`
                            $('.edit-document-field').append(html)

                        });
                    }
                },
                error: function (error) {
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
            // var inputFileEdit = $('#editVideoDocument')
            // let filesEdit = []

            // inputFileEdit.change(function(){
            //     let newFiles = [];
            //     for(let index = 0; index < inputFile[0].files.length; index++) {
            //         let file = inputFile[0].files[index];
            //         newFiles.push(file);
            //         filesEdit.push(file);

            //         var html = ''
            //         html += `<div class="row" data-index="${filesEdit.length + filesEditLength - 1}">`
            //             html += `<span class="pull-left">${file.name}</span>`
            //             html += `<span class="pull-right btn-delete-document "><button data-index="${filesEdit.length + filesEditLength - 1}" class="btn btn-danger" id="btnDeleteDocument">Xoá</button></span>`
            //         html += `</div>`

            //         $('.document-field').append(html)
            //     }
            //     $('#addVideoDocument').val("");

            // })

            });
            $('#video-file').on('change', function(e){
                    var file = e.target.files[0]
                    var reader = new FileReader()
                    reader.onload(function(e){
                    // console.log(e.target.result);
                    })
                    reader.readAsDataURL(file)
            })
            $('#batv').click(function(){
                $('#fileName').val('')
            })
            $('.save-add-video').off('click');
            $('.save-add-video').click(function(){

                var unit_id = $(this).attr('data-unit-id');
                var video_name = $('.add-video-name').val()
                var video_description = $('.add-video-description').val()
                var link_video = '';
                
                if($('#fileName').val() != ''){
                    var link_video = $('#fileName').val()
                }
                var documents =  JSON.stringify(files)
                // alert(link_video);return

                var formData = new FormData()
                // formData.append('documents', files, 'asdsa')
                formData.append('name', video_name)
                formData.append('description', video_description)
                formData.append('unit_id', unit_id)
                formData.append('link_video', link_video)

                files.forEach((file, index) => {
                    formData.append(`document${index}`, file)
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: 'POST',
                    url: "{{ url('user/units/video/store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    // dataType: 'json',
                    beforeSend: function() {
                        $(".ajax_waiting").addClass("loading");
                    },
                    success: function (response) {
                        $(".ajax_waiting").removeClass("loading");
                        if(response.status == '200'){
                            $('#addVideoModal').modal('hide')
                            $('#listVideo').modal('toggle')
                            files = []

                            $('#file-mp4-upload-off').val('');
                            $('#fileName').val('')
                        }
                    },
                    error: function (error) {
                        $(".ajax_waiting").removeClass("loading");
                        var obj_errors = error.responseJSON.errors;
                        $('.form-html-validate').css('display', 'block')
                        $('.form-html-validate').html('')
                        $.each(obj_errors, function( index, value ) {
                            var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                            $('.form-html-validate.' + index).html(content);
                        })
                        $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                    }
                })
            })

            // $('.save-edit-video').off('click');
            // $('.save-edit-video').on('click', function () {
            //     var video_id = $('#editVideoModal').attr('data-video-id');
            //     var video_name = $('.edit-video-name').val()
            //     var video_description = $('.edit-video-description').val()
            //     var link_video = $('#fileName').val()

            //     var formData = new FormData()

            //     formData.append('_method', 'PUT')
            //     formData.append('name', video_name)
            //     formData.append('description', video_description)
            //     formData.append('link_video', link_video)
            //     formData.append('active_file_to_delete', activeFileToDelete)

            //     editFiles.forEach((file, index) => {
            //         formData.append(`document${index}`, file)
            //     });

            //     $.ajax({
            //         method: 'POST',
            //         url: "{{ url('/') }}/user/units/video/"+ video_id + "/update",
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         beforeSend: function() {
            //             $(".ajax_waiting").addClass("loading");
            //         },
            //         success: function (response) {
            //             $(".ajax_waiting").removeClass("loading");
            //             if(response.status == '200'){
            //                 $('#editVideoModal').modal('hide')
            //                 // $('#listVideo').modal('toggle')
            //                 editFiles = []
            //                 $("#editVideoDocument").val("")
            //                 $("#videoInEdit")[0].pause()
            //             }

            //         },
            //         error: function (error) {
            //             $(".ajax_waiting").removeClass("loading");
            //             var obj_errors = error.responseJSON.errors;
            //             var txt_errors = '';
            //             for (k of Object.keys(obj_errors)) {
            //                 txt_errors += obj_errors[k][0] + '</br>';
            //             }
            //             Swal.fire({
            //                 type: 'warning',
            //                 html: txt_errors,
            //                 allowOutsideClick: false,
            //             })
            //             $("#videoInEdit")[0].pause()
            //         }
            //     })
            // })

            $('.request-edit-video').off('click');
            $('.request-edit-video').on('click', function () {
                var video_id = $('#editVideoModal').attr('data-video-id');
                var video_name = $('.edit-video-name').val()
                var video_description = $('.edit-video-description').val()
                var link_video = $('#fileName').val()

                var formData = new FormData()

                formData.append('_method', 'PUT')
                formData.append('name', video_name)
                formData.append('description', video_description)
                formData.append('link_video', link_video)
                formData.append('active_file_to_delete', activeFileToDelete)

                editFiles.forEach((file, index) => {
                    formData.append(`document${index}`, file)
                });

                // console.log(activeFileToDelete);return;
                $.ajax({
                    method: 'POST',
                    url: "{{ url('/') }}/user/units/video/"+ video_id + "/request-update",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(".ajax_waiting").addClass("loading");
                    },
                    success: function (response) {
                        $(".ajax_waiting").removeClass("loading");
                        if(response.status == '200'){
                            $('#editVideoModal').modal('hide')
                            // $('#listVideo').modal('toggle')
                            editFiles = []
                            $("#editVideoDocument").val("")
                            $("#videoInEdit")[0].pause()
                            Swal.fire({
                                type: 'success',
                                html: response.message,
                                allowOutsideClick: false,
                            })
                        }

                    },
                    error: function (error) {
                        $(".ajax_waiting").removeClass("loading");
                        var obj_errors = error.responseJSON.errors;
                        $('.form-html-validate').css('display', 'block')
                        $('.form-html-validate').html('')
                        $.each(obj_errors, function( index, value ) {
                            var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                            $('.form-html-validate.' + index).html(content);
                        })
                        $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                        $("#videoInEdit")[0].pause()
                    }
                })
            })

            $('.remove-request-update').off('click');
            $('.remove-request-update').on('click', function () {
                var self = $(this)
                var video_id = $(this).attr('data-video-id')
                Swal.fire({
                    type: 'warning',
                    text : 'Xác nhận hủy yêu cầu sửa.',
                    showCancelButton: true,
                }).then( result => {
                    if(result.value){
                        $.ajax({
                            method: 'PUT',
                            url: "{{ url('/') }}/user/units/video/remove-request-update",
                            data: {
                                video_id : video_id
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                $(".ajax_waiting").addClass("loading");
                            },
                            success: function (response) {
                                $(".ajax_waiting").removeClass("loading");
                                if(response.status == '200'){
                                    Swal.fire({
                                        type: 'success',
                                        text: response.message,
                                        allowOutsideClick: false,
                                    })
                                    $('#listVideo .modal-body #videoSortable').empty()
                                    var unit_id = $('#listVideo').attr('data-unit-id')
                                    getListVideoAjax(unit_id)
                                }else{
                                    Swal.fire({
                                        type: 'warning',
                                        text: response.message,
                                    })
                                }
                            },
                            error: function () {
                                $(".ajax_waiting").removeClass("loading");
                            }
                        })
                    }
                })
            })

            $(".remove-video").off('click');
            $(".remove-video").click(function(){
                var self = $(this)
                var video_id = $(this).attr('data-video-id')


                //DuongNT // Đánh lại index cho từng video trên DOM sau khi xoá
                // var deleted_index = $(this).parent().attr("data-video-index")
                // $.each($( "#videoSortable li" ), function( index, value ) {
                //     if(index >= (deleted_index-1)){
                //         $(value).attr("data-video-index", index)
                //     }
                // })
                // console.log(self.parent().children('i.edit-video'));
                // self.parent().children('i.edit-video').remove()

                Swal.fire({
                    type: 'warning',
                    text : 'Bạn có chắc chắn muốn xoá bài giảng này?',
                    showCancelButton: true,
                }).then( result => {
                    if(result.value){
                        $.ajax({
                            method: 'DELETE',
                            url: "{{ url('/') }}/user/units/video/remove",
                            data: {
                                video_id : video_id
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                $(".ajax_waiting").addClass("loading");
                            },
                            success: function (response) {
                                $(".ajax_waiting").removeClass("loading");
                                if(response.status == '200'){
                                    $('#listVideo .modal-body #videoSortable').empty()
                                    var unit_id = $('#listVideo').attr('data-unit-id')
                                    getListVideoAjax(unit_id)
                                }
                                if(response.status == '201'){
                                    return Swal.fire({
                                        type: 'info',
                                        text: response.message,
                                        allowOutsideClick: false,
                                    })
                                    $('#listVideo .modal-body #videoSortable').empty()
                                    var unit_id = $('#listVideo').attr('data-unit-id')
                                    getListVideoAjax(unit_id)
                                }
                            },
                            error: function () {
                                $(".ajax_waiting").removeClass("loading");
                            }
                        })
                    }
                })
            });

            $('.cancel-edit-video').on('click', function(){
                $('#videoInEdit')[0].pause()
            })

            var old_pos = 0;
            var new_pos = 0;
            S( "#videoSortable" ).sortable({
                placeholder: "ui-state-highlight",
                update: function( event, ui ) {
                    // console.log($(ui.item));

                    old_pos = $(ui.item).attr('data-video-index');

                    // check key begin vs after
                    var data = [];
                    var new_pos;
                    $.each($( "#videoSortable li" ), function( index, value ) {
                        if($(value).attr('data-video-index') == old_pos){
                            new_pos = index+1
                        }
                        if(index != $(value).attr('data-video-index')-1 ){

                            data.push({
                                id: $(value).attr('data-video-id'),
                                index: index,
                                unit_id: $(this).attr('data-unit-id')
                            });
                            $(value).attr('data-video-index', index+1)
                        }
                    });
                    // end check key
                    $.ajax({
                        method: "PUT",
                        url: "{{ url('/') }}/user/videos/sort",
                        data: {
                            data: JSON.stringify( data ),
                            old_pos: old_pos,
                            new_pos: new_pos
                        },
                        dataType: 'json',
                        success: function (response) {

                        },
                        error: function (error) {
                            var obj_errors = error.responseJSON.errors;
                            // console.log(obj_errors)
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
                    });
                    addEvent()
                }
            });

            //// upload video updated
            $("#editVideoModal #file-mp4-upload-off-updated").change(function(){
                if(uploading){
                    Swal.fire({
                        type: 'warning',
                        html: 'Bạn chỉ có thể upload khi tiến trình upload trước của bạn đã hoàn tất.',
                        allowOutsideClick: false,
                    })
                }else{
                    $.ajaxSetup(
                        {
                            headers:
                            {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var file = document.getElementById("file-mp4-upload-off-updated").files[0];
                    var extension = document.getElementById("file-mp4-upload-off-updated").files[0].name;
                    extension = extension.split(".");
                    extension_input = extension[extension.length - 1];
                    extension_input = extension_input.toLowerCase();
                    var arrExtension = ["mp4"];
                    if(jQuery.inArray(extension_input, arrExtension) !== -1) {
                        // $('.btn-upload, .or, .btn-link').hide();
                        $('.progressBar').show();
                        var formdata = new FormData();
                        formdata.append("file-mp4-upload-off", file);
                        formdata.append("_token", $('meta[name="csrf-token"]').attr('content'));
                        // formdata.append("data", "{ demo : '{{ time() }}'  }");
                        var ajax = new XMLHttpRequest();
                        ajax.upload.addEventListener("progress", progressHandler, false);
                        ajax.addEventListener("load", completeHandlerEdit, false);
                        ajax.addEventListener("error", errorHandler, false);
                        ajax.addEventListener("abort", abortHandler, false);
                        ajax.open("POST", "{{ url('/') }}/saveFileAjax");
                        ajax.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
                        ajax.send(formdata);
                    } else {
                        Swal.fire({
                            type: 'warning',
                            html: 'Lỗi định dạng.',
                            allowOutsideClick: false,
                        })
                    }
                    $('#file-mp4-upload-off-updated').val('');
                }

                $("#editVideoModal #file-mp4-upload-off-updated").val("")
            });

            //// upload video
            $("#addVideoModal #file-mp4-upload-off").change(function(){
                if(uploading){
                    Swal.fire({
                        type: 'warning',
                        html: 'Bạn chỉ có thể upload khi tiến trình upload trước của bạn đã hoàn tất.',
                        allowOutsideClick: false,
                    })
                }else{
                    uploadFile();
                }
            });

            function uploadFile(){
                $.ajaxSetup(
                    {
                        headers:
                        {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var file = document.getElementById("file-mp4-upload-off").files[0];
                var extension = document.getElementById("file-mp4-upload-off").files[0].name;
                extension = extension.split(".");
                extension_input = extension[extension.length - 1];
                extension_input = extension_input.toLowerCase();
                var arrExtension = ["mp4"];
                if(jQuery.inArray(extension_input, arrExtension) !== -1) {
                    // $('.btn-upload, .or, .btn-link').hide();
                    $('.progressBar').show();
                    var formdata = new FormData();
                    formdata.append("file-mp4-upload-off", file);
                    formdata.append("_token", $('meta[name="csrf-token"]').attr('content'));
                    // formdata.append("data", "{ demo : '{{ time() }}'  }");
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "{{ url('/') }}/saveFileAjax");
                    ajax.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
                    ajax.send(formdata);
                } else {
                    Swal.fire({
                        type: 'warning',
                        html: 'Lỗi định dạng.',
                        allowOutsideClick: false,
                    })
                }
                $('#file-mp4-upload-off').val('');
            }

            function progressHandler(event){
                uploading = true;
                $('.upload-new-video').hide();
                $('.upload-old-video').hide();
                $('.uploading-new-video').show();
                $('.uploading-old-video').show();
                $('.save-add-video').attr('disabled', true);
                $('.cancel-add-video').attr('disabled', true);
                $('.save-edit-video').attr('disabled', true);
                $('.cancel-edit-video').attr('disabled', true);
                var percent = (event.loaded / event.total) * 100;
                var type_txt = checkTypeFile(extension_input);
                waitting_upload_file = true;

                $(".progress-bar").css("width", Math.round(percent) + "%");
                $(".progress-bar").html(Math.round(percent) + "%");
            }

            function completeHandler(event) {
                unsaved = true;
                textUpload = event.target.responseText;
                $('#fileName').val(textUpload);
                $('#addVideoModal video').removeClass('hidden');
                $('#addVideoModal video').attr('src', "{{ url('uploads/videos') }}/" + textUpload + '.mp4');
                $("#addVideoModal video")[0].load();
                uploading = false;
                $('.upload-new-video').show();
                $('.upload-old-video').show();
                $('.uploading-new-video').hide();
                $('.uploading-old-video').hide();
                $('.save-add-video').attr('disabled', false);
                $('.cancel-add-video').attr('disabled', false);
                $('.save-edit-video').attr('disabled', false);
                $('.cancel-edit-video').attr('disabled', false);
                $("#addVideoModal #file-mp4-upload-off").on();
            }

            function completeHandlerEdit(event) {
                unsaved = true;
                textUpload = event.target.responseText;
                $('#fileName').val(textUpload);
                $('#editVideoModal video').attr('src', "{{ url('uploads/videos') }}/" + textUpload + '.mp4');
                $("#editVideoModal video")[0].load();
                uploading = false;
                $('.upload-new-video').show();
                $('.upload-old-video').show();
                $('.uploading-new-video').hide();
                $('.uploading-old-video').hide();
                $('.save-add-video').attr('disabled', false);
                $('.cancel-add-video').attr('disabled', false);
                $('.save-edit-video').attr('disabled', false);
                $('.cancel-edit-video').attr('disabled', false);
                $("#editVideoModal #file-mp4-upload-off-updated").on();
            }

            function errorHandler(event) {
                // alert("Upload Failed");
                document.getElementById("status").innerHTML = "Tải lên thất bại";
            }

            function abortHandler(event) {

                swal({
                  title: "Are you sure?",
                  text: "Once cancel, you will not be able to recover this imaginary file!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                });

                //alert("Upload Aborted");
                //document.getElementById("status").innerHTML = "Upload Aborted";
            }

            function checkTypeFile(extension) {
                if (extension == 'mp3' || extension == 'aac' || extension == 'ogg' || extension == 'm4a' || extension == 'wma' || extension == 'wav' || extension == 'wma'|| extension == 'flac') {
                    return 'Audio';
                } else {
                    return '100%';
                }
            }

        }
        @if(isset($course))
        function addEvent(){
            $("#listUnit{{ $course->id }} .edit-unit").off('click')
            $("#listUnit{{ $course->id }} .remove-unit").off('click')
            $("#listUnit{{ $course->id }} .save-unit").off('click')

            $("#listUnit{{ $course->id }} .save-unit").click(function(){
                // var html = '<i class="fas fa-sort"></i> <span class="unit-content">'+content+'</span> <i class="far fa-trash-alt remove-unit" id="remove-unit" data-id="{{ $course->id }}"></i><i class="far fa-edit edit-unit" id="edit-unit" data-id="{{ $course->id }}"></i>'
                var parent = $(this).parent()
                var name = parent.find('input').val()
                
                // send data to server
                var unit_id = $(this).attr('data-unit-id')
                var content = $('#unit-input-'+unit_id).val()
                var course_id = $(this).attr('data-course-id')
                var data = {
                    name: name
                }

                $.ajax({
                    method: "PUT",
                    url: "{{ url('/') }}/user/units/"+unit_id+"/update",
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == 200){
                            parent.find('input').remove()
                            parent.find('i.save-unit').remove()

                            var html = ""
                            html += '<i class="fas fa-sort"></i> '
                            html += '<span class="unit-content">'+content+'</span>'
                            html += '<i class="far fa-trash-alt remove-unit" id="remove-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'
                            html += '<i class="far fa-edit edit-unit" id="edit-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'
                            html += '<i class="fas fa-bars list-vid-unit" id="list-vid-unit-'+ unit_id +'" data-unit-id="'+ unit_id +'" data-course-id="'+ course_id +'"></i>'

                            parent.append(html)
                            addEvent()
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
                            type: 'warning',
                            html: txt_errors,
                            allowOutsideClick: false,
                        })
                    }
                });
                // end send data to server
                addEvent()
            })

            $("#listUnit{{ $course->id }} .edit-unit").click(function(){
                var unit_id = $(this).attr('data-unit-id');
                var content = $(this).parent().find('span.unit-content').html()
                var html = "<input class='form-control' id='unit-input-"+unit_id+"' value='" + content +"'><i class='fas fa-check save-unit' id='btn-save-unit' data-unit-id='"+unit_id+"'></i>"
                $(this).parent().html(html);
                addEvent()
            })

            $("#listUnit{{ $course->id }} .remove-unit").click(function(){
                var unit_id = $(this).attr('data-unit-id')
                var sefl = $(this)
                var data = {
                    id: unit_id
                };

                $.ajax({
                    method: "DELETE",
                    url: "{{ url('user/units/delete') }}",
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status == 200){
                            sefl.parent().remove()
                            $("#listUnit{{ $course->id }} #sortable").sortable('refresh')
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
                            type: 'warning',
                            html: txt_errors,
                            allowOutsideClick: false,
                        })
                    }
                });
            })

            $('#listUnit{{ $course->id }} .list-vid-unit').on('click', function () {
                var unit_id = $(this).attr('data-unit-id')
                $(".box-unit").modal('hide')
                $("#listVideo").attr("data-unit-id", unit_id)
                $("#listVideo").modal({
                    backdrop: 'static',
                    keyboard: false
                })
            })
        }
        @endif
    });
</script>

<script>
    $( document ).ready(function() {
        var S2 = jQuery.noConflict();

        S2('#image-cropper').cropit();

        $('#btn-cropit-upload').click(function() {
            $('#image-file-input').click();
        });

        var _URL = window.URL || window.webkitURL;
        $("#image-file-input").change(function(e) {
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onerror = function() {
                    Swal.fire({
                        type: 'warning',
                        text: 'Tập tin không hợp lệ!',
                        allowOutsideClick: false,
                    })
                    $("#image-file-input").val('')
                };
                img.onload = function() {
                    if(this.width < 640 || this.height < 360){
                        Swal.fire({
                            type: 'warning',
                            text: 'Yêu cầu kích thước ảnh >= 640x360!',
                            allowOutsideClick: false,
                        })
                        $("#image-file-input").val('')
                    }else{
                        $('#cropit-zoom-input').css('display','block').css('padding-top', '15px');
                        $('#cropitPreview').css('display', 'block')
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        })

        $('#createCourse').on('shown.bs.modal', function (e) {
            $('#image-file-input').val('')
        })

        var link_base64;
        S2('#save-btn').click(function(){
            link_base64 = null;

            if ($('#image-file-input').val() != '') {
                link_base64 = S2('#image-cropper').cropit('export');
            }


            var course_name = $('#course-name').val().trim()
            var short_description = $('#short-description').val().trim()
            var course_description = CKEDITOR.instances['course-description'].getData().trim()
            var course_will_learn = CKEDITOR.instances['course-will-learn'].getData().trim()
            var course_requirement = $('#course-requirement').val().trim()
            var original_price = $('#courseOriginalPrice').val().trim()
            var discount_price = $('#courseDiscountPrice').val().trim()
            var course_approx_time = $('#course-approx-time').val().trim()
            var selector = document.getElementById('course-category')
            var course_category = selector[selector.selectedIndex].value
            var link_intro = $('#course-intro').val().trim()
            
            var flag = true
            $('.form-html-validate').html('')
            if ( link_base64 == null ){
                alertValidate('Bạn chưa chọn Ảnh khóa học.', 'image')
                flag = false
            }
            if ( course_name == '' ){
                alertValidate('Bạn chưa nhập Tên khóa học.', 'name')
                flag = false
            }
            if ( short_description == '' ){
                alertValidate('Bạn chưa nhập Tóm tắt.', 'short_description')
                flag = false
            }
            if ( course_description == '' ){
                alertValidate('Bạn chưa nhập Mô tả.', 'description')
                flag = false
            }
            if ( course_will_learn == '' ){
                alertValidate('Bạn chưa nhập Học viên sẽ học được gì.', 'will_learn')
                flag = false
            }
            if ( course_requirement == '' ){
                alertValidate('Bạn chưa nhập Yêu cầu.', 'requirement')
                flag = false
            }
            if ( course_approx_time == '' ){
                alertValidate('Bạn chưa nhập Thời gian dự kiến hoàn thành.', 'approx_time')
                flag = false
            }
            if( original_price != '' ){
                original_price = Number(original_price)
                if( discount_price != '' ){
                    discount_price = Number(discount_price)
                    if( discount_price > original_price ){
                        alertValidate('Giá sau khi giảm không thể lớn hơn giá gốc.', 'discount_price')
                        flag = false
                    }
                }else{
                    discount_price = original_price
                }
            }else{
                alertValidate('Bạn chưa nhập Giá khóa học.', 'original_price')
                flag = false 
            }

            var url = link_intro;
            if ( url != '' ){
                if (url != undefined ) {
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                    var match = url.match(regExp);
                    if (match && match[2].length == 11) {
                    }else{
                        alertValidate('Link Video không hợp lệ!', 'link_intro')
                        $(this).attr('disabled', false)
                        flag = false
                    }
                }
            }else{
                alertValidate('Bạn chưa nhập Video giới thiệu.', 'link_intro')
                flag = false 
            }
            if ( flag == false ) return

            var data = {
                image:link_base64,
                name: course_name,
                short_description: short_description,
                description: course_description,
                will_learn: course_will_learn,
                requirement: course_requirement,
                original_price: original_price,
                discount_price: discount_price,
                approx_time: course_approx_time,
                category: course_category,
                link_intro: link_intro,
            };

            $.ajax({
                method: "POST",
                url: "{{ url('user/courses/store') }}",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(".ajax_waiting").addClass("loading");
                },
                success: function (response) {
                    $(".ajax_waiting").removeClass("loading");
                    if(response.status == 200){
                        Swal.fire({
                            type: 'success',
                            html: response.message,
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }else{
                        Swal.fire({
                            type: 'warning',
                            html: 'Error',
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(error) {
                    $(".ajax_waiting").removeClass("loading");
                    var obj_errors = error.responseJSON.errors;
                    $('.form-html-validate').css('display', 'block')
                    $('.form-html-validate').html('')
                    $.each(obj_errors, function( index, value ) {
                        var content = '<i class="fas fa-exclamation fa-fw"></i><div class="hover-alert">'+ value +'</div>'
                        $('.form-html-validate.' + index).html(content);
                    })
                    $('.form-html .form-html-validate i').on('click',function(e){ e.stopPropagation() })
                }
            });
            return;
        })
    });
</script>
@endsection
