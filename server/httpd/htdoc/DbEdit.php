<?php
//http://codular.com/php-mysqli is website that I've got the info from
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$Database = "ThesisTest";

$db = new mysqli($location, $username, $password, $database);

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if (mysqli_query($db, "INSERT INTO Testing L_Name VALUES(Derp)") === TRUE) {
    printf("Data inserted successfully.\n");
}else{
	printf("something went wrong inserting\n");
}
mysqli_select_db($db,"Testing");
$query_string = "INSERT INTO `Testing` (`L_Name`, `F_Name`, `ID`) VALUES ('guy','lolz',7)";
$try = mysqli_query($db,$query_string,1); //valid insert code for db but not vaild in mysqli 
//php
if($try){
printf("it worked\n");
}else{
printf("it failed\n");
}
$db->close();
?>


