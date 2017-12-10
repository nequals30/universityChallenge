<?php
echo "<h2>Season " . $_GET["s"] . ", Episode " . $_GET["e"] . "</h2><hr/>";

require 'conn.php';

$q = "select question,question.subQuestion,question.phraseType,phraseText from question " .
//	"left join question_infoSubQuestion on (question.subQuestion = question_infoSubQuestion.subQuestion) " .
	"where season=" . $_GET["s"] . " and episode=" . $_GET["e"] . " " .
//	"and question_infoSubQuestion.description='bonus intro'";
	"order by question,subQuestion,phraseType";

$allQs = mysqli_query($conn,$q);

if (mysqli_num_rows($allQs) > 0) {
	echo '<table><tr><th>Q#</th><th>Question</th><th>Incorrect Answer</th><th>Correct Answer</th></tr>';
	$prevSQ = 0;
	$prevQ = 0;
	$thisQuestion = '';
	$thisRight = '';
	$thisWrong = '';
	while ($row = mysqli_fetch_assoc($allQs)){
		if (($row["subQuestion"] != $prevSQ) or ($row["question"] != $prevQ)) {
			// Print question and reset variables
			if ($thisQuestion != ''){
				echo '<tr><td>' . $prevQ . '</td>' .
				     '<td>' . $thisQuestion . '</td>' .
				     '<td>' . $thisWrong . '</td>' .
				     '<td>' . $thisRight . '</td>' .
				     '</tr>';
			}
			if ($row["subQuestion"] == 2){
				echo '<tr style="background-color:yellow"><td colspan="4">' .
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
