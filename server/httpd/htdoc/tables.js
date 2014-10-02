;
var mainTable;
var supTable;

function studentTypeFilter( oSettings, aData, iDataIndex ) {
  if (aData[3] === type || isSupervisor || type === "All") {
    return true;
  }
  return false;
}

function nonCurrentStudentFilter(oSettings, aData, iDataIndex){
	if (isSupervisor) {return true;}
	if (aData[14] == "" || aData[30] != "" || aData[33] == "True"){
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
	  mainTable = $("#mainTable").dataTable({"autoWidth":false});
	  supTable =  $("#supTable").dataTable();
	  var colvis = new $.fn.dataTable.ColVis( mainTable );
		$( colvis.button() ).insertAfter('div#body');
	  $.fn.dataTable.ext.search.push(studentTypeFilter);
	  $.fn.dataTable.ext.search.push(nonCurrentStudentFilter);
	  $("#mainTable").on('click', 'td.editTD', function () {
		  var tr = $(this).closest('tr');
	      var row = mainTable.api().row( tr );
	      if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
	      }
	      else {
			// Open this row
			row.child(format(row.data())).show();
			tr.addClass('shown');
	      }
		});
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

function showNonCurrent(){
  isSupervisor = false;
  showNonCurrentStudents = true;
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  $('#mainTable').parents('div.dataTables_wrapper').first().show();
  refreshTable();
  mainTable.api().columns(":contains('Withdrawn')").visible(true);
}

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
  mainTable.addClass('cell-border');
  mainTable.addClass('display');
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
		if (aData[15] != "" && aData[16] == "") { /*Deadline date is not empty, Deadline submission is empty (Proposal)*/
			var propDate = new Date(aData[15]);
			if(propDate < currentDate){
				return true;
			}
		}
		if (aData[19] != "" & aData[20] == ""){
			var mon3Date = new Date(aData[19]);
			if(mon3Date < currentDate){
				return true;
			}
		}
		if (aData[22] != "" & aData[23] == ""){
			var mon8Date = new Date(aData[22]);
			if(mon8Date < currentDate){
				return true;
			}
		}
		if (aData[25] != "" & aData[26] == ""){
			var subDate = new Date(aData[25]);
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

		if (aData[16] != "" && aData[18] == "") {
			return true;
		}
		if (aData[20] != "" && aData[21] == ""){
			return true;
		}
		if (aData[23] != "" && aData[24] == ""){
			return true;
		}
		if (aData[26] != "" && aData[28] == ""){
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
  if (aData[18] === "") {
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
  var str = aData[13];
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

function format(data) {
//	return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
//	+ "<tr> <th> First Name </th> <th> Last Name </th> <th> ID </th> <th> Type </th> <th> Course </th>"
//	+ "<th> Specialisation </th> <th> Part-Time </th> <th> Scholarship </th> <th> Work Hours Year 1 </th>"
//	+ "<th> Work Hours Year 2 </th> <th> Work Hours Year 3 </th> <th> Primary Supervisor </th> <th> Secondary Supervisor </th>"
//	+ "<th> Suspension Dates </th> <th> Start Date </th> <th> Proposal Deadline </th> <th> Proposal Submission </th> <th> Proposal Seminar </th>"
//	+ "<th> Proposal Confirmation </th> <th> 3 Month Report Deadline </th> <th> 3Month Report Submission </th> <th>3 Month Report Approval</th>"
//	+ "<th> 8 Month Deadline </th> <th> 8 Month Submission </th> <th> 8 Month Approval </th> <th> Thesis Deadline </th> <th>Thesis Submission </th>"
//	+ "<th> Examiners Appointed </th> <th> Examination Completed </th> <th> Revisions Finalised </th> <th> Deposited In Library </th>"
//	+ "<th> Notes </th> <th> Origin </th> <th> Withdrawn </th> </tr> </table>";

	var typeString = (data[3] === "Masters") ?  "<option value = 'PhD'>PhD</option> <option value = 'Masters' selected = 'selected'>Masters</option>"
			: "<option value = 'PhD' selected = 'selected'>PhD</option> <option value = 'Masters'>Masters</option>";

	var partTimeString = (data[6] === "Yes") ? "<input type='radio' name='pt' value='Yes' checked/> <input type='radio' name='pt' value='No'/>"
			: "<input type='radio' name='pt' value='Yes'/> <input type='radio' name='pt' value='No' checked/>";

	var workHourString = (data[3] === "Masters") ? ""
			: "<tr> <td> Work Hours Year 1 </td> <td> <input type = 'number' name = 'WorkY1' id = 'WorkY1' min = '0' max = '150' value = '" + data[8]  + "'</td> </tr>"
			+ "<tr> <td> Work Hours Year 2 </td> <td> <input type = 'number' name = 'WorkY2' id = 'WorkY2' min = '0' max = '150' value = '" + data[9]  + "'</td> </tr>"
			+ "<tr> <td> Work Hours Year 3 </td> <td> <input type = 'number' name = 'WorkY3' id = 'WorkY3' min = '0' max = '150' value = '" + data[10] + "'</td> </tr>";

	var pPercent = data[11].indexOf("(");
	pPercent = data[11].substr(pPercent+1, -2);

	return '<form method = "post"> <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
	+ "<tr> <td> First Name: </td> <td> <input type = 'text' id = 'fname' value = '"+data[1].split(" ")[0]+"'/></td></tr>"
	+ "<tr> <td> Last Name: </td> <td> <input type = 'text' id = 'lname'  value = '"+data[1].split(" ")[1]+"'/></td></tr>"
	+ "<tr> <td> Student ID: </td> <td> <input type = 'number' id = 'sID'  value = '"+data[2]+"'/></td></tr>"
	+ "<tr> <td> Type: </td> <td> <select id = 'type'>"
	+ typeString + "</select></td></tr>"
	+ "<tr> <td> Course: </td> <td> <input type='text' id='course' name='course' value = '"+data[4]+"'/></td></tr>"
	+ "<tr> <td> Specialisation: </td> <td> <input type='text' id='specialisation' name='specialisation' value = '"+data[5]+"'/></td></tr>"
	+ "<tr> <td> Part-Time: </td> <td> " + partTimeString + "</td> </tr>"
	+ "<tr> <td> Scholarship: </td> <td> <input type='text' id='scholarship' name='scholarship' value = '"+data[7]+"'/></tr>"
	+ workHourString
	+ "<tr> <td> Debug value of primary percentage: " + pPercent + "</td></tr>"
	+ "<tr> <td> Primary Supervisor: </td> <td> <input type = 'text' id = 'pSupervisor' name = 'pSupervisor' value = '" + data[11].split(" (")[0] + "'/></td>"
		+ "<td> Percentage: </td> <td> <input type = 'number' min = '51' max = '99' id = 'pPercentage' name = 'pPercentage' value = '" + data[11].split(" (")[1].substr(0, -2) + "'/></td></tr>"
		+ "<tr> <td> Secondary Supervisor: </td> <td> <input type = 'text' id = 'sSupervisor' name = 'sSupervisor' value = '" + data[12].split(" (")[0] + "'/></td>"
		+ "<td> Percentage: </td> <td> <input type = 'number' min = '0' max = '49' id = 'sPercentage' name = 'sPercentage' value = '" + data[12].split(" (")[1].substr(0, -2) + "'/></td></tr>"
	+ "</table> </form>";
}
