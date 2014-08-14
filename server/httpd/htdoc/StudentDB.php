<?php
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$database = "ThesisManagement";
$schema = array("StudentID", "Course Specialisation", "StartDate", "ProposalDeadline", "ProposalSubmission", "ProposalConfirmationDate", "Report3MonthDeadline", "Report3MonthSubmission", "Report3MonthApproval", "Report8MonthDeadline", "Report8MonthSubmission", "Report8MonthApproval", "ThesisDeadline", "ThesisSubmission", "ExaminersAppointedDate", "ExaminationCompleted", "RevisionsFinalised", "DepositedInLibrary");

//Connect to database
$db = new mysqli($location, $username, $password, $database);
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$db->select_db($database)){
    die('Unable to select database '.$db);
}
    //Get the student corresponding to the entry in the MasterStudent table
    $stud = $db->query("select * FROM Students s NATURAL JOIN MastersStudents ms WHERE s.StudentID=ms.StudentID AND s.StudentID=300000001");  
    $student = $stud->fetch_assoc();
    printf($student[F_Name] . " " . $student[L_Name] . " ");
    printf($student[StudentID] . " ");
    echo "<br>";
    if ($student[Halftime]) echo "Part Time: Yes <br>";
    else echo "Part Time: No <br>";
    
    //Query supervisors
    $p = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Primary_SupervisorID]);
    $s = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Secondary_SupervisorID]);
    $primary = $p->fetch_assoc();
    $secondary = $s->fetch_assoc();
    echo "Your supervisors:<br>";
    echo $primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]."%)<br>";
    echo $secondary[F_Name]." ".$secondary[L_Name]." (".$secondary[Secondary_SupervisorPercent]."%)";
    
    $p->close();
    $s->close();
    printf("<h3> Timeline of progress:</h3>");
    echo "<table>";
    //<tr> row
    //<th> header
    //<td> data
    //</tr>
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
