<?php
$location = "ec2-54-83-204-104.compute-1.amazonaws.com";
$username = "poacfvyhdhwtsx";
$password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
$database = "ddf40gpbvva8uo";

function calculateDeadlines($startDate,$studentType,$partTimeStatus){
	echo("<script>console.log('PHP: ".$startDate."');</script>");
 	$studentTypeModifier = 1;
 	$partTimeModifier = 1;
 	if (partTimeStatus === "H"){
 		$partTimeModifier = 2;
 	}
 	if (studentType === "PhD"){
 		$studentTypeModifier = 3;
 	}
 	$proposalDeadline = date('Y-m-d', strtotime("+" + 1*$partTimeModifier*$studentTypeModifier + " month", strtotime($startDate)));
 	$month3Deadline = date('Y-m-d', strtotime("+" + 3*$partTimeModifier*$studentTypeModifier + " month", strtotime($startDate)));
 	$month8Deadline = date('Y-m-d', strtotime("+" + 3*$partTimeModifier*$studentTypeModifier + " month", strtotime($startDate)));
 	$thesisDeadline = date('Y-m-d', strtotime("+" + 12*$partTimeModifier*$studentTypeModifier + " month", strtotime($startDate)));
 	return array("proposaldeadline" => $proposalDeadline, "report3monthdeadline" => $month3Deadline, "report8monthdeadline" => $month8Deadline, "thesisdeadline" => $thesisDeadline);
}

//$schema = array("F_Name", "L_Name", "Course",  "Specialisation", "StudentID", "Primary_SupervisorID", "Primary_SupervisorPercent", "secondary_supervisorid","Secondary_SupervisorPercent", "Scholarship", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalSeminar", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary", "WorkHours1", "WorkHours2", "WorkHours3");
//$tableColumns = array("Name", "ID", "Type", "Course", "Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Seminar", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library", "Work Hours 1st year", "Work Hours 2nd year", "Work Hours 3rd year");
//$schema_masters = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
//$schema_masters_human_readable = array("Student ID", "Course Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library");


//Connect to database
$db = pg_connect("host = '".$location."'user = '".$username."' password = '".$password."' dbname = '".$database."'")
		or die('Unable to connect to database: ' . pg_last_error());

/** Main Table */

//headers
echo "<table id='mainTable'  class='stripe'>";
echo "<thead>";
echo "<tr>";
echo "<th></th>";
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
echo "<th> Withdrawn </th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

//data
$mastersQuery = pg_query ( "SELECT * FROM Students NATURAL JOIN MastersStudents" ) or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_assoc($mastersQuery)){
	$deadlines = calculateDeadlines($row [startdate], "Masters", $row [enrolmenttype]);
	echo "<tr>";
	echo "<td class = 'editTD'> Edit </td>";
	echo "<td>" . $row [f_name] . " " . $row [l_name] . "</td>";
	echo "<td>" . $row [studentid] . "</td>";
	echo "<td>Masters</td>";
	echo "<td>" . $row [course] . "</td>";
	echo "<td>" . $row [specialisation] . "</td>";

	$halftimeQuery = pg_query ("SELECT * FROM EnrolmentTypeChanges WHERE (StudentID = ".$row[studentid].") ORDER BY ChangeDate DESC LIMIT 1");
	$isHalftime = pg_fetch_assoc($halftimeQuery);
	if ($isHalftime [enrolmenttype] == 'H') {
		echo "<td>Yes</td>";
	} else{
		echo "<td>No</td>";
	}
	echo "<td>" . $row [scholarship] . "</td>";
	echo "<td></td>"; //Work hours is for PhD students only
	echo "<td></td>";
	echo "<td></td>";

	$pQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [primary_supervisorid]);
	$sQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [secondary_supervisorid]);
	$primary = pg_fetch_assoc($pQuery );
	$secondary = pg_fetch_assoc($sQuery );
	echo "<td>" . $primary [f_name] . " " . $primary [l_name] . " (" . $row [primary_supervisorpercent] . "%)</td>";
	echo "<td>" . $secondary [f_name] . " " . $secondary [l_name] . " (" . $row [secondary_supervisorpercent] . "%)</td>";

	$suspensionsQuery = pg_query("SELECT * FROM Suspensions s WHERE s.StudentID = " . $row [studentid] );
	$suspensions = "";
	while ( $tmp = pg_fetch_assoc($suspensionsQuery  ) ) {
		$suspensions .= ($tmp [suspensionstartdate] . " - " . $tmp [suspensionenddate] . "<br>");
	}
	echo "<td>" . $suspensions . "</td>";

	echo "<td>" . $row [startdate] . "</td>";
	echo "<td>" . $deadlines [proposaldeadline] . "</td>";
	echo "<td>" . $row [proposalsubmission] . "</td>";
	echo "<td></td>"; //seminar is for PhD only
	echo "<td>" . $row [proposalconfirmation] . "</td>";
	echo "<td>" . $deadlines [report3monthdeadline] . "</td>";
	echo "<td>" . $row [report3monthsubmission] . "</td>";
	echo "<td>" . $row [report3monthapproval] . "</td>";
	echo "<td>" . $row [report8monthdeadline] . "</td>";
	echo "<td>" . $deadlines [report8monthsubmission] . "</td>";
	echo "<td>" . $row [report8monthapproval] . "</td>";
	echo "<td>" . $deadlines [thesisdeadline] . "</td>";
	echo "<td>" . $row [thesissubmission] . "</td>";
	echo "<td>" . $row [examinersappointed] . "</td>";
	echo "<td>" . $row [examinationcompleted] . "</td>";
	echo "<td>" . $row [revisionsfinalised] . "</td>";
	echo "<td>" . $row [depositedinlibrary] . "</td>";
	echo "<td>" . $row [notes] . "</td>";
	echo "<td>" . $row [origin] . "</td>";
	echo "<td>" . $row [withdrawn] . "</td>";
	echo "</tr>";
}
$phdQuery = pg_query ("SELECT * FROM Students NATURAL JOIN PhDStudents") or die('Query failed: ' . pg_last_error());

