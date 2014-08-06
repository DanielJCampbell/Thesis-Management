<html>
  <head>
    <title>Administrator</title>
    <script src = "tables.js"></script>
    <style>
    
    .active {
	display: block;
      }
      .passive {
	display: none;
      }
      table {
	border: solid 2px;
	border-collapse: collapse;
	text-align: center;
	font-size:14px;
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
    <h1> ADMINISTRATOR PAGE MOCKUP</h1> 
  </head>
  
  <body>
  <div id = "left" style = "float: left; background-color: steelblue;">
  <input type = "button" onclick = "showAll();" value = "Show All"/><br/>
  <input type = "button" onclick = "deadlines();" value = "Show Overdue Students"/><br/>
  <input type = "button" onclick = "showProvisional();" value = "Show Provisional Students"/><br/>
  </div>
  <div id = "body">
  Filter On: <select id = "students" onchange = "changeFilter(this.value)" selected = "masters">
    <option value = "all">All Students</option>
    <option value = "phd">PhD Students</option>
    <option value = "masters" selected = "selected">Masters Students</option>
  </select>
  <table id = "Masters" class = "active">
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
  <input type = "button" onclick = "editTable('Masters')" id = "editMasters" class = "active" value = "Edit" style = "float: right"></input>
  
  <table id = "PhD" class = "passive">
  <tr>
    <th>Name</th>
    <th>ID</th>
    <th>Degree</th>
    <th>Part-Time</th>
    <th>Scholarship</th>
    <th>Work Hours</th>
    <th>Primary Supervisor</th>
    <th>Secondary Supervisor</th>
    <th>Suspension Dates</th>
    <th>Start Date</th>
    <th>Proposal Submission</th>
    <th>Proposal Seminar</th>
    <th>Proposal Confirmation</th>
    <th>FGR Completes Examination</th>
    <th>6 Monthly Report Submissions</th>
    <th>6 Monthly Report Confirmations</th>
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
  <input type = "button" onclick = "editTable('PhD')" id = "editPhD" class = "passive" value = "Edit" style = "float: right"></input>
  </div>
</body>
</html>