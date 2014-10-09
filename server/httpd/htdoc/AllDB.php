<?php
$location = "ec2-54-83-204-104.compute-1.amazonaws.com";
$username = "poacfvyhdhwtsx";
$password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
$database = "ddf40gpbvva8uo";

function calculateDeadlines($start, $studentType, $enrolmentTypeChangeList, $suspensionsList) {
	// FTE = Full Time Equivalence
	if ($start === "") {
		return array (
				"proposaldeadline" => "",
				"report3monthdeadline" => "",
				"report8monthdeadline" => "",
				"thesisdeadline" => ""
		);
	}
	$studentTypeModifier = 1;
	if ($studentType === "PhD") { // PhD students have 3 months for proposal and 3 years for their thesis
		$studentTypeModifier = 3;
	}
	//$studentStartDate = $start; // convert $start to unix time
	                                          // Full time equivalence to each deadline
	                                          // TODO Change FTE to use dateTime months
	$proposalFTE = 30 * $studentTypeModifier; // 1 month
	$month3FTE = 90;
	$month8FTE = 240;
	$thesisFTE = 365 * $studentTypeModifier; // 1 year

	$proposalDeadline = "";
	$month3Deadline = "";
	$month8Deadline = "";
	$thesisDeadline = "";

	// $startFTE = Full time equivalence to current enrolment type change from students start. (Calculated during each previous loop)
	// $currFTE = Full time equivalence for time between current enrolment type change and new enrolment type change. (calculated from dates in current loop)
	// $endFTE = Full time equivalence to next enrolment type change from students start (calculated from adding currFTE to startFTE)

	// $startDate = Date of start of enrolment Type Period
	// $endDate = Date for end of enrolment Type Period (i.e. start of next enrolment Type Period)
	$typeChangelength = count ( $enrolmentTypeChangeList );
	$startFTE = 0;
	for($i = 0; $i < $typeChangelength; $i ++) {
		// Find out what enrolment type student is for this time period
		$currType = $enrolmentTypeChangeList [$i] ['EnrolmentType'];
		$currTypeModifier = 1;
		if ($currType === "H") {
			$currTypeModifier = 2; // halftime students take twice as long for their enrolment
		}
		// Get dates for the start and end of this enrolment type period
		$startDate = date_create_from_format('Y-m-d',$enrolmentTypeChangeList [$i] ['ChangeDate']);
		$endDate = null;
		if ($i + 1 < $typeChangelength) { // Check if next type change exists
			$endDate = date_create_from_format('Y-m-d',$enrolmentTypeChangeList [$i + 1] ['ChangeDate']);
		}
		// Calculate Full Time Equivalence
		$currFTE = null;
		$endFTE = null;
		if ($endDate != null) {
			$currTimeUntillNextTypeChange = date_diff ( $startDate, $endDate );
			$currFTE = $currTimeUntillNextTypeChange->format ( '%a' ) / $currTypeModifier;
			$endFTE = $startFTE + $currFTE;
		}
		// Modify the deadline FTEs according to suspensions that happen during this period. Assumes suspensions do not happen over enrolment type changes (why would they?)
		$numSuspensions = count ( $suspensionsList );
		for($i = 0; $i < $numSuspensions; $i ++) {
			$currSuspStart = date_create_from_format('Y-m-d', $suspensionsList [$i] ['SuspensionStartDate'] );
			if ($startDate < $currSuspStart && ($endDate === null || $currSuspStart < $endDate)) { // suspension is in current enrolment type period
				$currSuspEnd = date_create_from_format('Y-m-d', $suspensionsList [$i] ['SuspensionEndDate'] );

				$timeFromCurr = date_diff ( $startDate, $currSuspStart );
				$fromStartFTE = $startFTE + ($timeFromCurr->format ( '%a' ) / $partTimeModifier);

				$timeForSuspension = date_diff ( $currSuspStart, $currSuspEnd );
				$suspensionFTE = $timeForSuspension->format ( '%a' ) / $currTypeModifier;

				if ($fromStartFTE < $proposalFTE) {
					$proposalFTE += $suspensionFTE;
				}
				if ($fromStartFTE < $month3FTE) {
					$month3FTE += $suspensionFTE;
				}
				if ($fromStartFTE < $month8FTE) {
					$month8FTE += $suspensionFTE;
				}
				if ($fromStartFTE < $thesisFTE) {
					$thesisFTE += $suspensionFTE;
				}
			}
		}
		// For each deadline, if said deadlines FTE is after the FTE for the start of this period and before the FTE at the end of this period, it is during this enrolment type period
		if ($startFTE <= $proposalFTE && ($endFTE === null || $proposalFTE < $endFTE)) {
			$proposalFTESinceStart = $proposalFTE - $startFTE;
			$proposalTimeSinceStart = $proposalFTESinceStart * $currTypeModifier;
			$proposalDeadline = date ( 'Y-m-d', strtotime ( "+" . $proposalTimeSinceStart . " day", strtotime ( $startDate ) ) );
		}
		if ($studentType === "Masters" && $startFTE <= $month3FTE && ($endFTE === null || $month3FTE < $endFTE)) {
			$month3FTESinceStart = $month3FTE - $startFTE;
			$month3TimeSinceStart = $month3FTESinceStart * $currTypeModifier;
			$month3Deadline = date ( 'Y-m-d', strtotime ( "+" . $month3TimeSinceStart . " day", strtotime ( $startDate ) ) );
		}
		if ($studentType === "Masters" && $startFTE <= $month8FTE && ($endFTE === null || $month8FTE < $endFTE)) {
			$month8FTESinceStart = $month8FTE - $startFTE;
			$month8TimeSinceStart = $month8FTESinceStart * $currTypeModifier;
			$month8Deadline = date ( 'Y-m-d', strtotime ( "+" . $month8TimeSinceStart . " day", strtotime ( $startDate ) ) );
		}
		if ($startFTE <= $thesisFTE && ($endFTE === null || $thesisFTE < $endFTE)) {
			$thesisFTESinceStart = $thesisFTE - $startFTE;
			$thesisTimeSinceStart = $thesisFTESinceStart * $currTypeModifier;
			$thesisDeadline = date ( 'Y-m-d', strtotime ( "+" . $thesisTimeSinceStart . " day", strtotime ( $startDate ) ) );
		}
		$startFTE = $endFTE;
	}
	// $proposalDeadline = date('Y-m-d', strtotime("+" . 1*$partTimeModifier*$studentTypeModifier . " month", strtotime($start)));
	// $month3Deadline = date('Y-m-d', strtotime("+" . 3*$partTimeModifier*$studentTypeModifier . " month", strtotime($start)));
	// $month8Deadline = date('Y-m-d', strtotime("+" . 8*$partTimeModifier*$studentTypeModifier . " month", strtotime($start)));
	// $thesisDeadline = date('Y-m-d', strtotime("+" . 12*$partTimeModifier*$studentTypeModifier . " month", strtotime($start)));
	return array (
			"proposaldeadline" => $proposalDeadline,
			"report3monthdeadline" => $month3Deadline,
			"report8monthdeadline" => $month8Deadline,
			"thesisdeadline" => $thesisDeadline
	);
}