while ($row = pg_fetch_assoc($phdQuery )){
	$deadlines = calculateDeadlines($row[startdate], "PhD", $row[enrolmenttype]);
	echo "<tr>";
	echo "<td class = 'editTD'> Edit </td>";
	echo "<td>" . $row [f_name] . " " . $row [l_name] . "</td>";
	echo "<td>" . $row [studentid] . "</td>";
	echo "<td>PhD</td>";
	echo "<td>" . $row [course] . "</td>";
	echo "<td>" . $row [specialisation] . "</td>";

	$halftimeQuery = pg_query ("SELECT * FROM EnrolmentTypeChanges WHERE StudentID = ".$row[studentid]." ORDER BY ChangeDate DESC LIMIT 1");
	$isHalftime = pg_fetch_assoc($halftimeQuery );
	if ($isHalftime [enrolmenttype] == 'H') {
		echo "<td>Yes</td>";
	} else{
		echo "<td>No</td>";
	}
	echo "<td>" . $row [scholarship] . "</td>";

	if (is_null ( $row[workhours1]))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [workhours1] . "</td>";
	if (is_null ( $row[workhours2]))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [workhours2] . "</td>";
	if (is_null ( $row[workhours3]))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [workhours3] . "</td>";

	$pQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [primary_supervisorid]);
	$sQuery = pg_query("SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [secondary_supervisorid]);
	$primary = pg_fetch_assoc($pQuery );
	$secondary = pg_fetch_assoc($sQuery );
	echo "<td>" . $primary [f_name] . " " . $primary [l_name] . " (" . $row [primary_supervisorpercent] . "%)</td>";
	echo "<td>" . $secondary [f_name] . " " . $secondary [l_name] . " (" . $row [secondary_supervisorpercent] . "%)</td>";

	$suspensionsQuery = pg_query("SELECT * FROM Suspensions s WHERE s.StudentID = " . $row [studentid] );
	$suspensions = "";
	while ( $tmp = pg_fetch_assoc($suspensionsQuery  ) ) {
		$suspensions .= ($tmp [suspensionstartdate] . " - " . $tmp [suspensionenddate] . "<br>");
	}
	echo "<td>" . $suspensions . "</td>";

	echo "<td>" . $row [startdate] . "</td>";
	echo "<td>" . $deadlines [proposaldeadline] . "</td>";
	echo "<td>" . $row [proposalsubmission] . "</td>";
	echo "<td>" . $row [proposalseminar] . "</td>";
	echo "<td>" . $row [proposalconfirmation] . "</td>";
	echo "<td></td>"; //3 and 8 month reports are for masters only
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td>" . $deadlines [thesisdeadline] . "</td>";
	echo "<td>" . $row [thesissubmission] . "</td>";
	echo "<td>" . $row [examinersappointed] . "</td>";
	echo "<td>" . $row [examinationcompleted] . "</td>";
	echo "<td>" . $row [revisionsfinalised] . "</td>";
	echo "<td>" . $row [depositedinlibrary] . "</td>";
	echo "<td>" . $row [notes] . "</td>";
	echo "<td>" . $row [origin] . "</td>";
	echo "<td>" . $row [withdrawn] . "</td>";
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";

/** Supervisor Table */

// Headers
echo "<table id='supTable' class='stripe'>";
echo "<thead>";
echo "<tr>";
echo "<th> ID </th>";
echo "<th> Name </th>";
echo "<th> Workload </th>";
echo "<th> Supervised Students </th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Data
$supQuery = pg_query ( "SELECT * FROM Supervisors" ) or die('Query failed: ' . pg_last_error());
while ($row = pg_fetch_assoc($supQuery)){

	echo "<tr>";
	echo "<td>" . $row [supervisorid] . "</td>";
	echo "<td>" . $row [f_name] . " " . $row [l_name] . "</td>";

    $supervised = "";
    $supervisedAmount = 0;
	$supervisedStudentsQuery = pg_query ("SELECT * FROM Students WHERE (Primary_SupervisorID = ".$row[supervisorid].")");
	while($studentRow = pg_fetch_assoc($supervisedStudentsQuery)){
		$supervisedAmount += $studentRow[primary_supervisorpercent];
		$supervised .= $studentRow [f_name] . " " . $studentRow [l_name] . ", ";
	}
	$supervisedStudentsQuery = pg_query ("SELECT * FROM Students WHERE (Secondary_SupervisorID = ".$row[supervisorid].")");
	while($studentRow = pg_fetch_assoc($supervisedStudentsQuery)){
		$supervisedAmount += $studentRow[secondary_supervisorpercent];
		$supervised .= $studentRow [f_name] . " " . $studentRow [l_name] . ", ";
	}
	echo "<td>" . $supervisedAmount . "</td>";
	echo "<td>" . $supervised . "</td>";
	echo "</tr>";
	}

echo "</tbody>";
?>
