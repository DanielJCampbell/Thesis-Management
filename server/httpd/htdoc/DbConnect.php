<?php
//http://codular.com/php-mysqli is website that I've got the info from
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$database = "ThesisTest";

$db = new mysqli($location, $username, $password, $database);

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
if (!mysqli_select_db($db, $database)) {
    die("Uh oh, couldn't select database $db");
}
$sql = <<<SQL
    SELECT *
    FROM `Testing`
SQL;

//do something with $result
if ($result = mysqli_query($db, "SELECT * FROM Testing LIMIT 10")) {
    printf("Select returned %d rows.<br>", mysqli_num_rows($result));
}
while($row = $result->fetch_assoc()){
	printf("%s %s %d <br>",$row['L_Name'],$row['F_Name'],$row['ID']);
}
    /* free result set */
    mysqli_free_result($result);


echo "hello world";
$db->close();
?>
