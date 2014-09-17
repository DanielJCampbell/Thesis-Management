<?php
$location = "ec2-54-83-204-104.compute-1.amazonaws.com";
$username = "poacfvyhdhwtsx";
$password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
$database = "ddf40gpbvva8uo";

//$schema = array("F_Name", "L_Name", "Course",  "Specialisation", "StudentID", "Primary_SupervisorID", "Primary_SupervisorPercent", "Secondary_SupervisorID","Secondary_SupervisorPercent", "Scholarship", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalSeminar", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary", "WorkHours1", "WorkHours2", "WorkHours3");
//$tableColumns = array("Name", "ID", "Type", "Course", "Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Seminar", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library", "Work Hours 1st year", "Work Hours 2nd year", "Work Hours 3rd year");
//$schema_masters = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
//$schema_masters_human_readable = array("Student ID", "Course Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library");


//Connect to database
$db = pg_connect("host = '".$location."'user = '".$username."' password = '".$password."' dbname = '".$database."'")
		or die('Unable to connect to database: ' . pg_last_error());



//headers
echo "<div id = 'PHPTable' class = 'active'>";
echo "<table id='mainTable'>";
echo "<thead>";
echo "<tr>";
echo "<th> Name </th>";
echo "<th> ID </th>";
echo "<th> Type </th>";
echo "<th> Course </th>";
echo "<th> Specialisation </th>";
echo "<th> Part-Time </th>";
echo "<th> Scholarship </th>";
echo "<th> Work Hours Year 1 </th>";
echo "<th> Work Hours Year 2 </th>";
echo "<th> Work Hours Year 3 </th>";
echo "<th> Primary Supervisor </th>";
echo "<th> Secondary Supervisor </th>";
echo "<th> Suspension Dates </th>";
echo "<th> Start Date </th>";
echo "<th> Proposal Deadline </th>";
echo "<th> Proposal Submission </th>";
echo "<th> Proposal Seminar </th>";
echo "<th> Proposal Confirmation </th>";
echo "<th> 3 Month Report Deadline </th>";
echo "<th> 3 Month Report Submission </th>";
echo "<th> 3 Month Report Approval </th>";
echo "<th> 8 Month Report Deadline </th>";
echo "<th> 8 Month Report Submission </th>";
echo "<th> 8 Month Report Approval </th>";
echo "<th> Thesis Deadline </th>";
echo "<th> Thesis Submission </th>";
echo "<th> Examiners Appointed </th>";
echo "<th> Examination Completed </th>";
echo "<th> Revisions Finalised </th>";
echo "<th> Deposited in Library </th>";
echo "<th> Notes </th>";
echo "<th> Origin </th>";
echo "</tr>";
//data

