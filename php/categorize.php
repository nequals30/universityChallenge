<?php
echo "Categorizing text ID " . $_GET["textId"] . " as category " . $_GET["cat"];

require 'conn.php';

$q = "update stageText set cat=" . $_GET["cat"] . " where text_id=" . $_GET["textId"];
if (mysqli_query($conn, $q)){
	header('Location: ' . $_SERVER["HTTP_REFERER"] );
	exit;
} else {
	echo mysqli_error($conn);
};
?>
