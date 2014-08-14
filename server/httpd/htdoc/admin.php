<html>
  <head>
    <title>Administrator</title>
    <script src = "tables.js"></script>
    <script>doMethod();</script>
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
  Filter On: <select id = "students" onchange = "changeFilter(this.value)" selected = "All">
    <option value = "All" selected = "selected">All Students</option>
    <option value = "PhD">PhD Students</option>
    <option value = "Masters">Masters Students</option>
  </select>
  <div id = "Tables"></div>
  </div>
</body>
</html>