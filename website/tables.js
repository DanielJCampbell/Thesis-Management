;

function changeFilter(value) {
    if (value === "PhD") {
      document.getElementById(value).setAttribute("class", "active");
      document.getElementById("Masters").setAttribute("class", "passive");
    }
    else if (value === "Masters") {
      document.getElementById(value).setAttribute("class", "active");
      document.getElementById("PhD").setAttribute("class", "passive");
    }
}


