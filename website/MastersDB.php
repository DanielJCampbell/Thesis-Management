<?php
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$database = "ThesisManagement";

//Connect to database
$db = new mysqli($location, $username, $password, $database);
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$db->select_db($database)){
    die('Unable to select database '.$db);
}

//Get all rows from master's table (TO DO: Check for filters and do right thing)
$query = $db->query("SELECT * FROM MastersStudents");


while ($row = $query->fetch_assoc()) {

    //Get the student corresponding to the entry in the MasterStudent table
    $stud = $db->query("SELECT * FROM Students s WHERE s.StudentID = ".$row[StudentID]);  
    $student = $stud->fetch_assoc();
    
    echo "<tr>";
    echo "<td>".$student[F_Name]." ".$student[L_Name]."</td>";
    echo "<td>".$row[StudentID]."</td>";
    echo "<td>".$student[Course]."</td>";
    echo "<td>".$row[Specialisation]."</td>";
    
    if ($student[Halftime]) echo "<td>Yes</td>";
    else echo "<td>No</td>";
    
    echo "<td>".$student[Scholarship]."</td>";
    
    //Query supervisors
    $p = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Primary_SupervisorID]);
    $s = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$student[Secondary_SupervisorID]);
    $primary = $p->fetch_assoc();
    $secondary = $s->fetch_assoc();
    
    echo "<td>".$primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]."%)</td>";
    echo "<td>".$secondary[F_Name]." ".$secondary[L_Name]." (".$student[Secondary_SupervisorPercent]."%)</td>";
    
    $p->close();
    $s->close();
    
    //Create a string of all the suspension dates
    $suspensions = $db->query("SELECT * FROM Suspensions s WHERE s.StudentID = ".$student[StudentID]);
    $ss = "";
    
    while ($tmp = $suspensions->fetch_assoc()) {
	$ss .= ($tmp[SuspensionStartDate]." - ".$tmp[SuspensionEndDate]."<br>");
    }
    echo "<td>".$ss."</td>";
    $suspensions->close();
    
    //The timeline (and misc notes and origin)
    echo "<td>".$row[StartDate]."</td>";
    echo "<td>".$row[ProposalSubmission]."</td>";
    echo "<td>".$row[ProposalConfirmation]."</td>";
    echo "<td>".$row[Report3MonthSubmission]."</td>";
    echo "<td>".$row[Report3MonthApproval]."</td>";
    echo "<td>".$row[Report8MonthSubmission]."</td>";
    echo "<td>".$row[Report8MonthApproval]."</td>";
    echo "<td>".$row[ThesisSubmission]."</td>";
    echo "<td>".$row[ExaminersAppointedDate]."</td>";
    echo "<td>".$row[ExaminationCompleted]."</td>";
    echo "<td>".$row[RevisionsFinalised]."</td>";
    echo "<td>".$row[DepositedInLibrary]."</td>";
    echo "<td>".$student[Notes]."</td>";
    echo "<td>".$student[Origin]."</td>";
    
    echo "</tr>";
    
    $stud->close();
}
$query->close();
$db->close();


?>