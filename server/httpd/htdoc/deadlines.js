function calcDeadlines(calcFrom){
	var inputDateString = document.getElementById(calcFrom).value;
	var inputDate = new Date(inputDateString);
	var partTimeStatus = document.getElementById("partTimeStatus").value;
	var studentType = document.getelementByID("type").value;
	var inputMonth = inputDate.getMonth();
	var partTimeModifier = 1;
	if (partTimeStatus === "partTime"){
		partTimeModifier = 2;
	}

	switch (calcFrom){
	case "startDate":
		var month3Month = inputMonth+(3*partTimeModifier);
		if (studentType === "masters"){
			var month3Date = new Date(inputDateString);
			month3Date.setMonth(month3Month);
			console.Log(month3Date);
			//set 3 month report value to = month3;
		}
	case "month3Date":
		var month8 = month3Month+5;

	}
}
