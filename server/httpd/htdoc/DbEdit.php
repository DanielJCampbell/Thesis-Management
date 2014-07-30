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
/* Create table doesn't return a resultset */
if (mysqli_query($db, "INSERT INTO Testing L_Name VALUES(Derp)") === TRUE) {
    printf("Data inserted successfully.\n");
}else{
	printf("something went wrong inserting\n");
}
$try = mysqli_query($db,"INSERT INTO Testing (`L_Name`, `F_Name`, `ID`) VALUES ('guy','lolz',7)"); //valid insert code for db but not vaild in mysqli 
//php
if($try){
printf("it worked\n");
}else{
printf("it failed\n");
}
$db->close();
?>


