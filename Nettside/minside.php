<?php
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("style.php")?>
        <?php include("minside-style.php")?>
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


        </main>
        <footer>

        </footer>
    </body>
</html>
