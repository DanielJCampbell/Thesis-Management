;

window.onload = sendPHPRequest();

function sendPHPRequest() {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
	  $("#mainTable").dataTable();
	  $("#supTable").dataTable();
    }
  }

  req.open('POST', 'AllDB.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  req.send();
}

function showStudents(superID){
}

function showAll() {
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
  if (value === "All") {
     $("#mainTable").columns().visible(true);
  }
  else if (value === "Masters") {
    //$("#mainTable").columns(
  }
  else if (value === "PhD") {
     //$("#mainTable").columns().visible(true);
  }
  
//Kill type for both
  
//To kill for masters
//echo "<th> 3 Month Report Deadline </th>";
//echo "<th> 3 Month Report Submission </th>";
//echo "<th> 3 Month Report Approval </th>";
//echo "<th> 8 Month Report Deadline </th>";
//echo "<th> 8 Month Report Submission </th>";
//echo "<th> 8 Month Report Approval </th>";

//To kill for PhD
/*
echo "<th> Proposal Seminar </th>";
echo "<th> Work Hours Year 1 </th>";
echo "<th> Work Hours Year 2 </th>";
echo "<th> Work Hours Year 3 </th>";
*/
}