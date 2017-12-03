<!DOCTYPE html>
<html>
<body>
What up This is in the HTML. <br/>

<?php 
include("mysqlInfo.php");
echo "Yo dawg this is the PHP.";

$servername = "localhost";
$username = USERNAME;
$password = PASSWORD; 
$dbname = "universityChallenge";


// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn){
	die("Connection failed: " . mysqli_connect_error());
}


// List all text strings
$q = "select questionNumGuess,textString from stageText";
$allText = mysqli_query($conn,$q);

if (mysqli_num_rows($allText) > 0) {
echo "<table>";
	while ($row = mysqli_fetch_assoc($allText)){
		echo "<tr><td>" . $row["questionNumGuess"] . "</td><td>" . $row["textString"] . "</td></tr>";}
	echo "</table>";

} else {
	echo "There are no rows in the stageText table";
}
?>

</body>
</html>
