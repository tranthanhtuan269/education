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
    <h1 class="text-center font-weight-600">Thống kê đơn hàng</h1>
</section>
<section class="content page">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-10">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <label>Từ ngày:</label>
                            <input class="form-control" type="text" id="datepicker_from" autocomplete="off"/>
                        </td>
                        <td>
                            <label>đên ngày:</label>
                            <input class="form-control" type="text" id="datepicker_to" autocomplete="off"/>
                        </td>
                        <td>
                            <label>Tên khóa học:</label>
                            <input class="form-control" id="name_course" type="text" autocomplete="off"/>
                        </td>
                        <td>
                            <label>Tên giảng viên:</label>
                            <input class="form-control" id="name_teacher" type="text" autocomplete="off"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="statistic-table">
                    <thead class="thead-custom">
                        <tr>
                            {{-- <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th> --}}
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Tổng giá trị đơn hàng</th>
                            <th scope="col">Hình thức thanh toán</th>
                            <th scope="col">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                {{-- @if (Helper::checkPermissions('statistic.delete', $list_roles))
                    <p class="action-selected-rows">
                        <span >Hành động trên các hàng đã chọn:</span>
                        <span class="btn btn-info ml-5" id="openMultipleEmailModal">Gửi Emails</span>
                    </p>
                @endif --}}
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var dataTable           = null;
    var userCheckList       = [];
    var curr_user_name      = '';
    var curr_user_email     = '';
    var current_page        = 0;
    var old_search          = '';
    var errorConnect        = "Please check your internet connection and try again.";

    function formatNumber(nStr, decSeperate, groupSeperate) {
        nStr += '';
        x = nStr.split(decSeperate);
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    }

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
    }

    function detailOrder(order_id) {
        var data = {
            order_id:$order_id,
        };
        
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/admincp/events/delMulti",
            data: data,
            beforeSend: function(r, a){
                current_page = dataTable.page.info().page;
                $(".ajax_waiting").addClass("loading");
            },
            complete: function() {
                $(".ajax_waiting").removeClass("loading");
            },
            success: function (response) {
                if(response.status == 200){
                    dataTable.page(checkEmptyTable()).draw(false);
                    $().toastmessage('showSuccessToast', response.message);
                }
            },
            error: function (data) {
                if(data.status == 401){
                    window.location.replace(baseURL);
                }else{
                    $().toastmessage('showErrorToast', errorConnect);
                }
            }
        });
    }

    $(document).ready(function(){
        $("#datepicker_from").datepicker({
            dateFormat: 'dd/mm/yy',
        })
        
        $("#datepicker_to").datepicker({
            dateFormat: 'dd/mm/yy',
        })

        var dataObject = [
            {
                data: "code",
                class: "field_code text-center",
                orderable: false
            },
            {
                data: "total_price",
                class: "field_total_price text-center"
            },
            {
                data: "payment_name",
                class: "text-center",
                orderable: false
            },
            {
                data: "created_at",
                class: "field_created_at text-center"
            },
        ];

        dataTable = $('#statistic-table').DataTable( {
                        serverSide: true,
                        // aaSorting: [],
                        stateSave: true,
                        searching: false,
                        ajax:{
                            url: "{{ url('/') }}/admincp/statistic/getDataAjax",
                            beforeSend: function() {
                                $(".ajax_waiting").addClass("loading");
                            }
                        }, 
                        columns: dataObject,
                        // bLengthChange: false,
                        // pageLength: 10,
                        order: [[ 3, "desc" ]],
                        colReorder: {
                            fixedColumnsRight: 1,
                            fixedColumnsLeft: 1
                        },
                        oLanguage: {
                            sSearch: "Tìm kiếm",
                            sLengthMenu: "Hiển thị _MENU_ bản ghi",
                            // zeroRecords: "Không tìm thấy bản ghi",
                            sInfo: "Hiển thị  _START_ - _END_ /_TOTAL_ bản ghi",
                            sInfoFiltered: "",
                            sInfoEmpty: "",
                            sZeroRecords: "Không tìm thấy kết quả tìm kiếm",
                            oPaginate: {
                                sPrevious: "Trang trước",
                                sNext: "Trang sau",
                            },
                        },
                        createdRow: function(row, data, dataIndex) {
                            var $field_code = $(row).find('td.field_code'); 
                            var field_code = $field_code.text(); 
                            $field_code.data('order', field_code).html('<a href="javascript:void(0)" onclick=detailOrder('+ data.code +')>ĐH_' + field_code + '</a>');

                            var $field_total_price = $(row).find('td.field_total_price'); 
                            var field_total_price = $field_total_price.text(); 
                            $field_total_price.data('order', field_total_price).text(formatNumber(field_total_price, '.', ','));
                            
                        },
                        fnServerParams: function ( aoData ) {
                            aoData.name_course = $('#name_course').val();
                            aoData.name_teacher = $('#name_teacher').val();
                            aoData.datepicker_from = $('#datepicker_from').val();
                            aoData.datepicker_to = $('#datepicker_to').val();
                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            // checkCheckboxChecked();
                        },
                        // "searching": false,
                    });

        $('#statistic-table').css('width', '100%');

        $('#name_course, #name_teacher').keyup(delay(function (e) {
            dataTable.draw();
        }, 800));

        $('#datepicker_from, #datepicker_to').on("change", function(event){
            dataTable.draw();
        });

        //select all checkboxes
        $("#select-all-btn").change(function(){
            $('.page table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });

        $('body').on('click', '.page table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false);
            }
            if ($('.page table tbody input[type="checkbox"]:checked').length == $('.page table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }

            // save localstore
            setCheckboxChecked();
        });

        function setCheckboxChecked(){
            userCheckList = [];
            $.each($('.check-user'), function( index, value ) {
                if($(this).prop('checked')){
                    userCheckList.push($(this).val());
                }
            });
            // console.log(userCheckList);
        }

        function checkCheckboxChecked(){
            // console.log(userCheckList);
            var count_row = 0;
            var listUser = $('.check-user');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), userCheckList)){
                        $(this).prop('checked', 'true');
                        count_row++;
                    }
                });

                if(count_row == listUser.length){
                    $('#select-all-btn').prop('checked', true);
                }else{
                    $('#select-all-btn').prop('checked', false);
                }
            }else{
                $('#select-all-btn').prop('checked', false);
            }
        }

        function containsObject(obj, list) {
            var i;
            for (i = 0; i < list.length; i++) {
                if (list[i] === obj) {
                    return true;
                }
            }

            return false;
        }

        function addEventListener(){
        }

        function checkEmptyTable(){
            if ($('#statistic-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    });
</script>

@endsection
