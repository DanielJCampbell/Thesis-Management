;
var mainTable;
var supTable;

function studentTypeFilter( oSettings, aData, iDataIndex ) {
  if (aData[2] === type || isSupervisor || type === "All") {
    return true;
  }
  return false;
}

function nonCurrentStudentFilter(oSettings, aData, iDataIndex){
	if (isSupervisor) {return true;}
	if (aData[13] == "" || aData[29] != "" || aData[32] == "True"){
		return showNonCurrentStudents;
	}
	return !showNonCurrentStudents;
}

var type = "All";
var isSupervisor = false;
var showNonCurrentStudents = false;

window.onload = sendPHPRequest();

function sendPHPRequest() {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
	  $('#supTable').parents('div.dataTables_wrapper').first().hide();
	  mainTable = $("#mainTable").dataTable();
	  supTable =  $("#supTable").dataTable();
	  $.fn.dataTable.ext.search.push(studentTypeFilter);
	  $.fn.dataTable.ext.search.push(nonCurrentStudentFilter);
	  showStudentTable();
    }
  }

  req.open('POST', 'AllDB.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  req.send();
}

function showStudentTable() {
  isSupervisor = false;
  showNonCurrentStudents = false;
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  $('#mainTable').parents('div.dataTables_wrapper').first().show();
  refreshTable();
}

function showNonCurrentStudents(){
  isSupervisor = false;
  showNonCurrentStudents = true;
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  $('#mainTable').parents('div.dataTables_wrapper').first().show();
  refreshTable();
}
/**



function showProvisional() {
}

function showSupervisor() {
}

function showSuspensions() {
}
*/
function changeStudentfilter(value){
	type = value;
	refreshTable();
}

function refreshTable() {
  
  mainTable.api().columns().visible(true);
  while ($.fn.dataTable.ext.search.length > 2){
		$.fn.dataTable.ext.search.pop();
	}

  mainTable.api().columns(":contains('Withdrawn')").visible(false);
  if (type === "Masters") {
     mainTable.api().columns(":contains('Type'), :contains('Proposal Seminar'), :contains('Work Hours')").visible(false);
  }
  else if (type === "PhD") {
   mainTable.api().columns(":contains('Type'), :contains('3 Month'), :contains('8 Month')").visible(false);
  }
  redraw();
}

//Kill type for both

//To kill for masters
//echo "<th> 3 Month Report Deadline </th>";
//echo "<th> 3 Month Report Submission </th>";
//echo "<th> 3 Month Report Approval </th>";
//echo "<th> 8 Month Report Deadline </th>";
//echo "<th> 8 Month Report Submission </th>";
//echo "<th> 8 Month Report Approval </th>";

function redraw() {
  mainTable.fnDraw();
  supTable.fnDraw();
}

function showOverdue(){
	showStudentTable();
	$.fn.dataTable.ext.search.push(function ( oSettings, aData, iDataIndex ) {
		var currentDate = Date.now();
		if (aData[14] != "" && aData[15] == "") { /*Deadline date is not empty, Deadline submission is empty (Proposal)*/
			var propDate = new Date(aData[14]);
			if(propDate < currentDate){
				return true;
			}
		}
		if (aData[18] != "" & aData[19] == ""){
			var mon3Date = new Date(aData[18]);
			if(mon3Date < currentDate){
				return true;
			}
		}
		if (aData[21] != "" & aData[22] == ""){
			var mon8Date = new Date(aData[21]);
			if(mon8Date < currentDate){
				return true;
			}
		}
		if (aData[24] != "" & aData[25] == ""){
			var subDate = new Date(aData[24]);
			if(subDate < currentDate){
				return true;
			}
		}
		return false;
	});
	
	mainTable.api().columns(":contains('Scholarship'), :contains('Work Hours'), :contains('Supervisor'), " +
							":contains('Date'), :contains('Seminar'), :contains('Confirmation'), :contains('Approval'), " +
							":contains('Exam'), :contains('Revisions'), :contains('Deposited'), :contains('Origin')").visible(false);
	redraw();
}

function showUnassessed() {
	showStudentTable();
	$.fn.dataTable.ext.search.push(function ( oSettings, aData, iDataIndex ) {
	
		if (aData[15] != "" && aData[17] == "") {
			return true;
		}
		if (aData[19] != "" && aData[20] == ""){
			return true;
		}
		if (aData[22] != "" && aData[23] == ""){
			return true;
		}
		if (aData[25] != "" && aData[27] == ""){
			return true;
		}
		return false;
	});
	mainTable.api().columns(":contains('Scholarship'), :contains('Work Hours'), :contains('Supervisor'), " +
							":contains('Date'), :contains('Seminar'), :contains('Deadline'), :contains('Examiners'), " +
							":contains('Revisions'), :contains('Deposited'), :contains('Origin')").visible(false);
	redraw();
}

function showSupervisor() {
  isSupervisor = true;
  refreshTable();
  $('#mainTable').parent('div.dataTables_wrapper').first().hide();
  $('#supTable').parent('div.dataTables_wrapper').first().show();
}

function showProvisional() {
  showStudentTable();
  $.fn.dataTable.ext.search.push(provisionalFilter);
  redraw();
}

function provisionalFilter( oSettings, aData, iDataIndex ) {
  if (aData[17] === "") {
    return true;
  }
  return false;
}

function showSuspensions(){
  showStudentTable();
  $.fn.dataTable.ext.search.push(suspensionsFilter);
  redraw();
}

function suspensionsFilter(oSettings, aData, iDataIndex){
  var str = aData[12];
  if(str !== undefined && str != ""){
     var today = new Date();
     var dashIndex = str.lastIndexOf(' - ');
     var newLineIndex = str.lastIndexOf('\\n');
     
     var startDateString = ((newLineIndex === -1) ? str.substr(0, dashIndex) : str.substr(newLineIndex+1, dashIndex)).split("-");
     var endDateString = (str.substr(dashIndex+1)).split("-");
     
     var start = new Date(startDateString);
     var end = new Date(endDateString);
     if (start < today && today < end)
       return true;
  }
  return false;
}

function showWorkHours(){
  showStudentTable();
  $.fn.dataTable.ext.search.push(workHoursFilter);
  redraw();
}

function workHoursFilter( oSettings, aData, iDataIndex ) {
  var workHours1 = parseInt(aData[7]);
  var workHours2 = parseInt(aData[8]);
  var workHours3 = parseInt(aData[9]);
  var totalHours = workHours1 + workHours2 + workHours3;
  
  if(totalHours < 450){
     return true;
  }
  return false;
}