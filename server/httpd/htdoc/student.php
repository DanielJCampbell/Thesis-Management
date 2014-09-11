<!DOCTYPE html >
<html>
<head>
<link rel="stylesheet" type="text/css" href="thesisManagement.css">

	<title> Timeline</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
var type = "All";
var filter = "all";

function sendPHPRequest(studentID) {
var req = new XMLHttpRequest();

req.onreadystatechange=function() {
	if (req.readyState==4 && req.status==200) {
	document.getElementById("Tables").innerHTML=req.responseText;
	}
}

req.open('POST', 'StudentDB.php', true);
req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
if (filter === "students")
	req.send("filter=students&type="+type+"&studentID="+studentID);
else if (filter === "student")
	req.send("filter=student&type="+type+"&studentID="+studentID);
else
	req.send("filter="+filter+"&type="+type);
}
window.onload = function(){
filter = "student";
sendPHPRequest(sessionStorage.getItem("name"));
}

</script>
</head>
<body>
	<h1> MASTER'S STUDENT TIMELINE</h1>
	<div id = "Tables">
	</div>
</body>
</html>
