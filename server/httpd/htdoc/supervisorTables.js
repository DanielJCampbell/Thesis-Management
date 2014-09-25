;

function showSupervisor() {
  isSupervisor = true;
  refreshTable();
  $('#mainTable').parent('div.dataTables_wrapper').first().hide();
  $('#supTable').parent('div.dataTables_wrapper').first().show();
}

function showProvisional() {
  showStudentTable();
  $.fn.dataTable.ext.search.push(provisionalFilter);
  redraw();
}

function provisionalFilter( oSettings, aData, iDataIndex ) {
  if (aData[17] === "") {
    return true;
  }
  return false;
}

function showSuspensions(){
  showStudentTable();
  $.fn.dataTable.ext.search.push(suspensionsFilter);
  redraw();
}

function suspensionsFilter(oSettings, aData, iDataIndex){
  var str = aData[12];
  if(str !== undefined && str != ""){
     var today = new Date();
     var dashIndex = str.lastIndexOf(' - ');
     var newLineIndex = str.lastIndexOf('\\n');
     
     var startDateString = ((newLineIndex === -1) ? str.substr(0, dashIndex) : str.substr(newLineIndex+1, dashIndex)).split("-");
     var endDateString = (str.substr(dashIndex+1)).split("-");
     
     var start = new Date(startDateString);
     var end = new Date(endDateString);
     if (start < today && today < end)
       return true;
  }
  return false;
}

function showWorkHours(){
  showStudentTable();
  $.fn.dataTable.ext.search.push(workHoursFilter);
  redraw();
}

function workHoursFilter( oSettings, aData, iDataIndex ) {
  var workHours1 = parseInt(aData[7]);
  var workHours2 = parseInt(aData[8]);
  var workHours3 = parseInt(aData[9]);
  var totalHours = workHours1 + workHours2 + workHours3;
  
  if(totalHours < 450){
     return true;
  }
  return false;
}