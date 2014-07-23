
function verify() {
  var name = document.getElementById("un").value;
  var password = document.getElementById("p").value;

  //var href = location.href;    DO THIS IF HOSTED ONLINE
  var href = location.href.substring(0, location.href.lastIndexOf("/"));

  if (password !== "password") return;
  
  if (name === "supervisor")
      //href += "/supervisor";
      href += "/supervisor.html";
  else if (name === "coordinator")
      //href += "/coordinator";
      href += "/coordinator.html";
  else if (name === "admin")
      //href += "/admin";
      href += "/admin.html";
  else if (name === "student")
      //href += "/student";
      href += "/student.html";
  else
      return;

  location.href = href;
}