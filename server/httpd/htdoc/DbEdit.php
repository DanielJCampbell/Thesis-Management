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
$query = "INSERT INTO Testing (\"L_Name\",\"F_Name\",\"ID\") VALUES(\"derp\",\"Mc man\",3),(\"hello\",\"world\",6);";
 mysqli_query ( $db, $query);

$db->close();
?>


