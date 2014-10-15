<?php
//Never used due to calling code being broken
$location = "ec2-54-83-204-104.compute-1.amazonaws.com";
$username = "poacfvyhdhwtsx";
$password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
$database = "ddf40gpbvva8uo";

$db = pg_connect("host = '".$location."'user = '".$username
		."' password = '".$password."' dbname = '".$database."'") or die('Unable to connect to database: '.pg_last_error());

$sID = $_POST[sID];
$query = pg_query ("SELECT Primary_SupervisorID, Secondary_SupervisorID FROM Students WHERE StudentID = ".$sID.";")
	or die('Query failed '.pg_last_error());

$row = pg_fetch_assoc($query);

echo $row['Primary_SupervisorID']." ".$row['Secondary_SupervisorID'];
?>