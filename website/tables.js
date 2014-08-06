;

function changeFilter(value) {
    if (value === "PhD") {
      document.getElementById(value).class = "active";
      document.getElementById("edit"+value).class = "active";
      document.getElementById("Masters").class = "passive";
      document.getElementById("editMasters").class = "passive";
    }
    else if (value === "Masters") {
      document.getElementById(value).class = "passive";
      document.getElementById("edit"+value).class = "passive";
      document.getElementById("Masters").class = "active";
      document.getElementById("editMasters").class = "active";
    }
}


