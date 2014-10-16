<!DOCTYPE html >
<!-- this code is being depreciated and will be implemented in coordinator.php or index.php-->
<html>
  <head>
    <title>Edit</title>
  </head>

  <body>
    <h3>Add/Edit Student</h3>
    <form action="/index.php" method="post">
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
	<button type="submit" value="Submit" name="Add">Update Database</button>
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

  </body>
</html>