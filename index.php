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
        <?php include("index-style.php")?>
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
            <section>
                <img id="forside" src="https://gfx.nrk.no/qSeb9K7ydZWQrLgY45w_rwdXUl171OjJ3CM_QVTxhJhg" alt="">
                <?php echo '<a class="bildetekst" href="minside.php">LOGG INN</a>';?>
            </section>

        </main>
        <footer>

        </footer>
    </body>
</html>