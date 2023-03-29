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

if (isset($_POST['toggle_LED'])) {
	$sql = "SELECT * FROM sensor;";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	$update = mysqli_query($conn, "UPDATE stemme SET stemmer = stemmer + 1  WHERE id = '".$_POST['toggle_LED']."';");
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("style.php")?>
        <?php include("stemme-style.php")?>
    </head>
    <body>
        <header>
            <section id="mobil">
                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
                </a>
            </section>
            <section class="gridcontainer" id="myLinks">
				<section class="gridelement">
						<?php echo '<a href="index.php">
							<h1>OHANA</h1>
						</a>';?>
				</section>
				<section class="gridelement">
						<nav>
							<?php echo '<a href="index.php">Hjem</a>';?>
							<?php echo '<a href="stemme.php">Stemme</a>';?>
							<?php echo '<a href="gif.php">Visning</a>';?>
							<?php echo '<a href="minside.php">Min Side</a>';?>
							<?php echo '<a href="admin.php">Admin</a>';?>
						</nav>
					</section>
			</section>

        </header>
        <main>
        <h2>Stemme</h2>
        <h3>Hva synes du om opptredenen?:</h3>
        <section id="emoji_grid">
				<form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" value="3">&#128525;</button>
				</form>
				<form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" value="2">&#128540;</button>
				</form>
				<form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" value="5">&#128559;</button>
				</form>
                <form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" value="4">&#128564;</button>	
				</form>
                <form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" value="1">&#128533; </button>	
				</form>

			</section>
				<script type="text/javascript">
					$(document).ready (function () {
						var updater = setTimeout (function () {
							$('div#refresh').load ('stemme.php', 'update=true');
						}, 1000);
					});
				</script>
			</section>

			<h3>Velg fargen du ønsker å se:</h3>
			<section id="farge_grid">
                <form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="farge_button" type="submit" name="toggle_LED" value="">Rosa + Hvit</button>	
				</form>
				<form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="farge_button" type="submit" name="toggle_LED" value="">Rød + Oransje</button>			
				</form>
				<form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="farge_button" type="submit" name="toggle_LED" value="">Blå + Grønn</button>				
				</form>
                <form action="stemme.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="farge_button" type="submit" name="toggle_LED" value="">Regnbue</button>				
				</form>
			</section>
		</main>
		<script type="text/javascript">
            function myFunction() {
                var x = document.getElementById("myLinks");
                if (x.style.display === "block") {
                x.style.display = "none";
                } else {
                x.style.display = "block";
                }
            } 
        </script>
	</body>

</html>