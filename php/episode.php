<html>

<head>
<style>
body {font-family: "Arial";}
th, td {padding: 15px;}
</style>

<body>

<?php
echo "<h2>Season " . $_GET["s"] . ", Episode " . $_GET["e"] . "</h2><hr/>";

require 'conn.php';

$q = "select question,question.subQuestion,question.phraseType,phraseText from question " .
	"where season=" . $_GET["s"] . " and episode=" . $_GET["e"] . " " .
	"order by question,subQuestion,phraseType";

$allQs = mysqli_query($conn,$q);

$color_start = "#98d2e2";
$color_bonusIntro = "#fffa84";

$nResults = mysqli_num_rows($allQs);

if ($nResults > 0) {
	$counter = 0;
	echo '<table style="padding: 15px"><tr><th>Q#</th><th>Question</th><th>Incorrect Answer</th><th>Correct Answer</th></tr>';
	$prevSQ = 0;
	$prevQ = 0;
	$thisQuestion = '';
	$thisRight = '';
	$thisWrong = '';
	while ($row = mysqli_fetch_assoc($allQs)){
		$counter++;
		if (($row["subQuestion"] != $prevSQ) or ($row["question"] != $prevQ) or ($counter == $nResults)) {
			// Print question and reset variables
			if ($thisQuestion != ''){
				if ($prevSQ==1) {
					echo '<tr style="background-color: ' . $color_start . '">';
				} else {
				       	echo '<tr>'; 
				}
				echo '<td>' . $prevQ . '</td>' .
				     '<td>' . $thisQuestion . '</td>' .
				     '<td>' . $thisWrong . '</td>' .
				     '<td>' . $thisRight . '</td>' .
				     '</tr>';
			}
			if ($row["subQuestion"] == 2){
				echo '<tr style="background-color:' . $color_bonusIntro . '"><td colspan="4">' .
					$row["phraseText"] . '</td></tr>';
			}
			$thisQuestion = '';
			$thisRight = '';
			$thisWrong = '';
		}
		if ($row["phraseType"] == 1){
			$thisQuestion = $row["phraseText"];
		} elseif ($row["phraseType"] == 2){
			$thisRight = $row["phraseText"];
		} elseif ($row["phraseType"] == 3){
			$thisWrong = $row["phraseText"];
		}
		$prevSQ = $row["subQuestion"];
		$prevQ = $row["question"];
	};
	echo '</table>';
} else {
	echo "Missing data for this episode.";
}
?>
</body>
</html>
