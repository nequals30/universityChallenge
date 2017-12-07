<!DOCTYPE html>
<html>
<body>

<?php 

echo "<h3>Question " . $_GET["question"] . "</h3>";

require 'conn.php';

// List all text strings
$q = "select text_id,textString,cat from stageText where questionNumGuess=" . $_GET["question"];
$allText = mysqli_query($conn,$q);

if (mysqli_num_rows($allText) > 0) {
echo "<table><tr><th>Question</th><th>Categorize</th>";
	while ($row = mysqli_fetch_assoc($allText)){
		switch ($row["cat"]){
		case 0: //nothing
			$rcolor = "white";
			break;
		case 1: // starter question
			$rcolor = "#67a3f7";
			break;
		case 2: // correct answer
			$rcolor = "#00ff3b";
			break;
		case 3: // wrong answer
			$rcolor = "#e03800";
			break;
		case 4: // bonus intro 
			$rcolor = "#f4f767";
			break;
		case 5: // bonus question 
			$rcolor = "#ed2bff";
			break;
		case 6: // starter interrupt 
			$rcolor = "#ffbb00";
			break;
		}
		echo '<tr style="background-color:' . $rcolor . '"><td>' . $row["textString"] . '<td nowrap>';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=0">none</a>]';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=1">start</a>]';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=2">right</a>]';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=3">wrong</a>]';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=4">intro</a>]';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=5">bonus</a>]';
		echo '[<a href="categorize.php?textId=' . $row["text_id"] . '&cat=6">inter</a>]';
		echo '[<a href="fix.php?textId=' . $row["text_id"] . '">fix</a>]';
		echo '</td></tr>';
		;}
	echo "</table>";

} else {
	echo "There are no rows in the stageText table";
}
echo '<hr/><a href="organizeText.php?question='.($_GET["question"]-1).'"><< Prev</a><span style="float:right;"><a href="organizeText.php?question='.($_GET["question"]+1).'">Next >></a></span>';
?>

</body>
</html>
