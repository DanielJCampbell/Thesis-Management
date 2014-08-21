<?php
date_default_timezone_set("Pacific/Auckland");

$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$database = "ThesisManagement";

$schema_masters = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmation", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointed", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
$schema_masters_human_readable = array("Student ID", "Course Specialisation", "Start Date", "Proposal Deadline", "Proposal Submission", "Proposal Confirmation", "3 Month Report Deadline", "3 Month Report Submission", "3 Month report Approval", "8 Month Report Deadline", "8 Month report Submission", "8 Month report Approval", "Thesis Deadline", "Thesis Submission", "Examiners Appointed", "Examination Completed", "Revisions Finalised", "Deposited In Library");

//Connect to database
$db = new mysqli($location, $username, $password, $database);
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$db->select_db($database)){
    die('Unable to select database '.$db);
}
if (empty($_POST))
	echo "<p> It's all gone wrong.</p>";
$type = $_POST['type'];
$method = $_POST['method'];
$studentID = $_POST['id'];
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
    if ($student[Halftime]) echo "Yes";
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
    echo "<table class='timeline'>\n";
    echo "<tr>";
    echo "\n<th> Event </th>\n";
    echo "<th> Date </th>\n";
    echo "</tr>";
    $deadLineDate = array();
    for($i =2;$i<count($schema_masters);$i++){ 	  
      	$tmp=$db->query("SELECT " . $schema_masters[$i] . " FROM MastersStudents ms WHERE ms.StudentID=" . $studentID . " AND " . $schema_masters[$i] . " >NOW()");
      	$deadLineDate[$schema_masters[$i]]= $tmp->fetch_assoc()[$schema_masters[$i]];
    }
    for($i =2;$i<count($schema_masters);$i++){ 	  
	$current_deadline = $deadLineDate[$schema_masters[$i]];
	if (!is_null($current_deadline)){
	echo "<tr>";	
	echo "<td>\n<strong>" . $schema_masters_human_readable[$i] . "</strong>\n</td>";
	echo "<td>\n" . $current_deadline . "\n</td>";
	echo "</tr>";	  
	}
    }
    echo"</table>";
    
    printf("<h3> Timeline of progress:</h3>\n");
    echo "<table class='timeline'>";
    echo "<tr>";
    echo "\n<th><strong>Event</strong></th>";
	echo "\n<th>Date</th>\n";
	echo "</tr>";
    
    for($i =2;$i<count($schema_masters);$i++){ 	  
	echo "<tr>";	
	echo "<td>\n<strong>" . $schema_masters_human_readable[$i] . "</strong>\n</td>";
	echo "<td>\n" . $student[$schema_masters[$i]]. "\n</td>";
	echo "</tr>";	  
    }
    echo "</table>\n";
    
    $stud->close();

$db->close();

?>
