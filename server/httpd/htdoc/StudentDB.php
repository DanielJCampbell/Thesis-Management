<?php
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$database = "ThesisManagement";
$schema = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmationDate", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointedDate", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
$schema_human_readable = array("Student\nID", "Course\nSpecialisation", "Start\nDate", "Proposal\nDeadline", "Proposal\nSubmission", "Proposal\nConfirmation", "3 Month\nReport\nDeadline", "3 Month\nReport\nSubmission", "3 Month\nreport\nApproval", "8 Month\nReport\nDeadline", "8 Month\nreport\nSubmission", "8 Month\nreport\nApproval", "Thesis\nDeadline", "Thesis\nSubmission", "Examiners\nAppointed", "Examination\nCompleted", "Revisions\nFinalised", "Deposited\nIn Library");

$current_student = 300000001;

//Connect to database
$db = new mysqli($location, $username, $password, $database);
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$db->select_db($database)){
    die('Unable to select database '.$db);
}
    //Get the student corresponding to the entry in the MasterStudent table
    $stud = $db->query("select * FROM Students s NATURAL JOIN MastersStudents ms WHERE s.StudentID=ms.StudentID AND s.StudentID=" . $current_student);  
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
    
    // Query supervisors
	echo "<td style='border:none;'><strong>Your Supervisors:</strong></td>";
	echo "<td style='border:none;'>" . $primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]. "%)</td>";
	echo "</tr><tr style='border:none;'>";	
	echo "<td style='border:none;'></td>";
	echo "<td style='border:none;'>" . $secondary[F_Name]." \n ".$secondary[L_Name]." (".$student[Secondary_SupervisorPercent]. "%)</td>";
	echo "</tr><tr style='border:none;'></table>";
	    
    $ps->close();
    $ss->close();
    
    echo"</table>";
    echo"<br>
	<h3> Upcoming Deadlines:</h3>
    <table class='timeline'>
    <tr>
      <th> Event </th>
      <th> Date </th>
    </tr>";
    $deadLineDate = array();
    for($i =2;$i<count($schema);$i++){ 	  
      $tmp=$db->query("SELECT " . $schema[$i] . " FROM MastersStudents ms WHERE ms.StudentID=" . $current_student . " AND " . $schema[$i] . " >NOW()");
      $deadLineDate[$schema[$i]]= $tmp->fetch_assoc()[$schema[$i]];
    }
    for($i =2;$i<count($schema);$i++){ 	  
	$current_deadline = $deadLineDate[$schema[$i]];
	if (!is_null($current_deadline)){
	echo "<td ><strong>" . $schema_human_readable[$i] . "</strong></td>";
	echo "<td>" . $current_deadline . "</td>";
	echo "</tr><tr>";	  
	}
    }
    echo"</table>";
    
    printf("<h3> Timeline of progress:</h3>");
    echo "<table class='timeline'>";

    echo "<th ><strong>Event</strong></th>";
	echo "<th>Date</th>";
	echo "</tr><tr>";
    
    for($i =2;$i<count($schema);$i++){ 	  
	echo "<td ><strong>" . $schema_human_readable[$i] . "</strong></td>";
	echo "<td>" . $student[$schema[$i]]. "</td>";
	echo "</tr><tr>";	  
    }
    
    
    $stud->close();

$db->close();

?>
