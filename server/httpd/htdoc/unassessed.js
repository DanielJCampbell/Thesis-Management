function showUnassessed() {
//proposal confirmation
//report 
//examination 
//submitted to library
	$.fn.dataTable.ext.search.push(function ( oSettings, aData, iDataIndex ) {
	
		if (aData[15] != "" && aData[17] == "") {
			return true;
		}
		if (aData[19] != "" && aData[20] == ""){
			return true;
		}
		if (aData[22] != "" && aData[23] == ""){
			return true;
		}
		if (aData[25] != "" && aData[27] == ""){
			return true;
		}
		return false;
		);
	}
} 
