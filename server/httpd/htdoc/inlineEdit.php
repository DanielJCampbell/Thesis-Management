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
			$propSem = ($isPhD) ? htmlspecialchars($_POST['proposalSeminar']) : '';
			$propConf = htmlspecialchars($_POST['proposalConfirmation']);

			$Mon3Sub = (!$isPhd) ? htmlspecialchars($_POST['3MonthSubmission']) : '';
			$Mon3App = (!$isPhd) ? htmlspecialchars($_POST['3MonthApproval']) : '';
			$Mon8Sub = (!$isPhd) ? htmlspecialchars($_POST['8MonthSubmission']) : '';
			$Mon8App = (!$isPhd) ? htmlspecialchars($_POST['8MonthApproval']) : '';

			$thesisSubmission = htmlspecialchars($_POST['thesisSubmission']);
			$examAppointed = htmlspecialchars($_POST['examinersAppointed']);
			$examCompleted = htmlspecialchars($_POST['examinationCompleted']);
			$revisionsFinal = htmlspecialchars($_POST['revisionsFinalised']);
			$deposited = htmlspecialchars($_POST['deposited']);
			$startDate = htmlspecialchars($_POST['notes']);
			$origin = htmlspecialchars($_POST['origin']);
			$withdrawn = htmlspecialchars($_POST['withdrawn']);

			$query = "UPDATE students SET (StartDate,F_Name,L_Name, Course,Specialisation,Primary_SupervisorID,Primary_SupervisorPercent,Secondary_SupervisorID,Secondary_SupervisorPercent,Origin,Withdrawn)
				      = ('".$startDate."', '".$f_name."','".$l_name."','".$course."','".$specialisation."',".$prisupID.",".$priPercent.",".$secsupID.
				      ",".$secPercent.",'".$origin."', ".$withdrawn.") WHERE StudentID = ".$studentID.";";


			if(!$isPhD) {
			  $query .= "UPDATE MastersStudents SET (ProposalSubmission,ProposalConfirmation,Report3MonthSubmission,Report3MonthApproval,Report8MonthSubmission,Report8MonthApproval,
					     ThesisSubmission,ExaminersAppointed,ExaminationCompleted,RevisionsFinalised,DepositedInLibrary)
					     = ('".$propSub."', '".$propConf."', '".$Mon3Sub."', '".$Mon3App."', '".$Mon8Sub."', '".$Mon8App."', '".$thesisSubmission."', '".$examAppointed.
			  			"', '".$examCompleted."', '".$revisionsFinal."', '".$deposited."') WHERE StudentID = ".$studentID.";";
			}
			else {
			  $query .= "UPDATE PhDStudents SET (ProposalSubmission,ProposalSeminar,ProposalConfirmation,WorkHours1, WorkHours2, WorkHours3,
					     ThesisSubmission,ExaminersAppointed,ExaminationCompleted,RevisionsFinalised,DepositedInLibrary)
					     = ('".$propSub."', '".$propSem."', '".$propConf."', ".$wkY1.", ".$wkY2.", ".$wkY3.", '".$thesisSubmission."', '".$examAppointed.
					     "', '".$examCompleted."', '".$revisionsFinal."', '".$deposited."') WHERE StudentID = ".$studentID.";";
			}
			if($newSuspension) {
			  $query .= "INSERT INTO Suspensions (StudentID, SuspensionStartDate, SuspensionEndDate) VALUES (".$studentID.", '".$suspensionStart."', '".$suspensionEnd."');";
			}
			if($partTimeChanged) {
			  $query .= "INSERT INTO EnrolmentTypeChanges (StudentID, EnrolmentType, ChangeDate) VALUES (".$studentID.", '".$partTime."', '".ptDate."');";
			}

			$result = pg_query($query) or 'failure';
			if ($result === 'failure') {
				echo '<script>failChange("'.pg_last_error().'");</script>';
			}
			else {
				echo '<script>sendPHPRequest();</script>';
				pg_free_result($result);
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

	      pg_close($db);
      }
  ?>