<?php
date_default_timezone_set("Pacific/Auckland");

function checkDeadline($date) {
  $cur = date_create();
  $deadline = date_create($date);
  
  return (date_diff($cur, $deadline)->invert === 1);
  
}

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

if (empty($_POST))
  echo "<p> It's all gone wrong.</p>";

$type = $_POST['type'];
$method = $_POST['method'];

$query = $db->query("SELECT * FROM Students");
$isMasters = true;

echo "<div id = 'PHPTable' class = 'active'>";
echo "<table>";

if ($method !== "supervisors" && $type === "All") {
  echo "<tr>";
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
  if($method === "deadlines")
    echo "<th> Proposal Deadline </th>";
  echo "<th> Proposal Submission </th>";
  echo "<th> Proposal Confirmation </th>";
  if($method === "deadlines")
    echo "<th> Report Deadlines </th>";
  echo "<th> Report Submissions </th>";
  echo "<th> Report Confirmations </th>";
  if($method === "deadlines")
    echo "<th> Thesis Deadline </th>";
  echo "<th> Thesis Submission </th>";
  echo "<th> Examiners Appointed </th>";
  echo "<th> Examination Completed </th>";
  echo "<th> Revisions Finalised </th>";
  echo "<th> Deposited in Library </th>";
  echo "<th> Notes </th>";
  echo "<th> Origin </th>";
  echo "</tr>";
}
if ($method !== "supervisors" && $type === "Masters") {
  echo "<tr>";
  echo "<th> Name </th>";
  echo "<th> ID </th>";
  echo "<th> Course </th>";
  echo "<th> Specialisation </th>";
  echo "<th> Part-Time </th>";
  echo "<th> Scholarship </th>";
  echo "<th> Primary Supervisor </th>";
  echo "<th> Secondary Supervisor </th>";
  echo "<th> Suspension Dates </th>";
  echo "<th> Start Date </th>";
  if($method === "deadlines")
    echo "<th> Proposal Deadline </th>";
  echo "<th> Proposal Submission </th>";
  echo "<th> Proposal Confirmation </th>";
  if($method === "deadlines")
    echo "<th> 3 Month Deadline </th>";
  echo "<th> 3 Month Submission </th>";
  echo "<th> 3 Month Confirmation </th>";
  if($method === "deadlines")
    echo "<th> 8 Month Deadline </th>";
  echo "<th> 8 Month Submission </th>";
  echo "<th> 8 Month Confirmation </th>";
  if($method === "deadlines")
    echo "<th> Thesis Deadline </th>";
  echo "<th> Thesis Submission </th>";
  echo "<th> Examiners Appointed </th>";
  echo "<th> Examination Completed </th>";
  echo "<th> Revisions Finalised </th>";
  echo "<th> Deposited in Library </th>";
  echo "<th> Notes </th>";
  echo "<th> Origin </th>";
  echo "</tr>";
}

if ($method !== "supervisors" && $type === "PhD") {
  echo "<tr>";
  echo "<th> Name </th>";
  echo "<th> ID </th>";
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
  if($method === "deadlines")
    echo "<th> Proposal Deadline </th>";
  echo "<th> Proposal Submission </th>";
  echo "<th> Proposal Seminar </th>";
  echo "<th> Proposal Confirmation </th>";
  if($method === "deadlines")
    echo "<th> Thesis Deadline </th>";
  echo "<th> Thesis Submission </th>";
  echo "<th> Examiners Appointed </th>";
  echo "<th> Examination Completed </th>";
  echo "<th> Revisions Finalised </th>";
  echo "<th> Deposited in Library </th>";
  echo "<th> Notes </th>";
  echo "<th> Origin </th>";
  echo "</tr>";
}


