<?php
$cssFiles = '
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet"  href="assets/css/slidestyle.css" />';
require_once('includes/header.php');
?>

<main>
	<div class="header"> <img src="./images/header.png"></div>
<span><p>Best Sellers</p></span>

<div class="books">
<div class="row">
  <div class="column">
	 <div class="container">
    <img src="./images/MISTRESS OF ROME.png" alt="mistress" style="width:90%">
		 <div class="text-block"><p>$16.50</p></div> </div>
	</div>
	  
  <div class="column">
	  <div class="container">
    <img src="./Images/katequeen.png" alt="katequeen" style="width:90%">
	  	 <div class="text-block"><p>$13.50</p> </div>
	  </div>
	  </div>
	  
  <div class="column">
	  <div class="container">
    <img src="./Images/THE SERPENT AND THE PEARL.png" alt="Serpent and Pearl" style="width:90%">
	  	 <div class="text-block"><p>$14.50</p></div>
  </div>
	  </div>

</div> 
</div>
<span><p>Popular Books in Canada</p></span>
	
<div id="content-wrapper">
		<div class="column">
			<div id="slide-wrapper" >
				<img id="slideLeft" class="arrow" src="assets/images/arrow-left.png">
				 <div id="slider">
					<div><img class="thumbnail active" src="./images/LESSONS IN CHEMISTRY.png"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/WHO BY FIRE.png"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/BE A TRIANGLE.png"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/RUN TOWARDS THE DANGER.png"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/TEN STEPS TO NANETTE.png"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/palace.jpeg"><button id="button-service" onclick="window.location.href='book.php'l'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/22 murders.jpeg"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/it ends.jpeg"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/DREAM.WEBP"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/FREEZING.JPEG"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/HELLO.JPEG"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					<div><img class="thumbnail" src="./images/IMAGINE.WEBP"><button id="button-service" onclick="window.location.href='book.php'">Add to Cart</button></div>
					
				</div>

				<img id="slideRight" class="arrow" src="assets/images/arrow-right.png">
			</div>
		</div>

	</div>

		<script type="text/javascript" src="script.js"></script>
	

	
</main>


<?php
require_once('includes/footer.php');
?>