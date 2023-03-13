<?php
//database
$servername = "localhost";
$dBUsername = "id20381512_elsysprosjekt6";
$dBPassword = "ohanaElsys66!";
$dBName = "id20381512_ohanaband";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

$sql = "SELECT * FROM sensor;";
$result   = mysqli_query($conn, $sql);
$row  = mysqli_fetch_assoc($result);	

?>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="cssfiler/admin.css">-->
        <?php include("style.php")?>
        <?php include("stemme-style.php")?>
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
        <h2>Stemme</h2>
        <h3>Hva synes du om opptredenen?</h3>
        <section id="emoji">
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="emoji_button" type="submit" name="red_LED" value="&#128525;" />
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="emoji_button" type="submit" name="green_LED" value="&#128540;" />
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="emoji_button" type="submit" name="blue_LED" value="&#128559;" />
				</form>
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="emoji_button" type="submit" name="blue_LED" value=" &#128564;" />
				</form>
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="emoji_button" type="submit" name="blue_LED" value="&#128533;" />
				</form>
			</section>
        

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
			<h3>Velg fargen du ønsker å se:</h3>
			<section id="valg">
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="sfarge_button" type="submit" name="red_LED" value="Rød" />
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="farge_button" type="submit" name="green_LED" value="Grønn" />
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<input id="farge_button" type="submit" name="blue_LED" value="Blå" />
				</form>
			</section>
		</main>
	</body>
</html>