@extends('backends.master')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/api/fnReloadAjax.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
<link data-require="jqueryui@*" data-semver="1.10.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
<script data-require="jqueryui@*" data-semver="1.10.0" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>

<section class="content-header">
    <h1 class="text-center font-weight-600">Danh sách đơn hàng</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div class="filter-cat text-right">
                    <span id="date-label-from" class="date-label">Từ ngày: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
                    &nbsp &nbsp<span id="date-label-to" class="date-label">Đến ngày: </span><input class="date_range_filter date" type="text" id="datepicker_to" />
                </div>
                <table class="table table-bordered" id="orders-table">
                    <tfoot class="d-none">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <thead class="thead-custom">
                        <tr>
                            <th id="order-posts" colspan="11" style="border: none;">
                                Lọc theo trạng thái đơn hàng: 
                            </th>
                        </tr>
                        <tr>
                            <th class="id-field" width="1%">
                                <input type="checkbox" id="select-all-btn" data-check="false">
                            </th>
                            <th scope="col">Id</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Ngày tạo đơn</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col" width="8%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                @if (in_array('order.del', $listRoles) )
                <p class="action-selected-rows">
                    <span >Hành động trên các hàng đã chọn:</span>
                    <span class="btn btn-info ml-2" id="apply-all-btn">Xóa</span>
                </p>
                @endif
            </div>
        </div>
    </div>
    <div id="show-detail" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" style="color: #8cc63f">Chi tiết đơn hàng </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    @if (in_array('order.edit', $listRoles) )
                    @foreach ( $order_status as $value)
                    <button type="button" class="btn btn-sm action btn-status-order-action" style="color:#fff;background-color:{{ $value->color }}" data-status="{{ $value->id }}">{{ $value->name }}</button>
                    @endforeach
                    @endif
                    <button type="button" class="btn btn-secondary btn-sm btn-close-order" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var dataTable               = null;
    var roleCheckList           = [];
    var curr_role_name          = '';
    var curr_permission_list    = '';
    var current_page            = 0;
    var old_search              = '';
    var errorConnect            = "Please check your internet connection and try again.";
    var order_status = <?php echo json_encode($order_status) ?>;
   
    $(document).ready(function(){
        var dataObject = [
            { 
                data: "rows",
                class: "rows-item",
                render: function(data, type, row){
                    return '<input type="checkbox" name="selectCol" class="check-role" value="' + data + '" data-column="' + data + '">';
                },
                orderable: false
            },
            { 
                data: "id",
            },
            { 
                data: "username",
            },
            { 
                data: "email",
            },
            { 
                data: "phone",
            },
            { 
                data: "addressDetail",
            },
            { 
                data: "total_price"
            },
            { 
                data: "created_at",
            },
            { 
                data: "order_status.name",
                visible : false,
            },
            { 
                data: "color",
            },
            { 
                data: "action", 
                class: "action-field",
                render: function(data, type, row){
                    var html = '';
                    @if (in_array('order.view', $listRoles) )
                        html += '<span class="btn-edit" data-id="'+data+'" title="View" style="margin-right:5px;"><i class="fa fa-eye" aria-hidden="true"></i></span>';
                    @endif
    
                    @if (in_array('order.del', $listRoles) )
                        html += '<span class="btn-delete" data-id="'+data+'" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></span>';
                    @endif
    
                    return html;
                },
                orderable: false
            },
        ];
    
        dataTable = $('#orders-table').DataTable( {
                        serverSide: true,
                        aaSorting: [],
                        stateSave: false,
                        search: {
                            smart: false
                        },
                        ajax: "{{ url('/') }}/admincp/cart/getDataAjax",
                        columns: dataObject,
                        // bLengthChange: false,
                        // pageLength: 25,
                        order: [[ 7, "desc" ]],
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
                        // createdRow: function( row, data, dataIndex){
                        //     $(row).css('background-color', data.color);
                        // },
                        initComplete: function () {
                            var filterByCat = '';
                            this.api().columns(8).every( function () {
                                var column = this;
                                var select = $('<select class="form-control-sm"><option value="">Tất cả</option></select>')
                                    .appendTo( $(column.footer()).empty() )
                                    .on( 'change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );
                 
                                        column
                                            .search( val ? '^'+val+'$' : '', true, false )
                                            .draw();
                                    } );
                                    
                                $.each( order_status, function( key, value ) {
                                  filterByCat = select.append( '<option value="'+value.name+'">'+value.name+'</option>' )
                                });

                            } );
                            $('#order-posts').append(filterByCat)
                        },
                        fnServerParams: function ( aoData ) {
                            //console.log(aoData);
                        },
                        fnDrawCallback: function( oSettings, aData, iDataIndex ) {
                            addEventListener();
                            checkCheckboxChecked();
                        }
                    });
        
        $('#orders-table').css('width', '100%');

    
        dataTable.search('').draw();
    
        //select all checkboxes
        $("#select-all-btn").change(function(){  
            $('#orders-table tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
            // save localstore
            setCheckboxChecked();
        });
    
        $('body').on('click', '#orders-table tbody input[type="checkbox"]', function() {
            if(false == $(this).prop("checked")){
                $("#select-all-btn").prop('checked', false); 
            }
            if ($('#orders-table tbody input[type="checkbox"]:checked').length == $('#orders-table tbody input[type="checkbox"]').length ){
                $("#select-all-btn").prop('checked', true);
            }
    
            // save localstore
            setCheckboxChecked();
        });
    
        function setCheckboxChecked(){
            roleCheckList = [];
            $.each($('.check-role'), function( index, value ) {
                if($(this).prop('checked')){
                    roleCheckList.push($(this).val());
                }
            });
            // console.log(roleCheckList);
        }
    
        function checkCheckboxChecked(){
            // console.log(roleCheckList);
            var count_row = 0;
            var listUser = $('.check-role');
            if(listUser.length > 0){
                $.each(listUser, function( index, value ) {
                    if(containsObject($(this).val(), roleCheckList)){
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
            $('.btn-edit').off('click');
            $('.btn-edit').click(function(){
            	var _self   = $(this);
                var id      = $(this).attr('data-id');
                $('#show-detail .modal-footer button').attr('data-id', id);
                
                $.ajax({
                    url: baseURL+"/admincp/orders/" + id,
                    method: "GET",
                    dataType:'json',
                    success: function (response) {
                    	console.log(response);
                        $('#show-detail .modal-title').html('Chi tiết đơn hàng #{{ BatvHelper::codeOrder() }}' + id)
                        var html_data = '<table class="table"><thead><tr><th scope="col">Thông tin chung</th><th scope="col">Thông tin thanh toán</th></tr></thead><tbody>';
    
                        html_data += '<tr>';
                        html_data += '<td style="width:38%;">';
                            html_data += '<table><tbody><tr><td>Họ và tên: </td><td>' + response.infoCustomer.username + '</td></tr><tr><td>Ngày tạo: </td><td>' + response.infoCustomer.order_created_at + '</td></tr><tr><td>Trạng thái: </td><td class="status_order"><span class="btn btn-sm" style="background-color:' + response.infoCustomer.color + '">' + response.infoCustomer.order_status_name + '</span></td></tr></tbody></table>';
                        html_data += '<td style="width:62%;">';
                            html_data += '<table><tbody>';
                            html_data += '<tr><td style="width:45%;">Địa chỉ: </td><td>';
                            html_data += response.infoCustomer.address + (response.infoCustomer.district_name == null ? '' : ', ' + response.infoCustomer.district_name) + (response.infoCustomer.city_name == null ? '' : ', ' + response.infoCustomer.city_name) + '</td></tr>';
                            html_data += '<tr><td style="width:45%;">Email: </td><td>' + response.infoCustomer.email + '</td></tr>';
                            html_data += '<tr><td style="width:45%;">Số điện thoại: </td><td>' + response.infoCustomer.phone + '</td></tr>';
                            html_data += '<tr><td style="width:45%;">Phương thức thanh toán: </td><td>'+ response.infoCustomer.method_payment +'</td></tr>';
                            html_data += '</tbody></table>';
                        html_data += '</td>';
                        html_data += '</tr>';
    
                        html_data += '</tbody></table>';
    
                        html_data += '<table class="table table-bordered"><thead><tr><th scope="col">Tên sản phẩm</th><th scope="col">Số lượng</th><th scope="col">Giá</th></tr></thead><tbody>';
                        var totalValue = 0;
                        for(var i = 0; i < response.productList.length; i++){
                           html_data += '<tr>';
                           html_data += '<td>';
                           html_data += response.productList[i].name;
                           html_data += '</td>';
                           html_data += '<td>';
                           html_data += response.productList[i].pieces;
                           html_data += '</td>';
                           html_data += '<td>';
    
                           html_data += response.productList[i].sale > 0 ? numberFormat(response.productList[i].sale, 0, '.', '.') : numberFormat(response.productList[i].price, 0, '.', '.');
    
                           html_data += '</td>';
                           html_data += '</tr>';
    
                           totalValue += response.productList[i].sale > 0 ? response.productList[i].pieces * response.productList[i].sale : response.productList[i].pieces * response.productList[i].price;
                        }
                        html_data += '<tr><td></td><td><b>Tổng cộng</b></td><td style="color:red; font-size:18px;">'+ numberFormat(totalValue, 0, '.', '.') +'</td></tr>';
                        html_data += '</tbody></table>';
                        
                    	$('#show-detail .modal-body').html(html_data);
                    	$('#show-detail').modal('toggle');
                    },
                    error: function (data) {
                        if(data.status == 401){
                          window.location.replace(baseURL);
                        }else{
                         $().toastmessage('showErrorToast', errorConnect);
                        }
                    }
                });
            });
    
            $('.btn-delete').off('click');
            $('.btn-delete').click(function(){
                var _self   = $(this);
                var id      = $(this).attr('data-id');
                $.ajsrConfirm({
                    message: "Bạn có chắc chắn muốn xóa ?",
                    okButton: "Đồng ý",
                    onConfirm: function() {
                        var data = {
                            id:id,
                            _method:'DELETE'
                        };
    
                        $.ajax({
                            type: "POST",
                            url: baseURL+"/admincp/orders/" + id,
                            data: data,
                            method: "POST",
                            dataType:'json',
                            success: function (response) {
                                $('#show-detail').modal('hide');
                                if(response != null){
                                    $().toastmessage('showSuccessToast', response.Message);
                                    dataTable.ajax.reload(); 
                                }else{
                                    $().toastmessage('showErrorToast', response.Message);
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
                    },
                    nineCorners: false,
                });
            });
        }
    
        function checkEmptyTable(){
            if ($('#orders-table').DataTable().data().count() <= 1 && current_page > 0) {
                current_page = current_page - 1;
            }
            return current_page;
        }
    
        $('#show-detail .modal-footer button.action').click(function(){
            var id_status = $(this).attr('data-status');
            var id_order = $(this).attr('data-id');
            var data = {
                id_status:id_status,
                id_order:id_order,
                _method:'PUT'
            };
            $.ajaxSetup(
            {
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ url('/') }}/admincp/order/updateStatusOrder",
                data: data,
                success: function (response) {
                    $('#show-detail').modal('toggle');
                    if(response != null){
                        $().toastmessage('showSuccessToast', 'Cập nhật đơn hàng thành công');
                        dataTable.ajax.reload(); 
                    }else{
                        $().toastmessage('showErrorToast', 'Cập nhật đơn hàng thất bại');
                    }
                },
                error: function (data) {
                }
            });
        });
    
        $('#apply-all-btn').click(function (){
            $.ajsrConfirm({
                message: "Bạn có chắc chắn muốn xóa ?",
                okButton: "Đồng ý",
                onConfirm: function() {
                    var $id_list = '';
                    $.each($('.check-role'), function (key, value){
                        if($(this).prop('checked') == true) {
                            $id_list += $(this).attr("data-column") + ',';
                        }
                    });
    
                    if ($id_list.length > 0) {
                        var $id_list = '';
                        $.each($('.check-role'), function (key, value){
                            if($(this).prop('checked') == true) {
                                $id_list += $(this).attr("data-column") + ',';
                            }
                        });
    
                        if($id_list.length > 0){
                            var data = {
                                id_list:$id_list,
                                _method:'delete'
                            };
    
                            $.ajax({
                                type: "POST",
                                url: "{{ url('/') }}/admincp/orders/delMulti",
                                data: data,
                                success: function (response) {
                                    var obj = $.parseJSON(response);
                                    if(obj.status == 200){
                                        $.each($('.check-role'), function (key, value){
                                            if($(this).prop('checked') == true) {
                                                $(this).parent().parent().hide("slow");
                                            }
                                        });
                                        $().toastmessage('showSuccessToast', obj.Message);
                                        dataTable.ajax.reload(); 
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
                    }
                },
                nineCorners: false,
            });
    
        });
        
        $("#datepicker_from").datepicker({
            dateFormat: 'dd/mm/yy',
            "onSelect": function(date) {
                date = date.split('/');
                minDateFilter = new Date(date[2]+'-'+date[1]+'-'+date[0]).getTime();
                //alert(new Date('03/03/2016').getTime());
                dataTable.draw();
            }
        }).keyup(function() {
            date = this.value;
            date = date.split('/');
            console.log(date);
            minDateFilter = new Date(date[2]+'-'+date[1]+'-'+date[0]).getTime();
            dataTable.draw();
        });
        
        $("#datepicker_to").datepicker({
            dateFormat: 'dd/mm/yy',
            "onSelect": function(date) {
                date = date.split('/');
                maxDateFilter = new Date(date[2]+'-'+date[1]+'-'+date[0]).getTime();
                dataTable.draw();
            }
        }).keyup(function() {
            date = this.value;
            date = date.split('/');
            maxDateFilter = new Date(date[2]+'-'+date[1]+'-'+date[0]).getTime();
            dataTable.draw();
        });

        // Date range filter
        minDateFilter = "";
        maxDateFilter = "";
        
        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData._date == 'undefined') {
                    date = aData[7].split('/');
                    var year = date[2].split(' ');
                    // alert(year[0]+'-'+date[1]+'-'+date[0]);
                    aData._date = new Date(year[0]+'-'+date[1]+'-'+date[0]).getTime();
                }
            
                if (minDateFilter && !isNaN(minDateFilter)) {
                    if (aData._date < minDateFilter) {
                        return false;
                    }
                }
            
                if (maxDateFilter && !isNaN(maxDateFilter)) {
                    if (aData._date > maxDateFilter) {
                        return false;
                    }
                }
            
                return true;
            }
        );
    });
</script>

@endsection