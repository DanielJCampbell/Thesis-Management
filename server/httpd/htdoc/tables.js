;
var mainTable;
var supTable;

function studentTypeFilter( oSettings, aData, iDataIndex ) {
  if (aData[2] === type || isSupervisor) {
    return true;
  }
  return false;
}

var type = "All";
var isSupervisor = false;

window.onload = sendPHPRequest();

function sendPHPRequest() {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
	  $('#supTable').parents('div.dataTables_wrapper').first().hide();
	  mainTable = $("#mainTable").dataTable();
	  supTable =  $("#supTable").dataTable();
	  showAll();
    }
  }

  req.open('POST', 'AllDB.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  req.send();
}
/**
function showStudents(superID){
}*/

function showAll() {
  isSupervisor = false;
  type = "All";
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  $('#mainTable').parents('div.dataTables_wrapper').first().show();
  changeFilter(type);
}
/**
function deadlines() {
}

function showUnassessed() {
}
/** DO NOT COMMIT, OR DEATH!
function showProvisional() {
}

function showSupervisor() {
}

function showSuspensions() {
}
*/
function changeFilter(value) {
  
  type = value;
  mainTable.api().columns().visible(true);
  
  if (value === "Masters") {
    $.fn.dataTable.ext.search.push(studentTypeFilter);
     mainTable.api().columns(":contains('Type'), :contains('Proposal Seminar'), :contains('Work Hours')").visible(false);
  }
  else if (value === "All") {
     mainTable.api().columns().visible(true);
  }
  else if (value === "PhD") {
    $.fn.dataTable.ext.search.push(studentTypeFilter);
   mainTable.api().columns(":contains('Type'), :contains('3 Month'), :contains('8 Month')").visible(false);
  }
  
}

//Kill type for both

//To kill for masters
//echo "<th> 3 Month Report Deadline </th>";
//echo "<th> 3 Month Report Submission </th>";
//echo "<th> 3 Month Report Approval </th>";
//echo "<th> 8 Month Report Deadline </th>";
//echo "<th> 8 Month Report Submission </th>";
//echo "<th> 8 Month Report Approval </th>";

function popFilter() {
  $.fn.dataTable.ext.search.pop(); 
}
function redraw() {
  mainTable.fnDraw();
  supTable.fnDraw();
}