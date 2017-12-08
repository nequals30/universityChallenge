<?php
echo 'Updating text ID ' . $_GET["textId"] . ' to value "' . $_POST["textStr"] . '"';

require 'conn.php';

$q = "update stageText set textString='" . addslashes($_POST["textStr"]) . "' where text_id=" . $_GET["textId"];
if (mysqli_query($conn, $q)){
	header('Location: ' . $_SERVER["HTTP_REFERER"] );
	exit;
} else {
	echo mysqli_error($conn);
};
?>
