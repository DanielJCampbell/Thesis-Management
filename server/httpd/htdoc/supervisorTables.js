;

function showSupervisor() {
		$('#mainTable').parent('div.dataTables_wrapper').first().hide();
		$('#supTable').parent('div.dataTables_wrapper').first().show();
}

function showProvisional() {

  $.fn.dataTable.ext.search.push(provisionalFilter);

}

function provisionalFilter( oSettings, aData, iDataIndex ) {
  if (aData[17] === "") {
    return true;
  }
  return false;
}

function showSuspensions(){
  $.fn.dataTable.ext.search.push(suspensionsFilter);
}

function suspensionsFilter(oSettings, aData, iDataIndex){
  var str = aData[12];
  if(str !== undefined && str != ""){
     var today = new Date();
     var dashIndex = str.lastIndexOf(' - ');
     var newLineIndex = str.lastIndexOf('\\n');
     
     var startDateString = ((newLineIndex === -1) ? str.substr(0, dashIndex) : str.substr(newLineIndex+1, dashIndex)).split("-");
     var endDateString = (str.substr(dashIndex+1)).split("-");
     
     var start = new Date(startDateString[0], startDateString[1], startDateString[2]);
     var end = new Date(endDateString[0], endDateString[1], endDateString[2]);
     if (start < today && today < end)
       return true;
  }
  return false;
}

function showWorkHours(){
  $.fn.dataTable.ext.search.push(workHoursFilter);
}

function workHoursFilter( oSettings, aData, iDataIndex ) {
  // if(aData[
  return true;
}