<?php
$servername = "localhost";
$dBUsername = "id20381512_elsysprosjekt6";
$dBPassword = "ohanaElsys66!";
$dBName = "id20381512_ohanaband";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}


if (isset($_POST['toggle_LED'])) {
	$sql = "SELECT * FROM sensor;";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	
	if($row['status'] == 0){
		$update = mysqli_query($conn, "UPDATE sensor SET status = 1 WHERE id = 1;");		
	}		
	else{
		$update = mysqli_query($conn, "UPDATE sensor SET status = 0 WHERE id = 1;");		
	}
}


$sql = "SELECT * FROM sensor;";
$result   = mysqli_query($conn, $sql);
$row  = mysqli_fetch_assoc($result);	

?>



<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="cssfiler/admin.css">-->
		<?php include("style.php")?>
		<?php include("admin-style.php")?>
	</head>
	<body>
		<header>
			<section class="gridcontainer">
				<section class="gridelement">
					<?php echo '<a href="index.php">
						<h1>OHANA</h1>
					</a>';?>
				</section>
				<section class="gridelement">
					<nav>
						<?php echo '<a href="index.php">Hjem</a>';?>
						<?php echo '<a href="stemme.php">Stemme</a>';?>
						<?php echo '<a href="minside.php">Min Side</a>';?>
						<?php echo '<a href="admin.php">Admin</a>';?>
					</nav>
				</section>
			</section>

		</header>
		<main>
			<h2>Admin Siden</h2>
			<section class="">
				<?php echo '<h3 style="text-align: center;">The status of the LED is: '.$row['status'].'</h3>';?>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="submit_button" type="submit" name="toggle_LED" value="Slå på LED" />
				</form>

				<script type="text/javascript">
					$(document).ready (function () {
						var updater = setTimeout (function () {
							$('div#refresh').load ('admin.php', 'update=true');
						}, 1000);
					});
				</script>

				<br>
				<br>
				<!--<?php
					if($row['status'] == 0){?>
					<div class="led_img">
						<img id="contest_img" src="led_off.png" width="100%" height="100%">
					</div>
					<?php	
						}
						else{ ?>
						<div class="led_img">
							<img id="contest_img" src="led_on.png" width="100%" height="100%">
						</div>
					<?php
						}
				?>-->
			</section>
			<h3>Velg farge på led:</h3>
			<section id="valg">
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="submit_button" type="submit" name="red_LED" value="Rød" />
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="submit_button" type="submit" name="green_LED" value="Grønn" />
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="submit_button" type="submit" name="blue_LED" value="Blå" />
				</form>
			</section>
		</main>
	</body>
</html>

