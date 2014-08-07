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
    
}


