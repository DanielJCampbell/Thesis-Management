<html>
  <head>
    <title>Coordinator</title>
     <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src = "tables.js"></script>
<<<<<<< HEAD
=======
    <script src = "supervisorTables.js"></script>
    <script>showAll();</script>
>>>>>>> 91a8d08e27527371ff63b1dd4892f14e40e08906
<!--
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
    -->
    <h1> COORDINATOR PAGE MOCKUP </h1>
  </head>

  <body>
  <div id = "left" style = "float: left; background-color: steelblue;">
  <input type = "button" onclick = "popFilter(); showAll(); redraw();" value = "Show All"/><br/>
  <input type = "button" onclick = "popFilter(); deadlines(); redraw();" value = "Show Overdue Students"/><br/>
  <input type = "button" onclick = "popFilter(); showProvisional(); redraw();" value = "Show Provisional Students"/><br/>
  <input type = "button" onclick = "popFilter(); showUnassessed(); redraw();" value = "Show Not Assessed"/><br/>
  <input type = "button" onclick = "popFilter(); showSuspensions(); redraw();" value = "Show Suspended Students"/><br/>
  <input type = "button" onclick = "popFilter(); showSupervisor(); redraw();" value = "Show Supervisor Workload"/><br/>
  </div>
  <div id = "body">
  Filter On: <select id = "students" onchange = "changeFilter(this.value)" selected = "All">
    <option value = "All" selected = "selected">All Students</option>
    <option value = "PhD">PhD Students</option>
    <option value = "Masters">Masters Students</option>
  </select>
  <div id = "Tables">
  </div>
  </div>
</body>
</html>
