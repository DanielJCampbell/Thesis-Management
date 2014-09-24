;

function showSupervisor() {
		$('#mainTable').parent('div.dataTables_wrapper').first().hide();
		$('#supTable').parent('div.dataTables_wrapper').first().show();
}

function showProvisional() {

  $('#mainTable').DataTable({
	  "iFilterCol_0": 14,
	  "iFilterVal_0": null,
	  "iFilterCondition": "!="
	});

}