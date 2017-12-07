<?php
include("mysqlInfo.php");

$servername = "localhost";
$username = USERNAME;
$password = PASSWORD; 
$dbname = "universityChallenge";


// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn){
	die("Connection failed: " . mysqli_connect_error());
}
?>
