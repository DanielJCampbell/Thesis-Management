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

$query = $db->query("select * from PhDStudent");

while($row = $query->fetch_array()){
    $student = $db->query("select * from Student s where s.StudentID = ".$row[StudentID])->fetch_array();
  
    echo "<tr>";
    echo "<td>".$student[F_Name]." ".$student[L_Name]."</td>";
    echo "<td>".$row[StudentID]."</td>";
    echo "<td>".$student[Degree]."</td>";
    
    if ($student[Halftime]) echo "<td>Yes</td>";
    else echo "<td>No</td>";
    
    echo "<td>".$student[Scholarship]."</td>";
    
    //Query supervisors
    $primary = $db->query("select * from Supervisor s where s.SupervisorID = ".$student[Primary_SupervisorID])->fetch_array();
    $secondary = $db->query("select * from Supervisor s where s.SupervisorID = ".$student[Secondary_SupervisorID])->fetch_array();
    
    echo "<td>".$primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]."%)</td>";
    echo "<td>".$secondary[F_Name]." ".$secondary[L_Name]." (".$secondary[Secondary_SupervisorPercent]."%)</td>";
    
    //Create a string of all the suspension dates
    $suspensions = $db->query("select * from Suspension s where s.StudentID = ".$student[StudentID]);
    $ss = "";
    
    while ($tmp = $suspensions->fetch_array()) {
	$ss .= ($tmp[SuspensionStartDate]." - ".$tmp[SuspensionEndDate]."<br>");
    }
    echo "<td>".$ss."</td>";
    
    echo "<td>".$row[ProposalSubmission]."</td>";
    echo "<td>".$row[ProposalSeminar]."</td>";
    echo "<td>".$row[ProposalConfirmation]."</td>";
    echo "<td>".$row[FGRCompletesExamination]."</td>";
    
    $sixmonth = $db->query("select * from SixMonthlyReport s where s.StudentID = ".$student[StudentID]);
    $report = "";
    
     while ($tmp = $sixmonth->fetch_array()) {
	$report .= ($tmp[Submission]." - ".$tmp[Confirmation]."<br>");
    }
    echo "<td>".$report."</td>";
    
    echo "<td>".$row[ThesisSubmitted]."</td>";
    echo "<td>".$row[ExaminerAppointedDate]."</td>";
    echo "<td>".$row[ExaminationCompleted]."</td>";
    echo "<td>".$row[RevisionsFinalised]."</td>";
    echo "<td>".$row[DepositedInLibrary]."</td>";
    echo "<td>".$row[WorkHours]."</td>";
    echo "<td>".$student[Notes]."</td>";
    echo "<td>".$student[Origin]."</td>";
    echo "</tr>";
    
}

?>