$mastersQuery = pg_query ( "SELECT * FROM Students NATURAL JOIN MastersStudents" ) or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_array($mastersQuery, null, PQSQL_ASSOC)){
	echo "<tr>";
	echo "<td>" . $row [F_Name] . " " . $row [L_Name] . "</td>";
	echo "<td>" . $row [StudentID] . "</td>";
	echo "<td>Masters</td>";
	echo "<td>" . $row [Course] . "</td>";
	echo "<td>" . $row [Specialisation] . "</td>";

	$halftimeQuery = pg_query ("SELECT * FROM EnrolmentTypeChanges WHERE StudentID = ".$row[StudentID]." ORDER BY ChangeDate DESC LIMIT 1");
	$isHalftime = pg_fetch_array($halftimeQuery, null, PQSQL_ASSOC);
	if ($isHalftime [EnrolmentType] == 'H') {
		echo "<td>Yes</td>";
	} else{
		echo "<td>No</td>";
	}
	echo "<td>" . $row [Scholarship] . "</td>";
	echo "<td></td>"; //Work hours is for PhD students only
	echo "<td></td>";
	echo "<td></td>";

	$pQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [Primary_SupervisorID]);
	$sQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [Secondary_SupervisorID]);
	$primary = pg_fetch_array($pQuery, null, PQSQL_ASSOC);
	$secondary = pg_fetch_array($sQuery, null, PQSQL_ASSOC);
	echo "<td>" . $primary [F_Name] . " " . $primary [L_Name] . " (" . $row [Primary_SupervisorPercent] . "%)</td>";
	echo "<td>" . $secondary [F_Name] . " " . $secondary [L_Name] . " (" . $row [Secondary_SupervisorPercent] . "%)</td>";

	$suspensionsQuery = pg_query("SELECT * FROM Suspensions s WHERE s.StudentID = " . $row [StudentID] );
	$suspensions = "";
	while ( $tmp = pg_fetch_array($suspensionsQuery, null, PQSQL_ASSOC ) ) {
		$suspensions .= ($tmp [SuspensionStartDate] . " - " . $tmp [SuspensionEndDate] . "<br>");
	}
	echo "<td>" . $suspensions . "</td>";

	echo "<td>" . $row [StartDate] . "</td>";
	echo "<td>" . $row [ProposalDeadline] . "</td>";
	echo "<td>" . $row [ProposalSubmission] . "</td>";
	echo "<td></td>"; //seminar is for PhD only
	echo "<td>" . $row [ProposalConfirmation] . "</td>";
	echo "<td>" . $row [Report3MonthDeadline] . "</td>";
	echo "<td>" . $row [Report3MonthSubmission] . "</td>";
	echo "<td>" . $row [Report3MonthApproval] . "</td>";
	echo "<td>" . $row [Report8MonthDeadline] . "</td>";
	echo "<td>" . $row [Report8MonthSubmission] . "</td>";
	echo "<td>" . $row [Report8MonthApproval] . "</td>";
	echo "<td>" . $row [ThesisDeadline] . "</td>";
	echo "<td>" . $row [ThesisSubmission] . "</td>";
	echo "<td>" . $row [ExaminersAppointed] . "</td>";
	echo "<td>" . $row [ExaminationCompleted] . "</td>";
	echo "<td>" . $row [RevisionsFinalised] . "</td>";
	echo "<td>" . $row [DepositedInLibrary] . "</td>";
	echo "<td>" . $row [Notes] . "</td>";
	echo "<td>" . $row [Origin] . "</td>";
	echo "</tr>";
}
$phdQuery = pg_query ("SELECT * FROM Students NATURAL JOIN PhDStudents") or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_array($phdQuery, null, PQSQL_ASSOC)){
	echo "<tr>";
	echo "<td>" . $row [F_Name] . " " . $row [L_Name] . "</td>";
	echo "<td>" . $row [StudentID] . "</td>";
	echo "<td>PhD</td>";
	echo "<td>" . $row [Course] . "</td>";
	echo "<td>" . $row [Specialisation] . "</td>";

	$halftimeQuery = pg_query ("SELECT * FROM EnrolmentTypeChanges WHERE StudentID = ".$row[StudentID]." ORDER BY ChangeDate DESC LIMIT 1");
	$isHalftime = pg_fetch_array($halftimeQuery, null, PQSQL_ASSOC);
	if ($isHalftime [EnrolmentType] == 'H') {
		echo "<td>Yes</td>";
	} else{
		echo "<td>No</td>";
	}
	echo "<td>" . $row [Scholarship] . "</td>";

	if (is_null ( $row[WorkHours1]))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [Workhours1] . "</td>";
	if (is_null ( $row[WorkHours2]))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [Workhours2] . "</td>";
	if (is_null ( $row[WorkHours3]))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [Workhours3] . "</td>";

	$pQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [Primary_SupervisorID]);
	$sQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [Secondary_SupervisorID]);
	$primary = pg_fetch_array($pQuery, null, PQSQL_ASSOC);
	$secondary = pg_fetch_array($sQuery, null, PQSQL_ASSOC);
	echo "<td>" . $primary [F_Name] . " " . $primary [L_Name] . " (" . $row [Primary_SupervisorPercent] . "%)</td>";
	echo "<td>" . $secondary [F_Name] . " " . $secondary [L_Name] . " (" . $row [Secondary_SupervisorPercent] . "%)</td>";

	$suspensionsQuery = pg_query("SELECT * FROM Suspensions s WHERE s.StudentID = " . $row [StudentID] );
	$suspensions = "";
	while ( $tmp = pg_fetch_array($suspensionsQuery, null, PQSQL_ASSOC ) ) {
		$suspensions .= ($tmp [SuspensionStartDate] . " - " . $tmp [SuspensionEndDate] . "<br>");
	}
	echo "<td>" . $suspensions . "</td>";

	echo "<td>" . $row [StartDate] . "</td>";
	echo "<td>" . $row [ProposalDeadline] . "</td>";
	echo "<td>" . $row [ProposalSubmission] . "</td>";
	echo "<td>" . $row [ProposalSeminar] . "</td>";
	echo "<td>" . $row [ProposalConfirmation] . "</td>";
	echo "<td></td>"; //3 and 8 month reports are for masters only
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td>" . $row [ThesisDeadline] . "</td>";
	echo "<td>" . $row [ThesisSubmission] . "</td>";
	echo "<td>" . $row [ExaminersAppointed] . "</td>";
	echo "<td>" . $row [ExaminationCompleted] . "</td>";
	echo "<td>" . $row [RevisionsFinalised] . "</td>";
	echo "<td>" . $row [DepositedInLibrary] . "</td>";
	echo "<td>" . $row [Notes] . "</td>";
	echo "<td>" . $row [Origin] . "</td>";
	echo "</tr>";
}



?>
