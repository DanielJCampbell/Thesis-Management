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

$query = mysqli_query("select * from PhDStudent");

while($row = mysqli_fetch_array($query)){
  $student = mysqli_fetch_array(mysqli_query("select * from Student s where s.StudentID = ".$row[StudentID]));
  
  echo "<tr>";
    echo "<td>".$student[F_Name]." ".$student[L_Name]."</td>";
    echo "<td>".$row[StudentID]."</td>";
    echo "<td>".$student[Degree]."</td>";
    
    if ($student[Halftime]) echo "<td>Yes</td>";
    else echo "<td>No</td>";
    
    echo "<td>".$student[Scholarship]."</td>";
    
    //Query supervisors
    $primary = mysqli_fetch_array(mysqli_query("select * from Supervisor s where s.SupervisorID = ".$student[Primary_SupervisorID]));
    $secondary = mysqli_fetch_array(mysqli_query("select * from Supervisor s where s.SupervisorID = ".$student[Secondary_SupervisorID]));
    
    echo "<td>".$primary[F_Name]." ".$primary[L_Name]." (".$student[Primary_SupervisorPercent]."%)</td>";
    echo "<td>".$secondary[F_Name]." ".$secondary[L_Name]." (".$secondary[Secondary_SupervisorPercent]."%)</td>";
    
    //Create a string of all the suspension dates
    $suspensions = mysqli_query("select * from Suspension s where s.StudentID = ".$student[StudentID]);
    $ss = "";
    
    while ($tmp = mqsqli_fetch_array($suspensions)) {
	$ss .= ($tmp[SuspensionStartDate]." - ".$tmp[SuspensionEndDate]."<br>");
    }
    echo "<td>".$ss."</td>";
    
    echo "<td>".$row[ProposalSubmission]."</td>";
    echo "<td>".$row[ProposalSeminar]."</td>";
    echo "<td>".$row[ProposalConfirmation]."</td>";
    echo "<td>".$row[FGRCompletesExamination]."</td>";
    
    $sixmonth = mysqli_query("select * from SixMonthlyReport s where s.StudentID = ".$student[StudentID]);
    $report = "";
    
     while ($tmp = mqsqli_fetch_array($sixmonth)) {
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
