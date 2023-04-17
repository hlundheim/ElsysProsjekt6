<?php
$servername = "localhost";
$dBUsername = "id20381512_elsysprosjekt6";
$dBPassword = "ohanaElsys66!";
$dBName = "id20381512_ohanaband";
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

if (isset($_POST['update_band'])) {
	$sql = "SELECT * FROM fargeEffekter WHERE id IN (SELECT status FROM Status where id = 1)";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	echo strval($row['R1']).','.strval($row['G1']).','.strval($row['B1']).','.strval($row['multiColor']).','.strval($row['R2']).','.strval($row['G2']).','.strval($row['B2']).','.strval($row['alternating']).','.strval($row['looping']).','.strval($row['rainbow']);
}	

?>
