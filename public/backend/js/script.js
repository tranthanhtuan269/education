$(document).ready(function(){
	var url = $('base').attr('href');
	var fullUrl = window.location.href;
  
	$('.nav-list').click(function(){
		if($(this).find('.menu-icon-right').hasClass('fa-angle-down')){
			$(this).find('.menu-icon-right').removeClass('fa-angle-down').addClass('fa-angle-right');
		}else{
			$(this).find('.menu-icon-right').addClass('fa-angle-down').removeClass('fa-angle-right');
		}
	});

});

function confimDelete(id) {
  $.ajsrConfirm({
      message: "Bạn có chắc chắn muốn xóa ?",
      okButton: "Đồng ý",
      onConfirm: function() {
          $('form#' + id).submit()
      },

  });
  return false;
}

function searchFormJs() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("search-form-js");
  filter = input.value.toUpperCase();
  table = document.getElementById("group-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function closePopup() {
  $("#btn-cancel").trigger("click");
}

$(document).keydown(function(e) {

  if (e.keyCode == 27) {
    $("#btn-cancel").trigger("click");
  }

});


// Validate Date
function validationDate(dateString) {
  if (dateString == "") return true;
  if (!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
    return false;

  var parts = dateString.split("/");
  var day = parseInt(parts[0], 10);
  var month = parseInt(parts[1], 10);
  var year = parseInt(parts[2], 10);

  if (year < 1000 || year > 3000 || month == 0 || month > 12)
    return false;

  var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

  if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    monthLength[1] = 29;

  return day > 0 && day <= monthLength[month - 1];
}