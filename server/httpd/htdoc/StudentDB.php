<?php
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$database = "ThesisManagement";
$schema = array("StudentID", "Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmationDate", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointedDate", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");
$schema_human_readable = array("Student\nID", "Course\nSpecialisation", "Start\nDate", "Proposal\nDeadline", "Proposal\nSubmission", "Proposal\nConfirmation", "3 Month\nReport\nDeadline", "3 Month\nReport\nSubmission", "3 Month\nreport\nApproval", "8 Month\nReport\nDeadline", "8 Month\nreport\nSubmission", "8 Month\nreport\nApproval", "Thesis\nDeadline", "Thesis\nSubmission", "Examiners\nAppointed", "Examination\nCompleted", "Revisions\nFinalised", "Deposited\nIn Library");
//Connect to database
$db = new mysqli($location, $username, $password, $database);
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$db->select_db($database)){
    die('Unable to select database '.$db);
}
    //Get the student corresponding to the entry in the MasterStudent table
    $stud = $db->query("select * FROM Students s NATURAL JOIN MastersStudents ms WHERE s.StudentID=ms.StudentID AND s.StudentID=300000006");  
    $student = $stud->fetch_assoc();
	echo "<table style='border:none;text-align:left;' >";
	echo "<tr style='border:none;'>";
	echo "<td style='border:none;'>Name:</td>";
	echo "<td style='border:none;'>" . $student[F_Name] . " " . $student[L_Name] . "</td>";
	echo "</tr><tr style='border:none;'>";
	echo "<td style='border:none;'>ID:</td>";
	echo "<td style='border:none;'>" . $student[StudentID] . "</td>";
	echo "</tr><tr style='border:none;'>";
	echo "<td style='border:none;'>Specialisation:</td>";
	echo "<td style='border:none;'>" . $student[Specialisation] . "</td>";
	echo "</tr><tr style='border:none;'>";
	echo "<td style='border:none;'>Part Time:</td>";
	echo "<td style='border:none;'>";
    if ($student[Halftime]) echo "Yes";
    else echo "No";
	echo "</td></tr></table>";
    
    //Query supervisors
    $ps = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Primary_SupervisorID]);
    $ss = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Secondary_SupervisorID]);
    $primary = $ps->fetch_assoc();
    $secondary = $ss->fetch_assoc();
    echo "Your supervisors:<br>";
    echo $primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]."%)<br>";
    echo $secondary[F_Name]." ".$secondary[L_Name]." (".$student[Secondary_SupervisorPercent]."%)";
    
    $ps->close();
    $ss->close();
    printf("<h3> Timeline of progress:</h3>");
    echo "<table>";
	echo "<tr>"; 
    for($i =0;$i<count($schema);$i++){ 	  
	      echo "<th>";
	      echo $schema[$i];
	      echo "</th>";
    }
	      echo "</tr>";
	echo "<tr>";
    for($i =0;$i<count($schema);$i++){                                                                                                                               
                                                                                                                                                         
              echo "<td>";                                                                                                                                           
              echo $student[$schema[$i]];
              echo "</td>";                                                                                                                                         
    }
	echo "<tr>";
    echo"</table>";
    echo"<br>
	<h3> Upcoming Deadlines:</h3>
    <table>
    <tr>
      <th> 8 Month Report </th>
      <th> Thesis Submission</th>
    </tr>
    <tr>
      <td> 5/2/2015 </td>
      <td> 5/6/2015 </td>
    </tr>
    </table>";
    $stud->close();

$db->close();

?>
