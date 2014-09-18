;
var type = "All";
var filter = "all";
var supervisorID = "null";

function changeFilter(value) {
    type = value;
    sendPHPRequest();
}

function sendPHPRequest() {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
	  $("#mainTable").dataTable();
	  $("#supTable").dataTable()
    }
  }

  req.open('POST', 'AllDB.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  req.send();
  //if (filter === "students")
  //  req.send("filter=students&type="+type+"&supervisorID="+supervisorID);
  //else
  //  req.send("filter="+filter+"&type="+type);
}

function showStudents(superID){
    filter = "students";
    supervisorID = superID
    sendPHPRequest();
}

function showAll() {
  filter = "all";
  sendPHPRequest();
}

function deadlines() {
  filter = "deadlines";
  sendPHPRequest();
}

function showUnassessed() {
  filter = "unassessed";
  sendPHPRequest();
}

function showProvisional() {
  filter = "provisional";
  sendPHPRequest();
}

function showSupervisor() {
  filter = "supervisors";
  sendPHPRequest();
}

function showSuspensions() {
	filter = "suspensions";
	sendPHPRequest();
}
