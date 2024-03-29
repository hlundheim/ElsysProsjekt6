<?php
$servername = "localhost";
$dBUsername = "id20381512_elsysprosjekt6";
$dBPassword = "ohanaElsys66!";
$dBName = "id20381512_ohanaband";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}
if (isset($_POST['update_status'])) {
	$sql = "SELECT * FROM Status;";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	$update = mysqli_query($conn, "UPDATE Status SET status = '".$_POST['update_status']."' WHERE id = 1;");
}

if (isset($_POST['reset_stemmer'])) {
	$sql = "UPDATE stemme SET stemmer = 0;";
	$update = mysqli_query($conn, $sql);
}

$sql2 = "SELECT stemmer FROM stemme;";
$result2  = mysqli_query($conn, $sql2);
$stemmer = array();
while ($row = mysqli_fetch_assoc($result2)) {
	array_push($stemmer, $row['stemmer']);
}

$sql3 = "SELECT navn FROM fargeEffekter WHERE id IN (SELECT status FROM Status where id = 1);";
$result3   = mysqli_query($conn, $sql3);
$navn  = mysqli_fetch_assoc($result3);	
?>



<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!--<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="cssfiler/admin.css">-->
		<?php include("style.php")?>
		<?php include("admin-style.php")?>
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
			<h2>Admin Siden</h2>
			<?php echo '<h3 style="text-align: center;">Nåværende fargeeffekt: '.$navn['navn'].'</h3>';?>
			<section id="grid-admin">
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<button id="submit_button" type="submit" name="update_status" value="0">Slå av LED</button>	
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
					<button id="submit_button" type="submit" name="reset_stemmer">Reset</button>	
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
					<button id="submit_button" type="submit" name="update_status" value="1">Rød</button>
					<?php echo '<h3 style="text-align: center;">'.$stemmer[0].'</h3>';?>
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="submit_button" type="submit" name="update_status" value="2">Grønn</button>	
					<?php echo '<h3 style="text-align: center;">'.$stemmer[1].'</h3>';?>		
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="submit_button" type="submit" name="update_status" value="3">Blå</button>
					<?php echo '<h3 style="text-align: center;">'.$stemmer[2].'</h3>';?>			
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="submit_button" type="submit" name="update_status" value="4">Lilla</button>
					<?php echo '<h3 style="text-align: center;">'.$stemmer[3].'</h3>';?>			
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="submit_button" type="submit" name="update_status" value="5">Oransje</button>
					<?php echo '<h3 style="text-align: center;">'.$stemmer[4].'</h3>';?>			
				</form>

				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="submit_button" type="submit" name="update_status" value="9">Regnbue</button>	
					<?php echo '<h3 style="text-align: center;">'.$stemmer[8].'</h3>';?>			
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="submit_button" type="submit" name="update_status" value="6">Rosa + Hvit</button>	
					<?php echo '<h3 style="text-align: center;">'.$stemmer[5].'</h3>';?>
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="submit_button" type="submit" name="update_status" value="7">Rød + Oransje</button>
					<?php echo '<h3 style="text-align: center;">'.$stemmer[6].'</h3>';?>			
				</form>
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">
					<button id="submit_button" type="submit" name="update_status" value="8">Blå + Grønn</button>	
					<?php echo '<h3 style="text-align: center;">'.$stemmer[7].'</h3>';?>			
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

