<?php
//http://codular.com/php-mysqli is website that I've got the info from
$location = "khmer.ecs.vuw.ac.nz";
$username = "ThesisTeam";
$password = "SWEN302";
$Database = "ThesisTest";

$db = new mysqli($location, $username, $password, $Database);

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
if (!mysqli_select_db($db, $Database)) {
    die("Uh oh, couldn't select database $db");
}
$sql = <<<SQL
    SELECT *
    FROM `Testing`
SQL;

//do something with $result
if ($result = mysqli_query($db, "SELECT * FROM Testing LIMIT 10")) {
    printf("Select returned %d rows.\n", mysqli_num_rows($result));

    /* free result set */
    mysqli_free_result($result);
}

echo "hello world";
$db->close();
?>
