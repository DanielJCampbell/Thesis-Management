<!DOCTYPE html >
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="thesisManagement.css">
    <title> Timeline</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script>
var type = "All";
var method = "all";

function doMethod(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'StudentDB.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  if (method === "students")
    req.send("method=students&type="+type+"&id="+id);
  else if (method === "student")
	req.send("method=student&type="+type+"&id="+id);
  else
    req.send("method="+method+"&type="+type);
}
window.onload = function(){
  method = "student";
  doMethod(300000002);
}

</script>
  </head>
  <body>
    <h1> MASTER'S STUDENT TIMELINE</h1>
    <div id = "Tables"></div>
  </body>
</html>
