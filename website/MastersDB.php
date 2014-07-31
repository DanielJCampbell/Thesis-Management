<?php
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$Database = "ThesisTest";

//Connect to database
$db = new mysqli($location, $username, $password, $database);
if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

//Get all rows from master's table (TO DO: Check for filters and do right thing)
$query = $db->query("select * from MasterStudent");
if (is_null($query))
  die("How is this null?");

while ($row = $query->fetch()) {

    //Get the student corresponding to the entry in the MasterStudent table
    $stud = $db->query("select * from Student s where s.StudentID = ".$row[StudentID]);
    $student = $stud->fetch();
    
    echo "<tr>";
    echo "<td>".$student[F_Name]." ".$student[L_Name]."</td>";
    echo "<td>".$row[StudentID]."</td>";
    echo "<td>".$student[Degree]."</td>";
    
    if ($student[Halftime]) echo "<td>Yes</td>";
    else echo "<td>No</td>";
    
    echo "<td>".$student[Scholarship]."</td>";
    
    //Query supervisors
    $p = $db->query("select * from Supervisor s where s.SupervisorID = ".$student[Primary_SupervisorID]);
    $s = $db->query("select * from Supervisor s where s.SupervisorID = ".$student[Secondary_SupervisorID]);
    $primary = $p->fetch();
    $secondary = $s->fetch();
    
    echo "<td>".$primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]."%)</td>";
    echo "<td>".$secondary[F_Name]." ".$secondary[L_Name]." (".$secondary[Secondary_SupervisorPercent]."%)</td>";
    
    //Create a string of all the suspension dates
    $suspensions = $db->query("select * from Suspension s where s.StudentID = ".$student[StudentID]);
    $ss = "";
    
    while ($tmp = $suspensions->fetch()) {
	$ss .= ($tmp[SuspensionStartDate]." - ".$tmp[SuspensionEndDate]."<br>");
    }
    echo "<td>".$ss."</td>";
    
    //The timeline (and misc notes and origin)
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
}


?>