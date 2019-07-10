@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="{{ url('/') }}/backend/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap-multiselect.css" type="text/css"/>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section class="content-header">
    
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Tặng khóa học</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="text-center font-weight-600">Chọn số học viên</div>
            <button class="student-number btn btn-primary">Random</button>
        </div>
        <div class="col-md-6">
            <div class="text-center font-weight-600">Chọn khóa học</div>
            <button class="select-course btn btn-primary">Chọn khóa học</button>
        </div>
    </div>
</section>
<section>
    <div class="modal fade" id="showSelectCourse" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h3>Chọn khóa học</h3>
                </div>
                <div class="modal-body">

                <select id='custom-headers' multiple='multiple'>
                    <option value='elem_1' selected>elem 1</option>
                    <option value='elem_2'>elem 2</option>
                    <option value='elem_3'>elem 3</option>
                    <option value='elem_4' selected>elem 4</option>
                    ...
                    <option value='elem_100'>elem 100</option>
                </select>

                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="typeStudentNumber" tabindex="-1">
        <div class="modal-content" >
            <div class="modal-header">
                <h3>Nhập số học viên</h3>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-11">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function addEventListener(){
            $('.select-course').off('click')
            $('.select-course').click(function(){
                $('#showSelectCourse').modal('show');
            })

            $('.student-number').off('click')
            $('.student-number').click(function(){
                $('#typeStudentNumber').modal('show');
            })
    }

    $('.searchable').multiSelect({
  selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"12\"'>",
  selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"4\"'>",
  afterInit: function(ms){
    var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
    .on('keydown', function(e){
      if (e.which === 40){
        that.$selectableUl.focus();
        return false;
      }
    });

    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
    .on('keydown', function(e){
      if (e.which == 40){
        that.$selectionUl.focus();
        return false;
      }
    });
  },
  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
});
</script>

@endsection