// Validate Date
function validationDate(dateString) {
    if(dateString == "") return true;
    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
        return false;

    var parts = dateString.split("/");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    return day > 0 && day <= monthLength[month - 1];   
}

function numberFormat( number, decimals, dec_point, thousands_sep ) {
    // * example: number_format(1234.5678, 2, '.', '');
    // * result : 1234.57
                              
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
                              
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function statusOrder($param) {
    switch ($param) {
        case 0:
            $txt = '<span class="btn btn-sm text-center btn-warning active" >Không thành công</span>';
            break;
        case 1:
            $txt = '<span class="btn btn-sm text-center btn-success active" style="cursor: auto;">Thành công</span>';
            break;
        case 2:
            $txt = '<span class="btn btn-sm text-center btn-danger active" >Đã hủy</span>';
            break;
        default:
            $txt = '<span class="btn btn-sm text-center btn-success active" style="cursor: auto;">Thành công</span>';
            break;
    }
    return $txt;
}
