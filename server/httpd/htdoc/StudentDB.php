<?php
date_default_timezone_set("Pacific/Auckland");

$location = "ec2-54-83-204-104.compute-1.amazonaws.com";
$username = "poacfvyhdhwtsx";
$password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
$database = "ddf40gpbvva8uo";

$schema_PhD = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalSeminar", "ProposalConfirmation", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary", "WorkHours1", "WorkHours2", "WorkHours3");
$schema_PhD_human_readable = array("Student ID", "Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Seminar", "Proposal Confirmation", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library", "Work Hours 1st year", "Work Hours 2nd year", "Work Hours 3rd year");
$schema_masters = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
$schema_masters_human_readable = array("Student ID", "Course Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library");

$schema_PhD_deadlines = array("ProposalDeadline", "ThesisDeadline");
$schema_masters_deadlines = array("ProposalDeadline", "Report3MonthDeadline", "Report8MonthDeadline", "ThesisDeadline");
$schema_PhD_deadlines_hr = array("Proposal Deadline", "Thesis Deadline");
$schema_masters_deadlines_hr = array("Proposal Deadline", "3 Month Report Deadline", "8 Month Report Deadline", "Thesis Deadline");

//Connect to database
$db = pg_connect("host = '".$location."'user = '".$username."' password = '".$password."' dbname = '".$database."'");
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$db->select_db($database)){
    die('Unable to select database '.$db);
}
if (empty($_POST))
	echo "<p> It's all gone wrong.</p>";
$type = $_POST['type'];
$filter = $_POST['filter'];
$studentID = $_POST['studentID'];
$query = "EXISTS(SELECT 1 FROM MastersStudents ms WHERE ms.StudentID=" . $studentID . ")";
$checkMast = $db->query("SELECT " . $query);
$isMasters = (int) $checkMast->fetch_assoc()[$query]; //query returns column name of query
$checkMast->close();

    //Get the student corresponding to the entry in the MasterStudent table
	$stud;
	if ($isMasters === 1)
		$stud = $db->query("SELECT * FROM Students s NATURAL JOIN MastersStudents ms WHERE s.StudentID=" . $studentID);
	else
		$stud = $db->query("SELECT * FROM Students s NATURAL JOIN PhDStudents ps WHERE s.StudentID=" . $studentID);
    $student = $stud->fetch_assoc();
	echo "<table class='studentsummary' >";
	echo "<tr>";
	echo "<td class='studentsummary'><strong>Name:</strong></td>";
	echo "<td class='studentsummary'>" . $student[F_Name] . " " . $student[L_Name] . "</td>";
	echo "</tr><tr>";
	echo "<td class='studentsummary'><strong>ID:</strong></td>";
	echo "<td class='studentsummary'>" . $student[StudentID] . "</td>";
	echo "</tr><tr>";
	echo "<td class='studentsummary'><strong>Specialisation:</strong></td>";
	echo "<td class='studentsummary'>" . $student[Specialisation] . "</td>";
	echo "</tr><tr>";
	echo "<td class='studentsummary'><strong>Part Time:</strong></td>";
	echo "<td class='studentsummary'>";

	$isHalftime = $db->query("SELECT * FROM EnrolmentTypeChanges WHERE StudentID = ".$row[StudentID]." ORDER BY ChangeDate DESC LIMIT 1");
	$halftime = $isHalftime->fetch_assoc();
	$isHalftime->close();

	if ($halftime [EnrolmentType] == 'H') {
		echo "Yes";
	}
    else echo "No";
	echo "</td></tr>";

    //Query supervisors
    $ps = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Primary_SupervisorID]);
    $ss = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Secondary_SupervisorID]);
    $primary = $ps->fetch_assoc();
    $secondary = $ss->fetch_assoc();

	echo "<tr>";
	echo "<td style='border:none;'><strong>Your Supervisors:</strong></td>";
	echo "<td style='border:none;'>" . $primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]. "%)</td>";
	echo "</tr><tr style='border:none;'>";
	echo "<td style='border:none;'></td>";
	echo "<td style='border:none;'>" . $secondary[F_Name]." \n ".$secondary[L_Name]." (".$student[Secondary_SupervisorPercent]. "%)</td>";
	echo "</tr></table>";

    $ps->close();
    $ss->close();

    echo "<br>\n<h3> Upcoming Deadlines:</h3>\n";
    echo "<table id='deadlines' class='timeline'>\n";
    echo "<tr>";
    echo "\n<th> Event </th>\n";
    echo "<th> Date </th>\n";
    echo "</tr>";
    $deadLineDate = array();
	//list upcoming deadlines
	if ($isMasters == 1){
	for($i =0;$i<count($schema_masters_deadlines);$i++){
		$tmp=$db->query("SELECT " . $schema_masters_deadlines[$i] . " FROM MastersStudents ms WHERE ms.StudentID=" . $studentID . " AND " . $schema_masters_deadlines[$i] . " >NOW()");
		$deadLineDate[$schema_masters_deadlines[$i]]= $tmp->fetch_assoc()[$schema_masters_deadlines[$i]];
	}
	for($i =0;$i<count($schema_masters_deadlines);$i++){
			$current_deadline = $deadLineDate[$schema_masters_deadlines[$i]];

			if (!is_null($current_deadline)){
				echo "<tr>";
				echo "<td>\n<strong>" . $schema_masters_deadlines_hr[$i] . "</strong>\n</td>";
				echo "<td>\n" . $current_deadline . "\n</td>";
				echo "</tr>";
			}
	}
	}else{
	for($i =0;$i<count($schema_PhD_deadlines);$i++){
		$tmp=$db->query("SELECT " . $schema_PhD_deadlines[$i] . " FROM PhDStudents ps WHERE ps.StudentID=" . $studentID . " AND " . $schema_PhD_deadlines[$i] . " >NOW()");
		$deadLineDate[$schema_PhD_deadlines[$i]]= $tmp->fetch_assoc()[$schema_PhD_deadlines[$i]];
	}
	for($i =0;$i<count($schema_PhD_deadlines);$i++){
			$current_deadline = $deadLineDate[$schema_PhD_deadlines[$i]];

			if (!is_null($current_deadline)){
				echo "<tr>";
				echo "<td>\n<strong>" . $schema_PhD_deadlines_hr[$i] . "</strong>\n</td>";
				echo "<td>\n" . $current_deadline . "\n</td>";
				echo "</tr>";
			}
	}
	}
    echo"</table>";

    printf("<h3> Timeline of progress:</h3>\n");
    echo "<table id='timeline' class='timeline'>";
    echo "<tr>";
    echo "\n<th><strong>Event</strong></th>";
	echo "\n<th>Date</th>\n";
	echo "</tr>";
    //list all information
	if ($isMasters == 1){
	for($i =2;$i<count($schema_masters);$i++){
			echo "<tr>";
			echo "<td>\n<strong>" . $schema_masters_human_readable[$i] . "</strong>\n</td>";
			echo "<td>\n" . $student[$schema_masters[$i]]. "\n</td>";
			echo "</tr>";
	}
    }else{
	for($i =2;$i<count($schema_PhD);$i++){
			echo "<tr>";
			echo "<td>\n<strong>" . $schema_PhD_human_readable[$i] . "</strong>\n</td>";
			echo "<td>\n" . $student[$schema_PhD[$i]]. "\n</td>";
			echo "</tr>";
	}
	}
	echo "</table>\n";
    $stud->close();

$db->close();

?>
