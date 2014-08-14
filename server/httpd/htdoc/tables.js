;
var type = "All";
var method = "all";

function changeFilter(value) {
    type = value;
    doMethod();
}

function doMethod(id) {
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php', true);
  req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  if (method === "students")
    req.send("method=students&type="+type+"&id="+id);
  else
    req.send("method="+method+"&type="+type);
}

function showStudents(id){
    method = "students";
    doMethod(id);
}

function showAll() {
  method = "all";
  doMethod();
}

function deadlines() {
  method = "deadlines";
  doMethod();
}

function showUnassessed() {
  method = "unassessed";
  doMethod();
}

function showProvisional() {
  method = "provisional";
  doMethod();
}

function showSupervisor() {
  method = "supervisors";
  doMethod();
}


