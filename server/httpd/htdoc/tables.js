;

function changeFilter(value) {
    if (value === "PhD") {
      document.getElementById(value).setAttribute("class", "active");
      document.getElementById("Masters").setAttribute("class", "passive");
      document.getElementById("All").setAttribute("class", "passive");
    }
    else if (value === "Masters") {
      document.getElementById(value).setAttribute("class", "active");
      document.getElementById("PhD").setAttribute("class", "passive");
      document.getElementById("All").setAttribute("class", "passive");
    }
    else if(value === "All"){
      document.getElementById(value).setAttribute("class", "active");
      document.getElementById("PhD").setAttribute("class", "passive");
      document.getElementById("Masters").setAttribute("class", "passive");
    }
}

function showStudents(id){
    var type = findType();
    var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php?type=' + type + '&method=students' + '&id=' + id, true);
  req.send();
}

function showAll() {
  type = "All"
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php?type=' + type + '&method=all', true);
  req.send();
}

function deadlines() {
  var type = findType();
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php?type=' + type + '&method=deadlines', true);
  req.send();
}

function showUnassessed() {
  var type = findType();
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php?type=' + type + '&method=unassessed', true);
  req.send();
}

function showProvisional() {
  var type = findType();
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php?type=' + type + '&method=provisional', true);
  req.send();
}

function showSupervisor() {
  var type = findType();
  var req = new XMLHttpRequest();

  req.onreadystatechange=function() {
    if (req.readyState==4 && req.status==200) {
      document.getElementById("Tables").innerHTML=req.responseText;
    }
  }

  req.open('POST', 'filters.php?type=' + type + '&method=supervisors', true);
  req.send();
}

function findType() {
  if (document.getElementById("Masters").className === "active"){
      return "Masters";
  }
  else if (document.getElementById("PhD").className === "active"){
      return "PhD";
  }
  else if (document.getElementById("All").className === "active"){
      return "All";
  }
}