// $schema = array("F_Name", "L_Name", "Course", "Specialisation", "StudentID", "Primary_SupervisorID", "Primary_SupervisorPercent", "secondary_supervisorid","Secondary_SupervisorPercent", "Scholarship", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalSeminar", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary", "WorkHours1", "WorkHours2", "WorkHours3");
// $tableColumns = array("Name", "ID", "Type", "Course", "Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Seminar", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library", "Work Hours 1st year", "Work Hours 2nd year", "Work Hours 3rd year");
// $schema_masters = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
// $schema_masters_human_readable = array("Student ID", "Course Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library");

// Connect to database
$db = pg_connect ( "host = '" . $location . "'user = '" . $username . "' password = '" . $password . "' dbname = '" . $database . "'" ) or die ( 'Unable to connect to database: ' . pg_last_error () );

/**
 * Main Table
 */

// headers
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

// data
$mastersQuery = pg_query ( "SELECT * FROM Students NATURAL JOIN MastersStudents" ) or die ( 'Query failed: ' . pg_last_error () );

while ( $row = pg_fetch_assoc ( $mastersQuery ) ) {

	$enrolmentTypeQuery = pg_query ( "SELECT * FROM EnrolmentTypeChanges WHERE (StudentID = " . $row [studentid] . ") ORDER BY ChangeDate" );
	$enrolmentTypeArray = pg_fetch_all ( $enrolmentTypeQuery );
	$suspensionsQuery = pg_query ( "SELECT * FROM Suspensions s WHERE s.StudentID = " . $row [studentid] );
	$suspensionsArray = pg_fetch_all ( $suspensionsQuery );

	$deadlines = calculateDeadlines ( $row [startdate], "Masters", $enrolmentTypeArray, $suspensionsArray );

	echo "<tr>";
	echo "<td class = 'editTD'> Edit </td>";
	echo "<td>" . $row [f_name] . " " . $row [l_name] . "</td>";
	echo "<td>" . $row [studentid] . "</td>";
	echo "<td>Masters</td>";
	echo "<td>" . $row [course] . "</td>";
	echo "<td>" . $row [specialisation] . "</td>";

	$halftimeQuery = pg_query ( "SELECT * FROM EnrolmentTypeChanges WHERE (StudentID = " . $row [studentid] . ") ORDER BY ChangeDate DESC LIMIT 1" );
	$isHalftime = pg_fetch_assoc ( $halftimeQuery );
	if ($isHalftime [enrolmenttype] == 'H') {
		echo "<td>Yes</td>";
	} else {
		echo "<td>No</td>";
	}
	echo "<td>" . $row [scholarship] . "</td>";
	echo "<td></td>"; // Work hours is for PhD students only
	echo "<td></td>";
	echo "<td></td>";

	$pQuery = pg_query ( "SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [primary_supervisorid] );
	$sQuery = pg_query ( "SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [secondary_supervisorid] );
	$primary = pg_fetch_assoc ( $pQuery );
	$secondary = pg_fetch_assoc ( $sQuery );
	echo "<td>" . $primary [f_name] . " " . $primary [l_name] . " (" . $row [primary_supervisorpercent] . "%)</td>";
	echo "<td>" . $secondary [f_name] . " " . $secondary [l_name] . " (" . $row [secondary_supervisorpercent] . "%)</td>";

	$suspensions = "";
	while ( $tmp = pg_fetch_assoc ( $suspensionsQuery ) ) {
		$suspensions .= ($tmp [suspensionstartdate] . " - " . $tmp [suspensionenddate] . "<br>");
	}
	echo "<td>" . $suspensions . "</td>";

	echo "<td>" . $row [startdate] . "</td>";
	echo "<td>" . $deadlines [proposaldeadline] . "</td>";
	echo "<td>" . $row [proposalsubmission] . "</td>";
	echo "<td></td>"; // seminar is for PhD only
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
	$withdrawn = "False";
	if ($row [withdrawn] === "t") {
		$withdrawn = "True";
	}
	echo "<td>" . $withdrawn . "</td>";
	echo "</tr>";
}
$phdQuery = pg_query ( "SELECT * FROM Students NATURAL JOIN PhDStudents" ) or die ( 'Query failed: ' . pg_last_error () );

while ( $row = pg_fetch_assoc ( $phdQuery ) ) {
	$enrolmentTypeQuery = pg_query ( "SELECT * FROM EnrolmentTypeChanges WHERE (StudentID = " . $row [studentid] . ") ORDER BY ChangeDate" );
	$enrolmentTypeArray = pg_fetch_all ( $enrolmentTypeQuery );
	$suspensionsQuery = pg_query ( "SELECT * FROM Suspensions s WHERE s.StudentID = " . $row [studentid] );
	$suspensionsArray = pg_fetch_all ( $suspensionsQuery );

	$deadlines = calculateDeadlines ( $row [startdate], "PhD", $enrolmentTypeArray, $suspensionsArray );
	echo "<tr>";
	echo "<td class = 'editTD'> Edit </td>";
	echo "<td>" . $row [f_name] . " " . $row [l_name] . "</td>";
	echo "<td>" . $row [studentid] . "</td>";
	echo "<td>PhD</td>";
	echo "<td>" . $row [course] . "</td>";
	echo "<td>" . $row [specialisation] . "</td>";

	$halftimeQuery = pg_query ( "SELECT * FROM EnrolmentTypeChanges WHERE StudentID = " . $row [studentid] . " ORDER BY ChangeDate DESC LIMIT 1" );
	$isHalftime = pg_fetch_assoc ( $halftimeQuery );
	if ($isHalftime [enrolmenttype] == 'H') {
		echo "<td>Yes</td>";
	} else {
		echo "<td>No</td>";
	}
	echo "<td>" . $row [scholarship] . "</td>";

	if (is_null ( $row [workhours1] ))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [workhours1] . "</td>";
	if (is_null ( $row [workhours2] ))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [workhours2] . "</td>";
	if (is_null ( $row [workhours3] ))
		echo "<td>0</td>";
	else
		echo "<td>" . $row [workhours3] . "</td>";

	$pQuery = pg_query ( "SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [primary_supervisorid] );
	$sQuery = pg_query ( "SELECT * FROM Supervisors s WHERE s.SupervisorID = " . $row [secondary_supervisorid] );
	$primary = pg_fetch_assoc ( $pQuery );
	$secondary = pg_fetch_assoc ( $sQuery );
	echo "<td>" . $primary [f_name] . " " . $primary [l_name] . " (" . $row [primary_supervisorpercent] . "%)</td>";
	echo "<td>" . $secondary [f_name] . " " . $secondary [l_name] . " (" . $row [secondary_supervisorpercent] . "%)</td>";
	$suspensions = "";
	while ( $tmp = pg_fetch_assoc ( $suspensionsQuery ) ) {
		$suspensions .= ($tmp [suspensionstartdate] . " - " . $tmp [suspensionenddate] . "<br>");
	}
	echo "<td>" . $suspensions . "</td>";

	echo "<td>" . $row [startdate] . "</td>";
	echo "<td>" . $deadlines [proposaldeadline] . "</td>";
	echo "<td>" . $row [proposalsubmission] . "</td>";
	echo "<td>" . $row [proposalseminar] . "</td>";
	echo "<td>" . $row [proposalconfirmation] . "</td>";
	echo "<td></td>"; // 3 and 8 month reports are for masters only
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
	$withdrawn = "False";
	if ($row [withdrawn] === "t") {
		$withdrawn = "True";
	}
	echo "<td>" . $withdrawn . "</td>";
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";

/**
 * Supervisor Table
 */

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
$supQuery = pg_query ( "SELECT * FROM Supervisors" ) or die ( 'Query failed: ' . pg_last_error () );
while ( $row = pg_fetch_assoc ( $supQuery ) ) {

	echo "<tr>";
	echo "<td>" . $row [supervisorid] . "</td>";
	echo "<td>" . $row [f_name] . " " . $row [l_name] . "</td>";

	$supervised = "";
	$supervisedAmount = 0;
	$supervisedStudentsQuery = pg_query ( "SELECT * FROM Students WHERE (Primary_SupervisorID = " . $row [supervisorid] . ")" );
	while ( $studentRow = pg_fetch_assoc ( $supervisedStudentsQuery ) ) {
		$supervisedAmount += $studentRow [primary_supervisorpercent];
		$supervised .= $studentRow [f_name] . " " . $studentRow [l_name] . ", ";
	}
	$supervisedStudentsQuery = pg_query ( "SELECT * FROM Students WHERE (Secondary_SupervisorID = " . $row [supervisorid] . ")" );
	while ( $studentRow = pg_fetch_assoc ( $supervisedStudentsQuery ) ) {
		$supervisedAmount += $studentRow [secondary_supervisorpercent];
		$supervised .= $studentRow [f_name] . " " . $studentRow [l_name] . ", ";
	}
	echo "<td>" . $supervisedAmount . "</td>";
	echo "<td>" . $supervised . "</td>";
	echo "</tr>";
}

echo "</tbody>";
?>