while ($row = $query->fetch_assoc()) {
    
    $stud = $db->query("SELECT * FROM MastersStudents s WHERE s.StudentID = ".$row[StudentID]);
    $student = null;
    
    if ($type === "Masters" || $type === "All") {
	$stud = $db->query("SELECT * FROM MastersStudents s WHERE s.StudentID = ".$row[StudentID]);
    }
    if ($type === "Masters" && $stud->num_rows === 0) {
	continue;
    }
    if ($type === "PhD" || ($type === "All" && $stud->num_rows === 0)) { 
	$isMasters = false;
	$stud = $db->query("SELECT * FROM PhDStudents s WHERE s.StudentID = ".$row[StudentID]);
    }
    if ($type === "PhD" && $stud->num_rows === 0) {
	continue;
    }
    
    $student = $stud->fetch_assoc();
    
    if ($method === "deadlines") {
    
      if ($student[ThesisSubmission] !== null || checkDeadline($student[ThesisDeadline]))
	  continue;
      if ($student[ProposalSubmission] !== null || checkDeadline($student[ProposalDeadline]))
	  continue;
      //Check Masters Deadlines
      if ($isMasters) {
	if ($student[Report3MonthSubmission] !== null || checkDeadline($student[Report3MonthDeadline]))
	  continue;
	if ($student[Report8MonthSubmission] !== null || checkDeadline($student[Report8MonthDeadline]))
	  continue;
      }
    }

    if ($method === "unassessed") {
      if ($student[ThesisConfirmation] !== null)
	  continue;
      if ($student[ProposalConfirmation] !== null)
	  continue;
      //Check Masters Deadlines
      if ($isMasters) {
	if ($student[Report3MonthConfirmation] !== null)
	  continue;
	if ($student[Report8MonthConfirmation] !== null)
	  continue;
      }
    }
    
    if ($method === "provisional") {
      if ($student[ProposalConfirmation] !== null)
	  continue;
    }


//if ($method === "students") {
//	echo "<script>console.log( 'Finding students');</script>";
//}


if ($method !== "supervisors") {
    echo "<tr>";
    echo "<td>".$row[F_Name]." ".$row[L_Name]."</td>";
    echo "<td>".$row[StudentID]."</td>";
    
    if ($type === "All") {
      if($isMasters){
	echo "<td>Masters</td>";
      }
      else{
	echo "<td>PhD</td>";
      }
    }
    
    echo "<td>".$row[Course]."</td>";
    echo "<td>".$row[Specialisation]."</td>";
    if($row[Halftime]){
      echo "<td>Yes</td>";
    }
    else
      echo "<td>No</td>";
      
    echo "<td>".$row[Scholarship]."</td>";
    
    if ($type === "All" || $type === "PhD") {
    if($isMasters || is_null($student[WorkHours1])){
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
    }
    else{
      echo "<td>".$student[WorkHours1]."</td>";
      if (is_null($student[WorkHours2]))
	  echo "<td></td>";
      else
	  echo "<td>".$student[WorkHours2]."</td>";
      if (is_null($student[WorkHours3]))
	  echo "<td></td>";
      else
	  echo "<td>".$student[WorkHours3]."</td>";
    }
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
    if ($method === "deadlines") {
	echo "<td>".$student[ProposalDeadline]."</td>"; 
    }
    echo "<td>".$student[ProposalSubmission]."</td>";
    
    if($isMasters){
      echo "<td>".$student[ProposalConfirmationDate]."</td>";
      if($type === "All") {
	if ($method === "deadlines") {
	    echo "<td>".$student[Report3MonthDeadline]."<br>".$student[Report8MonthDeadline]."</td>";
	}
	echo "<td>".$student[Report3MonthSubmission]."<br>".$student[Report8MonthSubmission]."</td>";
	echo "<td>".$student[Report3MonthApproval]."<br>".$student[Report8MonthApproval]."</td>";
      }
      else {
	if ($method === "deadlines")
	  echo "<td>".$student[Report3MonthDeadline]."</td>";
	echo "<td>".$student[Report3MonthSubmission]."</td>";
	echo "<td>".$student[Report3MonthApproval]."</td>";
	if ($method === "deadlines")
	  echo "<td>".$student[Report8MonthDeadline]."</td>";
	echo "<td>".$student[Report8MonthSubmission]."</td>";
	echo "<td>".$student[Report8MonthApproval]."</td>";
      }
    }
    else{
      if ($type === "PhD")
	echo "<td>".$student[ProposalSeminar]."</td>";
      echo "<td>".$student[ProposalConfirmation]."</td>";
      if ($type === "All") {
	echo "<td></td>";
	echo "<td></td>";
      }
    }
    
    if ($method === "deadlines") {
	echo "<td>".$student[ThesisDeadline]."</td>"; 
    }
    echo "<td>".$student[ThesisSubmission]."</td>"; 
    echo "<td>".$student[ExaminersAppointedDate]."</td>";
    echo "<td>".$student[ExaminationCompleted]."</td>";
    echo "<td>".$student[RevisionsFinalised]."</td>";
    echo "<td>".$student[DepositedInLibrary]."</td>";
    echo "<td>".$row[Notes]."</td>";
    echo "<td>".$row[Origin]."</td>";
  
  echo "</tr>";
}

else if ($method === "supervisors") {

}
}
echo "</table>";
echo "</div>";

 ?>
