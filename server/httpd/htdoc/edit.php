<!DOCTYPE html >
<!-- this code is being depreciated and will be implemented in coordinator.php or index.php-->
<html>
  <head>
    <title>Edit</title>
  </head>

  <body>
    <h3>Add/Edit Student</h3>
    <form method="post">
      <div>
	<label for="f_name">First Name:</label>
	<input type="text" id="f_name" name="f_name"/>
      </div>
      <div>
	<label for="l_name">Last Name:</label>
	<input type="text" id="l_name" name="l_name"/>
      </div>
      <div>
	<label for="studentID">Student ID:</label>
	<input type="number" id="studentID" name="studentID"/>
      </div>
      <div>
	<select name="type" id="type">
	<option value="masters">Masters</option>
	<option value="PhD">PhD</option>
	</select>
      </div>
      <div>
	<select name="partTimeStatus" id="partTimeStatus">
	<option value="partTime">Part Time</option>
	<option value="fullTime">Full Time</option>
	</select>
      </div>
      <div>
	<label for="startDate">Start Date:</label>
	<input type="date" id="startDate" name="startDate"/>
	<button id="calcDateStart" name="calcDateStart" type ="button" onclick='calcDeadlines("startDate");'/>
      </div>
      <div>
	<label for="course">Course:</label>
	<input type="text" id="course" name="course"/>
      </div>
      <div>
	<label for="specialisation">Specialisation:</label>
	<input type="text" id="specialisation" name="specialisation"/>
      </div>
      <div>
	<label for="psupID">Primary Supervisor ID:</label>
	<input type="number" id="psupID" name="psupID"/>
	<label for="primePercent">Percentage:</label>
	<input type="number" id="primePercent" name="primePercent"/>
	<label>%</label>
      </div>
      <div>
	<label for="secsupID">Secondary Supervisor ID:</label>
	<input type="number" id="secsupID" name="secsupID"/>
	<label for="secPercent">Percentage:</label>
	<input type="number" id="secPercent" name="secPercent"/>
	<label>%</label>
      </div>
      <div>
	<select name="origin">
	<option value="I">International</option>
	<option value="D">Domestic</option>
	</select>
      </div>
      <div>
	<select name ="optype">
	<option value="Add">Add Student</option>
	<option value="Edit">Edit Student</option>
	</select>
      </div>
      <div class="button">
	<button type="submit" value="Submit" name="Submit">Update Database</button>
      </div>
    </form>

    <div>
      <h3>Delete Student</h3>
      <form method="post">
	<div>
	  <label for="del_studentID">StudentID:</label>
	  <input type="number" id="del_studentID" name="del_studentID"/>
	</div>
	<div class="button">
	  <button type="submit" value="Delete" name="Delete">Delete Student</button>
	</div>
      </form>
    </div>

    <?php
      $location = "ec2-54-83-204-104.compute-1.amazonaws.com";
      $username = "poacfvyhdhwtsx";
      $password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
      $database = "ddf40gpbvva8uo";

      $db = pg_connect("host=".$location." dbname=".$database." user=".$username." password=".$password);
      if($db->connect_errno > 0){
	die('Unable to connect to database [' . $db->connect_error . ']');
      }
      if (empty ( $_POST )){
	    echo "<p> Post is empty</p>";
      }

      if(isSet($_POST['Submit'])){
	$f_name = htmlspecialchars($_POST['f_name']);
	$l_name = htmlspecialchars($_POST['l_name']);
	$SID = htmlspecialchars($_POST['studentID']);
	$type = htmlspecialchars($_POST['type']);
	$startDate = htmlspecialchars($_POST['startDate']);
	$course = htmlspecialchars($_POST['course']);
	$specialisation = htmlspecialchars($_POST['specialisation']);
	$psupID = htmlspecialchars($_POST['psupID']);
	$primePercent = htmlspecialchars($_POST['primePercent']);
	$secsupID = htmlspecialchars($_POST['secsupID']);
	$secPercent = htmlspecialchars($_POST['secPercent']);
	$origin = htmlspecialchars($_POST['origin']);
	$opType = htmlspecialchars($_POST['optype']);

	$query;

	if ($opType === "Add") {

	    $query = "INSERT INTO students(F_Name,L_Name,StudentID, Course,Specialisation,Primary_SupervisorID,Primary_SupervisorPercent,Secondary_SupervisorID,Secondary_SupervisorPercent,Origin)
		      VALUES('".$f_name."','".$l_name."',".$SID.",'".$course."','".$specialisation."',".$psupID.",".$primePercent.",".$secsupID.
		      ",".$secPercent.",'".$origin."')";
	}
	else {
	    $query = "UPDATE students SET (F_Name,L_Name, Course,Specialisation,Primary_SupervisorID,Primary_SupervisorPercent,Secondary_SupervisorID,Secondary_SupervisorPercent,Origin)
		      = ('".$f_name."','".$l_name."','".$course."','".$specialisation."',".$psupID.",".$primePercent.",".$secsupID.
		      ",".$secPercent.",'".$origin."') WHERE StudentID = ".$SID;
	}
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	if($type === "masters" && $opType === "Add"){
	  $mastersQuery = "INSERT INTO MastersStudents(StudentID, StartDate) VALUES (".$SID.",'".$startDate."')";
	  $mastersResult = pg_query($mastersQuery) or die('Query failed: ' . pg_last_error());
	  pg_free_result($mastersResult);
	}
	else if($type === "PhD" && $opType === "Add"){
	  $phdQuery = "INSERT INTO PhDStudents(StudentID, StartDate) VALUES (".$SID.",'".$startDate."')";
	  $phdResult = pg_query($phdQuery) or die('Query failed: ' . pg_last_error());
	  pg_free_result($phdResult);
	}
	else if($type === "masters") {
	  $mastersQuery = "UPDATE MastersStudents SET StartDate = '".$startDate."' WHERE StudentID = ".$SID;
	  $mastersResult = pg_query($mastersQuery) or die('Query failed: ' . pg_last_error());
	  pg_free_result($mastersResult);
	}
	else if($type === "PhD") {
	  $phdQuery = "UPDATE PhDStudents SET StartDate = '".$startDate."' WHERE StudentID = ".$SID;
	  $phdResult = pg_query($phdQuery) or die('Query failed: ' . pg_last_error());
	  pg_free_result($phdResult);
	}

	pg_free_result($result);
      }
      else if(isSet($_POST['Delete'])){
	$SID = htmlspecialchars($_POST['del_studentID']);
	$MastersQuery = "DELETE FROM MastersStudents WHERE StudentID = ".$SID;
	$PhDQuery = "DELETE FROM PhDStudents WHERE StudentID = ".$SID;
	$StudentsQuery = "DELETE FROM Students WHERE StudentID = ".$SID;

	$Mresult = pg_query($MastersQuery) or die('Query failed: ' . pg_last_error());
	$Presult = pg_query($PhDQuery) or die('Query failed: ' . pg_last_error());
	$Sresult = pg_query($StudentsQuery) or die('Query failed: ' . pg_last_error());
	pg_free_result($Mresult);
	pg_free_result($Presult);
	pg_free_result($Sresult);
      }

      pg_close($db);
    ?>

  </body>
  <script type="text/javascript">
	  var href = location.href.substring(0, location.href.lastIndexOf("/"));
	  href=index.php
  </script>
</html>