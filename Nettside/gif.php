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

?>

<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php include("style.php")?>
        <?php include("gif-style.php")?>
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
            <section id="grid-gif">
                <form action="gif.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button  class="hoverable" id="show1" type="submit" name="toggle_LED" value="10"></button>
				</form>
                <form action="gif.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button  class="hoverable" id="show2" type="submit" name="toggle_LED" value="11"></button>
				</form>
                <form action="gif.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button  class="hoverable" id="show3" type="submit" name="toggle_LED" value="12"></button>
				</form>

            
            </section>


        </main>
        <footer>

        </footer>
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
