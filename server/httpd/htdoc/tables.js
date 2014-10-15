;
var mainTable;
var supTable;

//Only shows students meeting the current type (Masters, PhD, or All)
function studentTypeFilter( oSettings, aData, iDataIndex ) {
  if (aData[3] === type || isSupervisor || type === "All") {
    return true;
  }
  return false;
}

//Shows/hides students who are finished (deposited in library) or withdrawn
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

//Called on window load - creates the datatable objects from the table generated from AllDB.php
function sendPHPRequest() {
  var req = new XMLHttpRequest();
	var tableheight = screen.availHeight/2;
	tableheight = tableheight.toString().concat("px");
  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
	  $('#supTable').parents('div.dataTables_wrapper').first().hide();
	  mainTable = $("#mainTable").dataTable({"autoWidth":false, "scrollX":true, "scrollY":tableheight,scrollCollapse:true,paging:false});
	  supTable =  $("#supTable").dataTable();

	  var colvis = new $.fn.dataTable.ColVis( mainTable, {exclude: [0] } );
		$( colvis.button() ).insertAfter('div#last');
	  $.fn.dataTable.ext.search.push(studentTypeFilter);
	  $.fn.dataTable.ext.search.push(nonCurrentStudentFilter);

	  //If you click the edit column, will open a child row containing the edit form
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

//Shows the student datatable, hides the supervisor datatable
function showStudentTable() {
  isSupervisor = false;
  showNonCurrentStudents = false;
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  $('#mainTable_wrapper').show();
  refreshTable();
}

//Shows only withdrawn students, and shows the withdrawn column
function showNonCurrent(){
  isSupervisor = false;
  showNonCurrentStudents = true;
  $('#supTable').parents('div.dataTables_wrapper').first().hide();
  $('#mainTable_wrapper').show();
  refreshTable();
  mainTable.api().columns(":contains('Withdrawn')").visible(true);
}

//Changes what type of students are visible (PhD, Masters or All)
function changeStudentfilter(value){
	type = value;
	refreshTable();
}

//Resets the filters and columns of the main table to defaults
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

//Redraws the tables (necessary when using filters)
function redraw() {
  mainTable.fnDraw();
  supTable.fnDraw();
}

//Show only students who are past their deadlines and haven't submitted, for any deadline
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

//Shows only students that have submitted something and haven't had it confirmed yet
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

//Shows the supervisor table, hides the student table
function showSupervisor() {
  isSupervisor = true;
  refreshTable();
  $('#mainTable_wrapper').hide();
  $('#supTable').parent('div.dataTables_wrapper').first().show();
}

//Shows students who have not yet had their proposals confirmed
function showProvisional() {
  showStudentTable();
  $.fn.dataTable.ext.search.push(provisionalFilter);
  redraw();
}

//Filter for provisional students
function provisionalFilter( oSettings, aData, iDataIndex ) {
  if (aData[18] === "") {
    return true;
  }
  return false;
}

//Show only students currently suspended
function showSuspensions(){
  showStudentTable();
  $.fn.dataTable.ext.search.push(suspensionsFilter);
  redraw();
}

//Checks through most recent suspension for any student, checking if the current date is within it
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

//Shows students running behind on their work hours
function showWorkHours(){
  showStudentTable();
  $.fn.dataTable.ext.search.push(workHoursFilter);
  redraw();
}

//Returns all students who have not met their work hour requirements
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

//Reads a parent row, creates from it a child row containing an edit form, with all fields initialised to correct values
//Note you can only delete a withdrawn student
//Note due to an oddity of the code, supervisor IDs must be manually input
function format(data) {

	var typeString = (data[3] === "Masters") ?  "<option value = 'PhD'>PhD</option> <option value = 'Masters' selected = 'selected'>Masters</option>"
			: "<option value = 'PhD' selected = 'selected'>PhD</option> <option value = 'Masters'>Masters</option>";

	var partTimeString = (data[6] === "Yes") ? "<input type='radio' name='pt' value='H' checked> Yes </input> <input type='radio' name='pt' value='F'> No </input>"
			: "<input type='radio' name='pt' value='H'> Yes </input> <input type='radio' name='pt' value='F' checked> No </input>";

	var workHourString = (data[3] === "Masters") ? ""
			: "<tr> <td> Work Hours Year 1: </td> <td> <input type = 'number' name = 'WorkY1' id = 'WorkY1' min = '0' max = '150' value = '" + data[8]  + "'</td> </tr>"
			+ "<tr> <td> Work Hours Year 2: </td> <td> <input type = 'number' name = 'WorkY2' id = 'WorkY2' min = '0' max = '150' value = '" + data[9]  + "'</td> </tr>"
			+ "<tr> <td> Work Hours Year 3: </td> <td> <input type = 'number' name = 'WorkY3' id = 'WorkY3' min = '0' max = '150' value = '" + data[10] + "'</td> </tr>";

	var seminarString = (data[3] === "Masters") ? ""
			: "<tr> <td> Proposal Seminar: </td> <td> <input type = 'date' name = 'proposalSeminar' id = 'proposalSeminar' value = '" + data[17] + "' </td></tr>";

	var reportString = (data[3] === "Masters") ?
			"<tr> <td> 3 Month Report Submission: </td> <td> <input type = 'date' id = '3MonthSubmission' name = '3MonthSubmission' value = '" + data[20] + "'</td></tr>"
				+ "<tr> <td> 3 Month Report Approval: </td> <td> <input type = 'date' id = '3MonthApproval' name = '3MonthApproval' value = '" + data[21] + "'</td></tr>"
			+ "<tr> <td> 8 Month Report Submission: </td> <td> <input type = 'date' id = '8MonthSubmission' name = '8MonthSubmission' value = '" + data[23] + "'</td></tr>"
				+ "<tr> <td> 8 Month Report Approval: </td> <td> <input type = 'date' id = '8MonthApproval' name = '8MonthApproval' value = '" + data[24] + "'</td></tr>"
			: "";

	var originString = (data[32] === "D") ?  "<option value = 'D' selected = 'selected'>Domestic</option> <option value = 'I'>International</option>"
			: "<option value = 'D'>Domestic</option> <option value = 'I' selected = 'selected'>International</option>";

	var withdrawnString = (data[33] === "True") ?  "<option value = 'True' selected = 'selected'>True</option> <option value = 'False'>False</option>"
			: "<option value = 'True' >True</option> <option value = 'False' selected = 'selected'>False</option>";

	var oldPTString = (data[6] === "Yes") ? 'H' : 'F';

	var killString = (data[33] === 'True') ? '<form method = "post"> <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
			+ "<tr><td><input type = 'hidden' name = 'sID' value = '"+data[2]+"'/><button type = 'submit' id = 'deleteInline' name = 'Delete' value = 'Delete'>Delete Student</button></td></tr>"
			+ "</table></form>" : '' ;

	return '<form method = "post"> <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
	+ "<tr> <td> Editing Student With Id: </td> <td class = 'accessed'> <input type = 'text' class = 'sID' name = 'sID' readonly value = '"+data[2]+"'/></td></tr>"
	+ "<tr> <td> First Name: </td> <td> <input type = 'text' required id = 'fname' name = 'fname' value = '"+data[1].split(" ")[0]+"'/></td></tr>"
	+ "<tr> <td> Last Name: </td> <td> <input type = 'text' required id = 'lname' name = 'lname' value = '"+data[1].split(" ")[1]+"'/></td></tr>"
	+ "<tr> <td> Type: </td> <td> <select id = 'type' name = 'type'>"
	+ typeString + "</select></td></tr>"
	+ "<tr> <td> Course: </td> <td> <input type='text' required id='course' name='course' value = '"+data[4]+"'/></td></tr>"
	+ "<tr> <td> Specialisation: </td> <td> <input type='text' required id='specialisation' name='specialisation' value = '"+data[5]+"'/></td></tr>"
	+ "<tr> <td> Part-Time: </td> <td> " + partTimeString + "</td> </tr>"
	+ "<tr> <td> <input type = 'hidden' name = 'oldPT' value = '" + oldPTString + "'/></td> </tr>"
	+ "<tr> <td> Scholarship: </td> <td> <input type='text' id='scholarship' name='scholarship' value = '"+data[7]+"'/></tr>"
	+ workHourString
	+ "<tr> <td> Primary Supervisor: </td> <td class = 'accessed'> <input type = 'number' required id = 'pSupervisor' class = 'pSupervisor' name = 'pSupervisor' placeholder = '80000000'/></td>"
		+ "<td> Percentage: </td> <td> <input type = 'number' required min = '51' max = '99' id = 'pPercentage' name = 'pPercentage' value = '" + data[11].split(" (")[1].slice(0, -2) + "'/></td></tr>"
	+ "<tr> <td> Secondary Supervisor: </td> <td class = 'accessed'> <input type = 'number' required id = 'sSupervisor' class = 'sSupervisor' name = 'sSupervisor' placeholder = '80000000'/></td>"
		+ "<td> Percentage: </td> <td> <input type = 'number' min = '1' required max = '49' id = 'sPercentage' name = 'sPercentage' value = '" + data[12].split(" (")[1].slice(0, -2) + "'/></td></tr>"
	+ "<tr> <td> <input type = 'hidden' name = 'suspensions' value = '" + data[13] + "' /></td></tr>"
	+ "<tr> <td> Add New Suspension: </td> <td> Start Date <input type = 'date' name = 'suspensionStart' id = 'suspensionStart' placeholder = 'yyyy-mm-dd'/></td> "
		+ "<td> End Date <input type = 'date' name = 'suspensionEnd' id = 'suspensionEnd' placeholder = 'yyyy-mm-dd'/></td></tr>"
	+ "<tr> <td> Start Date: </td> <td> <input type = 'date' required id = 'startDate' name = 'startDate' value = '"+data[14]+"'/></td></tr>"
	+ "<tr> <td> Proposal Submission: </td> <td> <input type = 'date' id = 'proposalSubmission' name = 'proposalSubmission' value = '"+data[16]+"'/></td></tr>"
	+ seminarString
	+ "<tr> <td> Proposal Confirmation: </td> <td> <input type = 'date' id = 'proposalConfirmation' name = 'proposalConfirmation' value = '"+data[18]+"'/></td></tr>"
	+ reportString
	+ "<tr> <td> Thesis Submission: </td> <td> <input type = 'date' id = 'thesisSubmission' name = 'thesisSubmission' value = '"+data[26]+"'/></td></tr>"
	+ "<tr> <td> Examiners Appointed: </td> <td> <input type = 'date' id = 'examinersAppointed' name = 'examinersAppointed' value = '"+data[27]+"'/></td></tr>"
	+ "<tr> <td> Examination Completed: </td> <td> <input type = 'date' id = 'examinationCompleted' name = 'examinationCompleted' value = '"+data[28]+"'/></td></tr>"
	+ "<tr> <td> Revisions Finalised: </td> <td> <input type = 'date' id = 'revisionsFinalised' name = 'revisionsFinalised' value = '"+data[29]+"'/></td></tr>"
	+ "<tr> <td> Deposited In Library: </td> <td> <input type = 'date' id = 'deposited' name = 'deposited' value = '"+data[30]+"'/></td></tr>"
	+ "<tr> <td> Notes: </td> <td> <input type = 'text' id = 'notes' name = 'notes' value = '"+data[31] +"'/></td></tr>"
	+ "<tr> <td> Origin: </td> <td> <select name = 'origin' id = 'origin'>"
	+ originString + "</select></td></tr>"
	+ "<tr> <td> Withdrawn: </td> <td> <select name = 'withdrawn' id = 'withdrawn'>"
	+ withdrawnString + "</select></td></tr>"
	+ "<tr> <td> <button type = 'submit' id = 'editInline' name = 'Edit' value = 'Edit'>Edit Student</button></td></tr>"
	+ "</table> </form>"
	+ killString;
}

//Unused, designed to be called if an edit query failed
function failChange(error) {
	alert(error);
}

//Never used due to calling method being broken
function getStudentSupervisor(studentID, pSupervisor, sSupervisor) {
	var req = new XMLHttpRequest();

	req.onreadystatechange = function() {
		if (req.readyState == 4 && req.status == 200) {
			var result = req.responseText;
			result = result.split(" ");
			result[0] = parseInt(result[0]);
			result[1] = parseInt(result[1]);
			pSupervisor.value = result[0];
			sSupervisor.value = result[1];
		};
	};
	var toSend = "sID =" + studentID;
	req.open('POST', 'getSupervisor.php', true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-length", toSend.length);
	req.send(toSend);
}
