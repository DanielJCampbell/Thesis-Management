<html>
  <head>
    <title>Supervisor</title>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

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
  <div id = "Tables">
  </div>
  </body>
</html>