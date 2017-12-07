<?php
echo 'Moving text ID ' . $_GET["textId"] . ' to question ' . $_POST["qNum"];

require 'conn.php';

$q = "update stageText set questionNumGuess=" . $_POST["qNum"] . " where text_id=" . $_GET["textId"];
if (mysqli_query($conn, $q)){
	header('Location: ' . $_SERVER["HTTP_REFERER"] );
	exit;
} else {
	echo mysqli_error($conn);
};
?>
