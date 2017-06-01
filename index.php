<?php
if(isset($_POST['bid'])){
	require 'db.php';
	$data = $_POST;
	$bid = R::dispense('bid');
	$bid->name 			= $data['name'];
	$bid->phone 		= $data['phone'];
	$bid->email 		= $data['email'];
	$bid->message       = $data['message'];
	R::store($bid);
	echo "<script> alert('Ваша заявка принята !!!') </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Satulana.kz</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
	<div class="main-wrapper">
		<header id="top">
			<div class="logo">
				<img src="img/main_logo.png" alt="logo">
			</div>
			<ul class="main-menu">
				<li><a href=""> shop </a></li>
				<li><a href="#about"> about </a></li>
				<li><a href="#contacts"> contacts </a></li>
				<li><a href="basket.php"> 
					<i class="fa fa-shopping-cart" aria-hidden="true"></i> |
					<span id="basket"> (0) </span>
					</a> 
				</li>
			</ul>
		</header>

		<div class="main-category">
			<div>
			<div class="arrow-right"></div>
				<div class="middle">
				<a href="arts.php">
					<h1>arts</h1>
					<h2>----</h2>
					<h3>see more</h3>
				</a>
				</div>

			</div>
			<div class="artsb"></div>
			<div class="postcardsb"></div>
			<div>
				<div class="arrow-left"></div>
				<div class="middle">
				<a href="arts.php">
					<h1>postcards</h1>
					<h2>----</h2>
					<h3>see more</h3>
				</a>
				</div>

			</div>
		</div>
		<div id="about" class="about">
			<p> Hello to everyone! </p>
			<p> My name is Bella♥ I am an enthusiastic and inspired lady from Russia. I am an amateur artist. So, on this site you can see my paintings ♥ and order a replica or an individual picture.
			</p>
			<h1> INSTAGRAM </h1>
			<h1> --------- </h1>
			<div class="instagram">
				<img src="img/postcards/1.png">
				<img src="img/postcards/2.png">
				<img src="img/postcards/3.png">
			</div>
		</div>


		<div id="contacts" class="contacts">
			<h1> For any questions you can contact me by sending a form: </h1>
			<form action="" method="POST">
				<input type="text" name="name" id="fname" placeholder="Your name">
				<input type="text" name="phone" id="fphone" placeholder="Phone">
				<input type="text" name="email" id="femail" placeholder="E-mail">
				<textarea name="message" placeholder="Your message"></textarea>
				<input type="submit" name="bid" value="SAVE MESSAGE">
			</form>	
		</div>

		<div class="footer">
			<a href="#top"> <i class="fa fa-angle-up" aria-hidden="true"></i> </a>
			<a href="#top"> <i class="fa fa-instagram" aria-hidden="true"></i> </a>
			<p> Satulana &copy 2017 All Rights Reserved.</p>
		</div>

	</div>

	<script>

	$(document).ready(function(){
	  
	  $("a").on('click', function(event) {
	    if (this.hash !== "") {
	      event.preventDefault();
	      var hash = this.hash;
	      $('html, body').animate({
	        scrollTop: $(hash).offset().top
	      }, 800, function(){
	        window.location.hash = hash;
	      });
	    } 
	  });


	});
</script>

</body>
</html>