<?php
$servername = "localhost";
$dBUsername = "id20381512_elsysprosjekt6";
$dBPassword = "ohanaElsys66!";
$dBName = "id20381512_ohanaband";
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

if (isset($_POST['check_LED_status'])) {
	$sql = "SELECT * FROM fargeEffekter WHERE id IN (SELECT status FROM sensor where id = 1)";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	echo strval($row['R1']).','.strval($row['G1']).','.strval($row['B1']);
}	
	
?>
