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

$query = $db->query("SELECT * FROM Students");

while ($row = $query->fetch_assoc()) {
  echo "<tr>";
    echo "<td>".$row[F_Name]." ".$row[L_Name]."</td>";
    echo "<td>".$row[StudentID]."</td>";
    
    $isMasters = true;
    $stud = $db->query("SELECT * FROM MastersStudents s WHERE s.StudentID = ".$row[StudentID]);
    if (mysql_num_rows($stud) == 0){
      $isMasters = false;
      $stud = $db->query("SELECT * FROM PhDStudents s WHERE s.StudentID = ".$row[StudentID]);
    }
    
    $student = $stud->fetch_assoc();
    
    if($isMasters){
      echo "<td>Masters</td>";
      echo "<td>".$student[Course]."</td>";
    }
    else{
      echo "<td>PhD</td>";
      echo "<td>".$student[Degree]."</td>";
    }
    
    
    if($row[Halftime]){
      echo "<td>Yes</td>";
    }
    else
      echo "<td>No</td">;
      
    echo "<td>".$row[Scholarship]."</td>";
    
    if($isMasters || is_null($student[WorkHours])){
      echo "<td></td>";
    }
    else{
      echo "<td>".$student[WorkHours]."</td>";
    }
      
    $p = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$row[Primary_SupervisorID]);
    $s = $db->query("SELECT * FROM Supervisors s WHERE s.SupervisorID = ".$row[Secondary_SupervisorID]);
    $primary = $p->fetch_assoc();
    $secondary = $s->fetch_assoc();
    
    echo "<td>".$primary[F_Name]." ".$primary[L_Name]." (".$row[Primary_SupervisorPercent]."%)</td>";
    echo "<td>".$secondary[F_Name]." ".$secondary[L_Name]." (".$row[Secondary_SupervisorPercent]."%)</td>";
    
    $suspensions = $db->query("SELECT * FROM Suspensions s WHERE s.StudentID = ".$row[StudentID]);
    $ss = "";
    
    while ($tmp = $suspensions->fetch_assoc()) {
	$ss .= ($tmp[SuspensionStartDate]." - ".$tmp[SuspensionEndDate]."<br>");
    }
    echo "<td>".$ss."</td>";
    $suspensions->close();
    
    
    
    echo "<td>".$student[StartDate]."</td>";
    echo "<td>".$student[ProposalSubmission]."</td>";
    
    if($isMasters){
      echo "<td>".$student[ProposalConfirmationDate]."</td>";
      echo "<td>".$student[Report3MonthSubmission]."<br>".$student[Report8MonthSubmission]."</td>";
      echo "<td>".$student[Report3MonthApproval]."<br>".$student[Report8MonthApproval]."</td>";
    }
    else{
      echo "<td>".$student[ProposalConfirmation]."</td>";
      $sixmonth = $db->query("SELECT * FROM SixMonthlyReports s WHERE s.StudentID = ".$student[StudentID]);
      $repSubs = "";
      $repConfs = "";
    
      while ($tmp = $sixmonth->fetch_assoc()) {
	$repSubs .= ($tmp[Submission]."<br>");
	$repConfs .= ($tmp[Confirmation]."<br>");
      }
      echo "<td>".$rebSubs."</td>";
      echo "<td>".$repConfs."</td>";
    }
    
    
    echo "<td>".$student[ThesisSubmission]."</td>"; 
    echo "<td>".$student[ExaminersAppointedDate]."</td>";
    echo "<td>".$student[ExaminersCompleted]."</td>";
    echo "<td>".$student[RevisionsFinalised]."</td>";
    echo "<td>".$student[DepositedInLibrary]."</td>";
    echo "<td>".$row[Notes]."</td>";
    echo "<td>".$row[Origin]."</td>";
  
  echo "</tr>";
}

?>
