@extends('backends.master')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<section class="content-header">
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Thống kê đơn hàng</h1>
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <label>Từ ngày:</label>
                            <input class="form-control" type="text" id="datepicker_from" autocomplete="off"/>
                        </td>
                        <td>
                            <label>Đến ngày:</label>
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
                        <td>
                            <label>&nbsp;</label>
                            <div type="button" class="btn btn-primary" id="search" style="width:100%">Tìm kiếm</div>
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
                            <th scope="col">Hình thức thanh toán</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tổng giá trị đơn hàng (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:right">Tổng tiền/1 trang:</th>
                            <th>
                                <span id="total_page"></span>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align:right">Tổng tiền/tất cả:</th>
                            <th>
                                <span id="total_all" style="color:red; font-size:20px"></span>
                            </th>
                        </tr>
                    </tfoot>
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
    <div id="show-detail-order" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color: #00B7F1">Chi tiết đơn hàng</h4>
                </div>
                <div class="modal-body">
                </div>
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
            order_id : order_id,
        };
        
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/admincp/statistic/detailOrder",
            data: data,
            beforeSend: function(r, a){
                $(".ajax_waiting").addClass("loading");
            },
            complete: function() {
                $(".ajax_waiting").removeClass("loading");
            },
            success: function (response) {
                if(response.status == 200){
                    var data = response.data;
                    var real_price = data.real_price;
                    var courses              = JSON.parse(data.content);

                    $('#show-detail-order .modal-title').html('Chi tiết đơn hàng #DH_' + order_id)
                    var html_data = '<table class="table"><thead><tr><th scope="col">Thông tin chung</th><th scope="col">Thông tin thanh toán</th></tr></thead><tbody>';

                    html_data += '<tr>';
                    html_data += '<td style="width:38%;">';
                        html_data += '<table><tbody><tr><td style="width:45%;">Họ tên: </td><td>' + data.name +'</td></tr><tr><td style="width:45%;">Ngày tạo:</td><td>' + data.created_at + '</td></tr><tr><td>Trạng thái: </td><td style="width:45%;">' + statusOrder(data.status) + '</td></tr></tbody></table>';
                    html_data += '<td style="width:62%;">';
                        html_data += '<table><tbody>';
                        
                        html_data += `<tr>`
                            html_data += `<td style="width:45%;">Địa chỉ: </td>`
                            html_data += `<td>`
                                html_data += data.address
                            html_data += `</td>`
                        html_data += `</tr>`

                        html_data += '<tr><td style="width:45%;">Email: </td><td>' + data.email + '</td></tr>';
                        html_data += '<tr><td style="width:45%;">Số điện thoại: </td><td>' + data.phone + '</td></tr>';
                        html_data += '<tr><td style="width:45%;">Thanh toán: </td><td>' + data.payment_name + '</td></tr>';
                        html_data += '</tbody></table>';
                    html_data += '</td>';
                    html_data += '</tr>';

                    html_data += '</tbody></table>';

                    html_data += '<table class="table table-bordered"><thead><tr><th scope="col">Tên khóa học</th><th scope="col">Giá gốc</th><th scope="col">Chiết khấu</th><th scope="col">Giá thanh toán</th></tr></thead><tbody>';
                    var totalValue = 0;
                    var total_payment = 0;
                    var total_discount = 0;
    
                    for(var i = 0; i < courses.length; i++){
                        
                        html_data += '<tr>';
                        html_data += '<td>';
                        html_data += courses[i].name;
                        html_data += '</td>';

                        html_data += '<td style="font-size:15px; text-align:right;">';
                        html_data += numberFormat(courses[i].real_price, 0, '.', '.') + ' đ';
                        html_data += '</td>';

                        discount = courses[i].real_price - courses[i].sale;
                        html_data += '<td style="font-size:15px; text-align:right;">- ';
                        html_data += numberFormat(discount, 0, '.', '.') + ' đ';
                        html_data += '</td>';

                        html_data += '<td style="font-size:15px; text-align:right;"><b>';
                        html_data += numberFormat(courses[i].sale, 0, '.', '.') + ' đ';
                        html_data += '</b></td>';
                        html_data += '</tr>';

                        totalValue += courses[i].real_price > 0 ? 1 * courses[i].real_price : 1 * courses[i].price;
                        total_discount += discount;
                        total_payment += courses[i].sale;
                    }
                    html_data += '<tr><th><b>Tổng</b></th><th style="font-size:15px; text-align:right;">'+ numberFormat(totalValue, 0, '.', '.') +' đ</th><th style="font-size:15px; text-align:right;">- '+ numberFormat(total_discount, 0, '.', '.') +' đ</th><th style="color:red; font-size:18px; text-align:right;"><b>'+ numberFormat(total_payment, 0, '.', '.') +' đ</b></th></tr>';

                    // if (data.coupon != '') {
                    //     html_data += '<tr><td><b>Tổng giảm giá</b></td><td style="font-size:15px; text-align:right;">'+ numberFormat(totalValue - real_price, 0, '.', '.') +' đ</td></tr>';
                    //     html_data += '<tr><td><b>Tổng cộng</b></td><td style="color:red; font-size:18px; text-align:right;">'+ numberFormat(real_price, 0, '.', '.') +' đ</td><td style="color:red; font-size:18px; text-align:right;">'+ numberFormat(real_price, 0, '.', '.') +' đ</td><td style="color:red; font-size:18px; text-align:right;">'+ numberFormat(real_price, 0, '.', '.') +' đ</td></tr>';
                    // }
                    html_data += '</tbody></table>';
                    
                    $('#show-detail-order .modal-body').html(html_data);
                    $('#show-detail-order').modal('toggle');
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
                data: "payment_name",
                class: "text-center",
                orderable: false
            },
            {
                data: "created_at",
                class: "field_created_at text-center"
            },
            {
                data: "total_price",
                class: "field_total_price text-center"
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
                        order: [[ 2, "desc" ]],
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

                            $('#total').html(formatNumber(data.total, '.', '.'));
                            
                            var $field_code = $(row).find('td.field_code'); 
                            var field_code = $field_code.text(); 
                            $field_code.data('order', field_code).html('<a href="javascript:void(0)" onclick=detailOrder('+ data.code +')>ĐH_' + field_code + '</a>');

                            var $field_total_price = $(row).find('td.field_total_price'); 
                            var field_total_price = $field_total_price.text(); 
                            $field_total_price.data('order', field_total_price).text(formatNumber(field_total_price, '.', '.'));

                            var $field_created_at = $(row).find('td.field_created_at'); 
                            var field_created_at = $field_created_at.text(); 
                            $field_created_at.data('order', field_created_at).text(moment(field_created_at).format('DD-MM-Y H:mm:ss'));
                        },
                        fnServerParams: function ( aoData ) {
                            aoData.name_course = $('#name_course').val();
                            aoData.name_teacher = $('#name_teacher').val();
                            aoData.datepicker_from = $('#datepicker_from').val();
                            aoData.datepicker_to = $('#datepicker_to').val();
                        },
                        fnDrawCallback: function( oSettings ) {
                            addEventListener();
                            var api = this.api();
                            var data = api.rows( {page:'current'} ).data();

                            if (data.length > 0) {
                                $('#total_all').html(formatNumber(data[0].total, '.', '.'))
                            } else {
                                $('#total_all').html(0)
                            }
                        },
                        footerCallback: function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                            
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                
                            pageTotal = api
                                .column( 3, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                

                            $('#total_page').html(formatNumber(pageTotal, '.', '.'))
                        },
                        // rowCallback: function( row, data, index ) {
                        //     alert(1)
                        //     $('#total_all').html(formatNumber(data.total, '.', '.'))
                        // }
                    });

        $('#statistic-table').css('width', '100%');

        // $('#name_course, #name_teacher').keyup(delay(function (e) {
        //     dataTable.draw();
        // }, 800));

        // $('#datepicker_from, #datepicker_to').on("change", function(event){
        //     dataTable.draw();
        // });

        $("#search").click(function(){
            var datepicker_from = $('#datepicker_from').val();
            var datepicker_to = $('#datepicker_to').val();

            if (datepicker_from != '') {
                if (!validationDate(datepicker_from)) {
                    Swal.fire({
                        type: 'warning',
                        text: 'Xin vui lòng nhập thời gian hợp lệ! ?',
                    });
                    return;
                }
            }

            if (datepicker_to != '') {
                if (!validationDate(datepicker_to)) {
                    Swal.fire({
                        type: 'warning',
                        text: 'Xin vui lòng nhập thời gian hợp lệ! ?',
                    });
                    return;
                } else {
                    if (datepicker_from != '') {
                        job_start_date = datepicker_from.split('/');
                        job_end_date = datepicker_to.split('/');

                        var new_start_date = new Date(job_start_date[2],job_start_date[1],job_start_date[0]);
                        var new_end_date = new Date(job_end_date[2],job_end_date[1],job_end_date[0]);

                        if(new Date(new_start_date) > new Date(new_end_date))
                        {
                            Swal.fire({
                                type: 'warning',
                                text: 'Khoảng thời gian nhập từ ngày - đến ngày không hợp lệ!',
                            });

                            return;
                        }
                    }
                }
            }

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
