<?
require "/../db.php";
session_start();

if(empty($_SESSION['login'])){
	header('Location: index.php');
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['addproduct'])){
    	if($_POST['type'] === 'arts'){
			$target_dir = "../img/arts/";
    	}
		else{
			$target_dir = "../img/postcards/";
		}
		$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		if ($_FILES["fileToUpload"]["size"] > 5000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        $src_img =  basename( $_FILES["fileToUpload"]["name"]);
				$data = $_POST;
				$products = R::dispense('products');
				$products->name 		 = $data['name'];
				$products->canvas 	   	 = $data['canvas'];
				$products->img 			 = $src_img;
				$products->size          = $data['size'];
				$products->existence     = $data['existence'];
				$products->booking       = $data['booking'];
				$products->type          = $data['type'];
				$products->price         = $data['price'];
				R::store($products);
				echo "<script> alert('Product added !!!') </script>";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}


	if(isset($_POST['editproduct'])){
			$data = $_POST;
			$sql = "update products set 
				name      = '".$data['ename']."',
				canvas    =	'".$data['ecanvas']."',
				size      =	'".$data['esize']."',
				existence =	'".$data['eexistence']."',
				booking   =	'".$data['ebooking']."',
				type      =	'".$data['etype']."',
				price     =	'".$data['eprice']."'
					 where id = ".$data['eid'];
					 //echo $sql;
			R::exec($sql);
	}
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
			<h2 > Товары </h2>
			<button class="btn-success"> Добавить </button>
			<table border="1">
				<tr>
				    <th>id</th>
				    <th>Название</th>
				    <th>Холст</th>
				    <th>View</th>
				    <th>Размер</th>
				    <th>В наличии</th>
				    <th>Заказ</th>
				    <th>Тип</th>
				    <th>Цена</th>
				    <th>Рдк</th>
				    <th>Удл</th>
				 </tr>
				 <?
					$products = R::getAll( 'SELECT * FROM products');
					foreach($products as $product) {
						echo "<tr>\n";
							echo "<td>".$product['id']."</td>\n";
							echo "<td>".$product['name']."</td>\n";
							echo "<td>".$product['canvas']."</td>\n";
							echo "<td align='center'><img src='../img/".$product['type'].'/'.$product['img']."'></td>\n";
							echo "<td>".$product['size']."</td>\n";
							echo "<td>".$product['existence']."</td>\n";
							echo "<td>".$product['booking']."</td>\n";
							echo "<td>".$product['type']."</td>\n";
							echo "<td>".$product['price']."</td>\n";
							echo "<td>
										<i id='".$product['id']."' class='fa fa-pencil-square-o' aria-hidden='true'></i>
								   </td>\n";
							echo "<td>
										<i id='".$product['id']."' class='fa fa-times' aria-hidden='true'></i>
									</td>\n";
						echo '</tr>';
				    }
				?>
			 </table>
		</div>
	</div>


 <div class="actproduct" id="add">
 	<h1> Add product  <i class="fa fa-window-close-o" id="close-a" aria-hidden="true"></i> </h1>
	<form action="" method="POST"  enctype="multipart/form-data">
		<input type="text" name="name" placeholder="Название">
		<input type="text" name="canvas" placeholder="Холст">
		<input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this);">
		<img id="blah" src="/../img/empty-img.png" alt="your image" />
		<input type="text" name="size" placeholder="Размер">
		<input type="text" name="existence" placeholder="В наличии">
		<input type="text" name="booking" placeholder="Заказ">
		<select name="type">
			<option selected value="arts"> ARTS </option>
			<option 		value="postcards"> POSTCARDS </option>
		</select>
		<input type="number" name="price" placeholder="Цена">
		<input type="submit" name="addproduct" value="ADD">
	</form>
</div>

 <div class="actproduct"  id="edit">
 	<h1> Edit product  <i class="fa fa-window-close-o" id="close-e" aria-hidden="true"></i> </h1>
	<form action="" method="POST"  enctype="multipart/form-data">
		<input type="hidden" name="eid" placeholder="id">
		<input type="text" name="ename" placeholder="Название">
		<input type="text" name="ecanvas" placeholder="Холст">
		<img src="" id="seimg" alt="your image" />
		<input type="text" name="esize" placeholder="Размер">
		<input type="text" name="eexistence" placeholder="В наличии">
		<input type="text" name="ebooking" placeholder="Заказ">
		<select name="etype">
			<option selected value="arts"> ARTS </option>
			<option 		value="postcards"> POSTCARDS </option>
		</select>
		<input type="number" name="eprice" placeholder="Цена">
		<input type="submit" name="editproduct" value="SAVE">
	</form>
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
    $(".btn-success").click(function(){
        $("#add").slideToggle('slow');
    });
    $(".fa-pencil-square-o").click(function(){
        $("#edit").slideToggle('slow');
	        var id = $(this).attr('id');
	        console.log(id);
	        var response = "";
	        $.ajax({ type: "GET",   
	                 url: "api.php?action=editproduct&id=".concat(id),   
	                 success : function(text)
	                 {
	                     var arr = JSON.parse(text);
	                     $('input[name=eid]').val(arr['id']);
	                     $('input[name=ename]').val(arr['name']);
	                     $('input[name=ecanvas]').val(arr['canvas']);
	                     $('#seimg').attr('src', '../img/'+arr['type']+'/'+arr['img']);
	                     $('input[name=esize]').val(arr['size']);
	                     $('input[name=eexistence]').val(arr['existence']);
	                     $('input[name=ebooking]').val(arr['booking']);
	                     $('input[name=etype]').val(arr['type']);
	                     $('input[name=eprice]').val(arr['price']);
	                 }
		});
    });

    $(".fa-times").click(function(){
	    var id = $(this).attr('id');
	    console.log(id);
	    var response = "";
	    $.ajax({ type: "GET",   
	        url: "api.php?action=remproduct&id="+id,   
	        success : function(text){
	            //console.log(text);
	           window.location.reload();
	        }
		});
    });


    $("#close-a").click(function(){
        $("#add").slideToggle('slow');
    });
    $("#close-e").click(function(){
        $("#edit").slideToggle('slow');
    });
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

function readURL(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        $('#blah')
	            .attr('src', e.target.result)
	            .width(150)
	            .height(200);
	    };
	    $("#blah").show("slow");
	    reader.readAsDataURL(input.files[0]);
	}
}
</script>

</body>
</html>