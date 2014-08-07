<html>
  <head>
    <title>Supervisor</title>
    <style>
      table {
	border: solid 2px;
	border-collapse: collapse;
	text-align: center;
	font-size: 14px;
      }
      tr {
	border: solid 1px;
      }
      td {
      border: solid 1px;
      }
      th {
      border: solid 1px;
      }
    </style>
    <h1>SUPERVISOR</h1>
  </head>
  <body>
  <div id = "left" style = "float: left; background-color: steelblue;">
  <input type = "button" onclick = "showAll();" value = "Show All"/><br/>
  <input type = "button" onclick = "deadlines();" value = "Show Overdue Students"/><br/>
  <input type = "button" onclick = "showUnassessed();" value = "Show Not Assessed"/><br/>
  <input type = "button" onclick = "showStudents(80000004);" value = "Show My Students"/><br /> 
  </div>
  <div id = "body">
  Filter On: <select id = "students" onchange = "changeFilter(this.value)">
    <option value = "All">All Students</option>
    <option value = "PhD">PhD Students</option>
    <option value = "Masters" selected = "selected">Masters Students</option>
  </select>
  <div id = "Masters" class = "active">
  <table>
  <tr>
    <th>Name</th>
    <th>ID</th>
    <th>Course</th>
    <th>Specialisation</th>
    <th>Part-Time</th>
    <th>Scholarship</th>
    <th>Primary Supervisor</th>
    <th>Secondary Supervisor</th>
    <th>Suspension Dates</th>
    <th>Start Date</th>
    <th>Proposal Submission</th>
    <th>Proposal Confirmation</th>
    <th>3 Month Submission</th>
    <th>3 Month Confirmation</th>
    <th>8 Month Submission</th>
    <th>8 Month Confirmation</th>
    <th>Thesis Submission</th>
    <th>Examiners Appointed</th>
    <th>Examination Completed</th>
    <th>Revisions Finalised</th>
    <th>Deposited in Library</th>
    <th>Notes</th>
    <th>Origin</th>
  </tr>
  <?php require "MastersDB.php"; ?>
  </table>
  <input type = "button" onclick = "editTable('Masters')" value = "Edit" style = "float: right"></input>
  </div>
  
  <div id = "PhD" class = "passive">
  <table>
  <tr>
    <th>Name</th>
    <th>ID</th>
    <th>Course</th>
    <th>Specialisation</th>
    <th>Part-Time</th>
    <th>Scholarship</th>
    <th>Work Hours Year 1</th>
    <th>Work Hours Year 2</th>
    <th>Work Hours Year 3</th>
    <th>Primary Supervisor</th>
    <th>Secondary Supervisor</th>
    <th>Suspension Dates</th>
    <th>Start Date</th>
    <th>Proposal Submission</th>
    <th>Proposal Seminar</th>
    <th>Proposal Confirmation</th>
    <th>Thesis Submission</th>
    <th>Examiners Appointed</th>
    <th>Examination Completed</th>
    <th>Revisions Finalised</th>
    <th>Deposited in Library</th>
    <th>Notes</th>
    <th>Origin</th>
  </tr>
  <?php require "PhDDB.php"; ?>
  </table>
  <input type = "button" onclick = "editTable('PhD')" value = "Edit" style = "float: right"></input>
  </div>
  
  <div id = "All" class = "passive">
  <table>
  <tr>
    <th>Name</th>
    <th>ID</th>
    <th>Type</th>
    <th>Course</th>
    <th>Specialisation</th>
    <th>Part-Time</th>
    <th>Scholarship</th>
    <th>Work Hours Year 1</th>
    <th>Work Hours Year 2</th>
    <th>Work Hours Year 3</th>
    <th>Primary Supervisor</th>
    <th>Secondary Supervisor</th>
    <th>Suspension Dates</th>
    <th>Start Date</th>
    <th>Proposal Submission</th>
    <th>Proposal Confirmation</th>
    <th>Report Submissions</th>
    <th>Report Confirmations</th>
    <th>Thesis Submission</th>
    <th>Examiners Appointed</th>
    <th>Examination Completed</th>
    <th>Revisions Finalised</th>
    <th>Deposited in Library</th>
    <th>Notes</th>
    <th>Origin</th>
  </tr>
  <?php require "AllDB.php"; ?>
  </table>
  <input type = "button" onclick = "editTable('All')" value = "Edit" style = "float: right"></input>
  </div>
  </div>
  </body>
</html>