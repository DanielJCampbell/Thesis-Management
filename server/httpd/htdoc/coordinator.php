<html>
  <head>
    <title>Coordinator</title>
    <link rel="stylesheet" type="text/css" href="dataTablesStyle.css">
    <link rel="stylesheet" type="text/css" href="staffPage.css">
	<link rel="stylesheet" type="text/css" href="https://datatables.net/release-datatables/extensions/ColVis/css/dataTables.colVis.css">
	<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://datatables.net/release-datatables/extensions/ColVis/js/dataTables.colVis.js"></script>
    <script src = "tables.js"></script>
    <div id = "image"> <img src="vuw-logo.png" style="height:75px"> </div>
    <h1> Thesis Management Staff Page</h1>
  </head>
  <div style="clear:both"></div>
  <body>
  <div id = "left">
	  <input type = "button" onclick = "showStudentTable();" value = "Clear filters"/><br/>
  	<input type = "button" onclick = "showWorkHours();" value = "Show Work Hours"/><br/>
  </div>
  <div id = "left">
	<input type = "button" onclick = "showProvisional();" value = "Show Provisional Students"/><br/>
	<input type = "button" onclick = "showUnassessed();" value = "Show Not Assessed"/><br/>
  </div>
  <div id = "left">
	<input type = "button" onclick = "showSuspensions();" value = "Show Suspended Students"/><br/>
	<input type = "button" onclick = "showOverdue();" value = "Show Overdue Students"/><br/>
  </div>
  <div id = "last">
  	<input type = "button" onclick = "showSupervisor();" value = "Show Supervisor Workload"/><br/>
  	<input type = "button" onclick = "showNonCurrent();" value = "Show Non-current Students"/><br/>
  </div>
  <div id = "body">


  <select id = "students" onchange = "changeStudentfilter(this.value)" selected = "All">
    <option selected disabled>Filter students by type</option>
    <option value = "All">All Students</option>
    <option value = "PhD">PhD Students</option>
    <option value = "Masters">Masters Students</option>
  </select>

  <div id = "Tables" width="80%">
  </div>
  </div>

  <?php

      $location = "ec2-54-83-204-104.compute-1.amazonaws.com";
      $username = "poacfvyhdhwtsx";
      $password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
      $database = "ddf40gpbvva8uo";

      $db = pg_connect("host=".$location." dbname=".$database." user=".$username." password=".$password);
      if($db->connect_errno > 0){
	    die('Unable to connect to database [' . $db->connect_error . ']');
      }
      if (! (empty ( $_POST ))) {

	      if(isSet($_POST['Edit'])){
			$f_name = htmlspecialchars($_POST['fname']);
			$l_name = htmlspecialchars($_POST['lname']);
			$type = htmlspecialchars($_POST['type']);

			$isPhD = ($type === 'PhD');

			$course = htmlspecialchars($_POST['course']);
			$specialisation = htmlspecialchars($_POST['specialisation']);

			$partTime = htmlspecialchars($_POST['pt']);
			$oldPT = htmlspecialchars($_POST['oldPT']);
			$partTimeChanged = ($partTime !== $oldPT);
			$ptDate = ($partTimeChanged) ? date("Y/n/d") : '';

			$scholarship = htmlspecialchars($_POST['scholarship']);
			$studentID = htmlspecialchars($_POST['sID']);

			$wkY1 = ($isPhd) ? htmlspecialchars($_POST['WorkY1']) : '';
			$wkY2 = ($isPhd) ? htmlspecialchars($_POST['WorkY2']) : '';
			$wkY3 = ($isPhd) ? htmlspecialchars($_POST['WorkY3']) : '';

			$prisupID = htmlspecialchars($_POST['pSupervisor']);
			$priPercent = htmlspecialchars($_POST['pPercentage']);
			$secsupID = htmlspecialchars($_POST['sSupervisor']);
			$secPercent = htmlspecialchars($_POST['sPercentage']);

			$suspensionStart = htmlspecialchars($_POST['suspensionStart']);
			$suspensionEnd = htmlspecialchars($_POST['suspensionEnd']);
			$newSuspension = ($suspensionStart != '' && $suspensionEnd != '');

			$startDate = htmlspecialchars($_POST['startDate']);
			$propSub = htmlspecialchars($_POST['proposalSubmission']);
			$propSub = ($propSub === '') ? 'NULL' : "'".$propSub."'";
			$propSem = ($isPhD) ? htmlspecialchars($_POST['proposalSeminar']) : '';
			$propSem = ($propSem === '') ? 'NULL' : "'".$propSem."'";
			$propConf = htmlspecialchars($_POST['proposalConfirmation']);
			$propSub = ($propConf === '') ? 'NULL' : "'".$propConf."'";

			$Mon3Sub = (!$isPhd) ? htmlspecialchars($_POST['3MonthSubmission']) : '';
			$Mon3Sub = ($Mon3Sub === '') ? 'NULL' : "'".$Mon3Sub."'";
			$Mon3App = (!$isPhd) ? htmlspecialchars($_POST['3MonthApproval']) : '';
			$Mon3App = ($Mon3App === '') ? 'NULL' : "'".$Mon3App."'";
			$Mon8Sub = (!$isPhd) ? htmlspecialchars($_POST['8MonthSubmission']) : '';
			$Mon8Sub = ($Mon8Sub === '') ? 'NULL' : "'".$Mon8Sub."'";
			$Mon8App = (!$isPhd) ? htmlspecialchars($_POST['8MonthApproval']) : '';
			$Mon8App = ($Mon8App === '') ? 'NULL' : "'".$Mon8App."'";

			$thesisSubmission = htmlspecialchars($_POST['thesisSubmission']);
			$thesisSubmission = ($thesisSubmission === '') ? 'NULL' : "'".$thesisSubmission."'";
			$examAppointed = htmlspecialchars($_POST['examinersAppointed']);
			$examAppointed = ($examAppointed === '') ? 'NULL' : "'".$examAppointed."'";
			$examCompleted = htmlspecialchars($_POST['examinationCompleted']);
			$examCompleted = ($examCompleted === '') ? 'NULL' : "'".$examCompleted."'";
			$revisionsFinal = htmlspecialchars($_POST['revisionsFinalised']);
			$revisionsFinal = ($revisionsFinal === '') ? 'NULL' : "'".$revisionsFinal."'";
			$deposited = htmlspecialchars($_POST['deposited']);
			$deposited = ($deposited === '') ? 'NULL' : "'".$deposited."'";

			$notes = htmlspecialchars($_POST['notes']);
			$origin = htmlspecialchars($_POST['origin']);
			$withdrawn = htmlspecialchars($_POST['withdrawn']);

			$query = "UPDATE Students SET (StartDate,F_Name,L_Name, Course,Specialisation,Primary_SupervisorID,Primary_SupervisorPercent,Secondary_SupervisorID,Secondary_SupervisorPercent,Notes,Origin,Withdrawn)
				      = ('".$startDate."', '".$f_name."','".$l_name."','".$course."','".$specialisation."',".$prisupID.",".$priPercent.",".$secsupID.
				      ",".$secPercent.",'".$notes."', '".$origin."', ".$withdrawn.") WHERE StudentID = ".$studentID.";";


			if(!$isPhD) {
				$query .= "UPDATE MastersStudents SET (ProposalSubmission,ProposalConfirmation,Report3MonthSubmission,Report3MonthApproval,Report8MonthSubmission,Report8MonthApproval,
					     ThesisSubmission,ExaminersAppointed,ExaminationCompleted,RevisionsFinalised,DepositedInLibrary)
					     = (".$propSub.", ".$propConf.", ".$Mon3Sub.", ".$Mon3App.", ".$Mon8Sub.", ".$Mon8App.", ".$thesisSubmission.", ".$examAppointed.
			  			", ".$examCompleted.", ".$revisionsFinal.", ".$deposited.") WHERE StudentID = ".$studentID.";";
			}
			else {
			  $query .= "UPDATE PhDStudents SET (ProposalSubmission,ProposalSeminar,ProposalConfirmation,WorkHours1, WorkHours2, WorkHours3,
					     ThesisSubmission,ExaminersAppointed,ExaminationCompleted,RevisionsFinalised,DepositedInLibrary)
					     = (".$propSub.", ".$propSem.", ".$propConf.", ".$wkY1.", ".$wkY2.", ".$wkY3.", ".$thesisSubmission.", ".$examAppointed.
					     ", ".$examCompleted.", ".$revisionsFinal.", ".$deposited.") WHERE StudentID = ".$studentID.";";
			}
			if($newSuspension) {
			  $query .= "INSERT INTO Suspensions (StudentID, SuspensionStartDate, SuspensionEndDate) VALUES (".$studentID.", '".$suspensionStart."', '".$suspensionEnd."');";
			}
			if($partTimeChanged) {
			  $query .= "INSERT INTO EnrolmentTypeChanges (StudentID, EnrolmentType, ChangeDate) VALUES (".$studentID.", '".$partTime."', '".ptDate."');";
			}

			$result = pg_query($query);
			if ($result !== FALSE) {
				pg_free_result($result);
				header("Refresh:0;");
				pg_close($db);
			}
			else {
				echo "<div><p>".$query."</p></div>";
				pg_close($db);
			}
	      }
	      else if(isSet($_POST['Delete'])) {
			$SID = htmlspecialchars($_POST['del_studentID']);
			$MastersQuery = "DELETE FROM MastersStudents WHERE StudentID = ".$SID;
			$PhDQuery = "DELETE FROM PhDStudents WHERE StudentID = ".$SID;
			$StudentsQuery = "DELETE FROM Students WHERE StudentID = ".$SID;

			$Mresult = pg_query($MastersQuery) or die('Query failed: ' . pg_last_error());
			$Presult = pg_query($PhDQuery) or die('Query failed: ' . pg_last_error());
			$Sresult = pg_query($StudentsQuery) or die('Query failed: ' . pg_last_error());
			pg_free_result($Mresult);
			pg_free_result($Presult);
			pg_free_result($Sresult);
	      }

      }
  ?>
</body>
</html>
