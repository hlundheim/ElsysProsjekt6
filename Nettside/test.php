<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
							<?php echo '<a href="test.php">Min Side</a>';?>
							<?php echo '<a href="admin.php">Admin</a>';?>
						</nav>
					</section>
			</section>

        </header>
        <main>
        <h2>Stemme</h2>
        <h3>Hva synes du om opptredenen?:</h3>
        <section id="emoji_grid">
				<form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" rel="first" value="">&#128525;</button>
                    <p id="first"></p>	
				</form>
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" rel="first" value="">&#128525;</button>
                    <p id="first"></p>	
				</form>
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" rel="first" value="">&#128525;</button>
                    <p id="first"></p>	
				</form>
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" rel="first" value="">&#128525;</button>
                    <p id="first"></p>	
				</form>
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">			
                    <button id="emoji_button" type="submit" name="toggle_LED" rel="first" value="">&#128525;</button>
                    <p id="first"></p>	
				</form>
		
			<h3>Velg fargen du ønsker å se:</h3>
			<section id="farge_grid">
                <form action="admin.php" method="post" id="LED" enctype="multipart/form-data">	
					<button id="farge_button" type="submit" name="toggle_LED" rel="second" value="">Rosa + Hvit</button>
                    <p id="second"></p>	
				</form>

			</section>

            <script>
                var dudes = document.querySelectorAll('.btn');
                dudes = Array.prototype.slice.call( dudes );

                dudes.forEach(function (dude) {

                    updateDude( dude );

                    // on click, increase score
                    dude.addEventListener('click', function () {

                        increaseScore(dude);

                    });

                });

                // first -> scoreFirst
                function getKeyFrom( dude ) {
                    return 'score' + _.capitalize( dude.getAttribute('rel') );
                }

                // get scoreFirst from localStorage
                function getScore( dude ) {
                    return +localStorage.getItem( getKeyFrom(dude) ) || 0;
                }

                // set scoreFirst in localStorage
                function setScore( dude, score ) {
                    localStorage.setItem( getKeyFrom(dude), score );
                }

                // update scoreFirst in localStorage
                function updateDude( dude ) {
                    var score   = getScore(dude),
                        element = document.querySelector('#' + dude.getAttribute('rel'));
                    element.textContent = score;
                }

                // increase scoreFirst in localStorage
                function increaseScore(dude) {
                    var score = getScore(dude);
                    score++;

                    setScore(dude, score);

                    updateDude(dude);
                }

            </script>
		</main>
	</body>
</html>