<?php
echo "<h2>Season " . $_GET["s"] . ", Episode " . $_GET["e"] . "</h2><hr/>";

require 'conn.php';

$q = "select phraseText from question where phraseType=1";
$allQs = mysqli_query($conn,$q);

if (mysqli_num_rows($allQs) > 0) {
	echo '<table><tr><th>Question</th><th>Incorrect Answer</th><th>Correct Answer</th></tr>';
	while ($row = mysqli_fetch_assoc($allQs)){
		echo '<tr><td>' . $row["phraseText"] . '</td>';
		echo '<td>na</td><td>na</td></tr>';	
	};
	echo '</table>';
} else {
	echo "Missing data for this episode.";
}

?>
