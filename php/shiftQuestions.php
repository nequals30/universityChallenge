<?php
echo 'Shifting questions up after textID ' . $_GET["textId"]; 

require 'conn.php';

$q = "update stageText set questionNumGuess= (questionNumGuess+1) where text_id>=" . $_GET["textId"];
if (mysqli_query($conn, $q)){
	header('Location: ' . $_SERVER["HTTP_REFERER"] );
	exit;
} else {
	echo mysqli_error($conn);
};
?>
