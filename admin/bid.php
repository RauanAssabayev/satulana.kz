<?
require "/../db.php";
session_start();

if(empty($_SESSION['login'])){
	header('Location: index.php');
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
   
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['logout'])){
    	session_destroy(oid);
    	session_unset(oid);
    	header('Location: index.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ADMIN</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="main-wrapper">
			<ul>
				<li> <a class="btn-info active" href="main.php"> Товары </a> </li>
				<li> <a class="btn-info " href="orders.php"> Заказы </a> </li>
				<li> <a class="btn-info danger" href="bid.php"> Заявки </a> </li>
				<li> <button class="btn-info warning"> 
					<i class="fa fa-user-circle" aria-hidden="true"></i>
					<?=$_SESSION['login']?>  
					<i class="fa fa-angle-down" aria-hidden="true">
						<ul id="slidemenu">
							<li id="editprofile"> Edit </li>
							<li><a href="main.php?logout=1"> Logout </a> </li>
						</ul>
					</i>

					</button> 
				</li>
			</ul>
		<div class="product">
			<h2 > Заказы </h2>
			<table border="1">
				<tr>
				    <th>id</th>
				    <th>Name</th>
				    <th>Phone</th>
				    <th>Email</th>
				    <th>Message</th>
				    <th>Rem</th>
				 </tr>
				 <?
					$bids = R::getAll( 'SELECT * FROM bid');
					foreach($bids as $bid) {
						echo "<tr>\n";
							echo "<td>".$bid['id']."</td>\n";
							echo "<td>".$bid['name']."</td>\n";
							echo "<td>".$bid['phone']."</td>\n";
							echo "<td>".$bid['email']."</td>\n";
							echo "<td width='50%'>".$bid['message']."</td>\n";
							echo "<td>
										<i id='".$product['id']."' class='fa fa-times' aria-hidden='true'></i>
									</td>\n";
						echo '</tr>';
				    }
				?>
			 </table>
		</div>
	</div>


 <div class="actproduct"  id="edituser">
 	<h1> Edit profile  <i class="fa fa-window-close-o" id="close-es" aria-hidden="true"></i> </h1>
	<form action="" method="POST"  enctype="multipart/form-data">
		<input type="text" name="login" placeholder="Login">
		<input type="text" name="email" placeholder="Email">
		<input type="password" name="password" placeholder="Password">
		<input type="submit" name="editproduct" value="SAVE">
	</form>
 </div>



<script>
$(document).ready(function(){
 
    $("#close-es").click(function(){
        $("#edituser").slideToggle('slow');
    });

    $("#editprofile").click(function(){
    	$("#edituser").slideToggle('slow');
    });
    $(".fa-angle-down").click(function(){
    	$("#slidemenu").slideToggle('slow');
    });


});

</script>

</body>
</html>