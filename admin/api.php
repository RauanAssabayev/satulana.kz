<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty";

require "/../db.php";
if($_GET['action'] === 'remproduct'){
	$sQuery = "select img,type from products where id=".$_GET['id']." LIMIT 1" ;
	$rows = R::getRow($sQuery);
	$src = "../img/".$rows['type']."/".$rows['img'];
	unlink($src);
	$sql = "DELETE FROM products WHERE id = ".$_GET['id'];
	R::exec($sql);
}


if($_GET['action'] === 'editproduct'){
	$sQuery = "select * from products where id=".$_GET['id']." LIMIT 1" ;
	$rows = R::getRow($sQuery);
	echo json_encode($rows);
}

?>