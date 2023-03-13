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
	$update = mysqli_query($conn, "UPDATE sensor SET status = '".$_POST['toggle_LED']."' WHERE id = 1;");
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
						<?php echo '<a href="test.php">Min Side</a>';?>
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
					<button id="submit_button" type="submit" name="toggle_LED" value="0">Slå på LED</button>	
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
			</section>
			<h3>Velg farge på led:</h3>
			<section id="valg">
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="submit_button" type="submit" name="toggle_LED" value="1">Rød</button>	
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="submit_button" type="submit" name="toggle_LED" value="2">Grønn</button>			
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="submit_button" type="submit" name="toggle_LED" value="3">Blå</button>				
				</form>
			</section>
		</main>
	</body>
</html>

