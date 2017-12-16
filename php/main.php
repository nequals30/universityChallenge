<html>

<head>
<style>
body {font-family: "Arial";}
td {width: 300px;}
td a{width:100%;display:block;text-align:center}
a{padding:15px;color:white;background-color:#7daaf2;text-decoration:none;}
a:hover{background-color:#3281ff;font-weight:bold}
th {font-size:200%}
</style>

<body>
<?php
echo '<h1>University Challenge Question Databse</h3>';
echo 'The following links contain the questions of each University Challenge episode. Sorry about the formatting, I will come back and improve it later.<br/><br/><br/>';
require 'conn.php';
$qs = 'select distinct(season) from question;';
$allS = mysqli_query($conn,$qs);
while ($rowS = mysqli_fetch_assoc($allS)){
	$qe = 'select distinct(episode) from question where season=' . $rowS["season"];
	$allE = mysqli_query($conn,$qe);
	echo '<table><th>Season ' . $rowS["season"] . '</th>';

	while ($rowE = mysqli_fetch_assoc($allE)){
		echo '<tr><td><a href="episode.php?s=' . $rowS["season"] . '&e=' . $rowE["episode"] . '">Episode ' . $rowE["episode"] . '</a></td></tr>';
	}
	echo '</table><br/>';
}
?>
</body>
</html>
