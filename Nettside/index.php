<?php
$servername = "localhost";
$dBUsername = "id20381512_elsysprosjekt6";
$dBPassword = "ohanaElsys66!";
$dBName = "id20381512_ohanaband";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

?>

<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("style.php")?>
        <?php include("index-style.php")?>
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
            <section>
                <img id="forside" src="https://gfx.nrk.no/qSeb9K7ydZWQrLgY45w_rwdXUl171OjJ3CM_QVTxhJhg" alt="">
                <?php echo '<a class="bildetekst" href="minside.php">LOGG INN</a>';?>
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
