<?php
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

$type = $_POST[type];
$method = $_POST[method];

if ($type === "All") {
	echo "<script>console.log( 'I'm an All students table!');</script>";
}

if ($type === "Masters") {
	echo "<script>console.log( 'I'm a Masters table!');</script>";
}

if ($type === "PhD") {
	echo "<script>console.log( 'I'm a PhD table!');</script>";
}

if ($method === "students") {
	echo "<script>console.log( 'Finding students');</script>";
}

else if ($method === "all") {

}

else if ($method === "deadlines") {
	echo "<script>console.log( 'Finding students');</script>";
}

else if ($method === "unassessed") {

}

else if ($method === "provisional") {

}

else if ($method === "supervisors") {

}

 ?>
