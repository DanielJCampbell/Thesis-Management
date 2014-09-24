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