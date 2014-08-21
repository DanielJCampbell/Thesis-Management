
function verify() {
  var name = document.getElementById("un").value;
  var password = document.getElementById("p").value;

  //var href = location.href;    DO THIS IF HOSTED ONLINE
  var href = location.href.substring(0, location.href.lastIndexOf("/"));

  	if (password !== "password"){
 		return;
	}
  
  	if (name === "supervisor"){
    	//href += "/supervisor";
    	href += "/supervisor.php";
  	}else if (name === "coordinator"){
      	//href += "/coordinator";
      	href += "/coordinator.php";
  	}else if (name === "admin"){
      	//href += "/admin";
      	href += "/admin.php";
  	}else if (name.length == 9){
      	//href += "/student";
		sessionStorage.setItem("name", name);
      	href += "/student.php";
	}else{
      return;
	}
  location.href = href;
}
