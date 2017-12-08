<?php
require 'conn.php';

echo "<h3>Text ID:" . $_GET["textId"] . "</h3><hr/>";

$q = "select textString,cat,questionNumGuess from stageText where text_id=" . $_GET["textId"];
$qInfo = mysqli_query($conn,$q);

if (mysqli_num_rows($qInfo) > 0) {
	while ($row = mysqli_fetch_assoc($qInfo)){
		echo $row["textString"] . "<hr/>";
		echo '<form action="updateQnum.php?textId=' . $_GET["textId"] . '" method="post">Question: <input type="text" name="qNum" value="' .$row["questionNumGuess"] . '" size="3">&nbsp&nbsp&nbsp&nbsp<input type="submit" value="Fix Q Num"></form><hr/>';
		echo '<form action="updateTextString.php?textId=' . $_GET["textId"] . '" method="post">String: <input type="text" name="textStr" value="' . $row["textString"] . '" size="40"><br/><input type="submit" value="Update Text"></form><hr/>';
		echo '<a href="organizeText.php?question=' . $row["questionNumGuess"] . '">Return to Question</a>';
	}
} else {
	echo "No question exists with that text ID. Wierd.";
}	
?>
