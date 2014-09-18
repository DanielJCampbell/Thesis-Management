;

function studentTypeFilter( oSettings, aData, iDataIndex ) {
  if (aData[2] === type || isSupervisor) {
    return true;
  }
  return false;
}

var type = "All";
var mainTable;
var supervisorTable;
var isSupervisor = false;

window.onload = sendPHPRequest();

function sendPHPRequest() {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
	  mainTable = $("#mainTable").DataTable();
	  supervisorTable = $("#supTable").DataTable();
	  $('#supTable').parents('div.dataTables_wrapper').first().hide();
    }
  }

  req.open('POST', 'AllDB.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  req.send();
}

function showStudents(superID){
}

function showAll() {
  isSupervisor = false;
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  changeFilter(type);
}

function deadlines() {
}

function showUnassessed() {
}

function showProvisional() {
}

function showSupervisor() {
}

function showSuspensions() {
}

function changeFilter(value) {
  
  type = value;
  mainTable.columns().visible(true);
  
  if (value === "Masters") {
    $.fn.dataTable.ext.search.push(studentTypeFilter);
    mainTable.columns(":contains('Type'), :contains('Proposal Seminar'), :contains('Work Hours')").visible(false);
  }
  else if (value === "PhD") {
    $.fn.dataTable.ext.search.push(studentTypeFilter);
    mainTable.columns(":contains('Type'), :contains('3 Month'), :contains('8 Month')").visible(false);
  }
  
}

function popFilter() {
  $.fn.dataTable.ext.search.pop(); 
}
function redraw() {
  mainTable.redraw();
  supervisorTable.redraw();
}