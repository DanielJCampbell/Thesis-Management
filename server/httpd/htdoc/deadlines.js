function deadlines(){
	$.fn.dataTable.ext.search.push(function ( oSettings, aData, iDataIndex ) {
		var currentDate = Date.now();
		if (aData[14] != "" && aData[15] == "") { /*Deadline date is not empty, Deadline submission is empty (Proposal)*/
			var propDate = new Date(aData[14]);
			if(propDate < currentDate){
				return true;
			}
		}
		if (aData[18] != "" & aData[19] == ""){
			var mon3Date = new Date(aData[18]);
			if(mon3Date < currentDate){
				return true;
			}
		}
		if (aData[21] != "" & aData[22] == ""){
			var mon8Date = new Date(aData[21]);
			if(mon8Date < currentDate){
				return true;
			}
		}
		if (aData[24] != "" & aData[25] == ""){
			var subDate = new Date(aData[24]);
			if(subDate < currentDate){
				return true;
			}
		}
		return false;
	});
	
	mainTable.api().columns(":contains('Scholarship'), :contains('Work Hours'), :contains('Supervisor'), " +
							":contains('Date'), :contains('Seminar'), :contains('Confirmation'), :contains('Approval'), " +
							":contains('Exam'), :contains('Revisions'), :contains('Deposited'), :contains('Origin')").visible(false);
}