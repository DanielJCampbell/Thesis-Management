<html>
  <head>
    <title>Coordinator</title>
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
    <h1> COORDINATOR PAGE MOCKUP </h1> 
  </head>
  
  <body>
  <div id = "left" style = "float: left; background-color: steelblue;">
  <input type = "button" onclick = "showAll();" value = "Show All"/><br/>
  <input type = "button" onclick = "deadlines();" value = "Show Overdue Students"/><br/>
  <input type = "button" onclick = "showProvisional();" value = "Show Provisional Students"/><br/>
  <input type = "button" onclick = "showUnassessed();" value = "Show Not Assessed"/><br/>
  <input type = "button" onclick = "showSupervisor();" value = "Show Supervisor Workload"/><br/>
  </div>
  <div id = "body">
  Filter On: <select id = "students" onchange = "changeFilter(this.value)">
    <option value = "all">All Students</option>
    <option value = "phd">PhD Students</option>
    <option value = "masters" selected = "selected">Masters Students</option>
  </select>
 
  <table><!-- cellpadding = "5px" cellspacing = "10px"-->
  <tr>
    <th>Name</th>
    <th>ID</th>
    <th>Degree</th>
    <th>Half-Time</th>
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
  <!--tr>
    <td>John Smith</td>
    <td>300001111</td>
    <td>Jane Doe</td>
    <td>John Doe</td>
    <td>24/4/2013</td>
    <td>18/7/2013</td>
    <td></td>
    <td></td>
    <td>20/7/2013 - 20/10/2013</td>
    <td>He doesn't even go here!</td>
    <td>I</td>
  </tr>
  <tr>
    <td>Jane Smith</td>
    <td>300001112</td>
    <td>Jane Doe</td>
    <td>John Doe</td>
    <td>28/4/2013</td>
    <td>16/7/2013</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>D</td>
  </tr>
  <tr>
    <td>Bob Smith</td>
    <td>300001113</td>
    <td>Jane Doe</td>
    <td>John Doe</td>
    <td>24/2/2014</td>
    <td>18/4/2014</td>
    <td>12/9/2014</td>
    <td></td>
    <td></td>
    <td></td>
    <td>D</td>
  </tr>
  <tr>
    <td>Bobella Smith</td>
    <td>300001114</td>
    <td>Jane Doe</td>
    <td>John Doe</td>
    <td>21/2/2015</td>
    <td>12/5/2015</td>
    <td></td>
    <td></td>
    <td>20/7/2013 - 20/10/2013</td>
    <td>Gender Unknown</td>
    <td>I</td>
  </tr-->
  </table>
  <input type = "button" onclick = "editTable()" id = "edit" value = "Edit" style = "float: right"></input>
  </div>
</body>
</html>