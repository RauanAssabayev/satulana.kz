<?php
require "/../db.php";
session_start();
if(isset($_GET['switchstatus'])){
	$sQuery = "UPDATE quizes SET status=".$_GET['switchstatus']." WHERE code = '".$_GET['code']."'";
	R::exec($sQuery);
	echo $sQuery;
}
elseif(isset($_GET['code'])){
	$sQuery = "select * from questions WHERE quiz_code = '".$_GET['code']."' and number = '".$_GET['id']."'" ;
	$rows = R::getAll($sQuery);
	//echo $sQuery;
	print json_encode($rows);
}elseif(isset($_GET['qcode'])){
	$answers = R::dispense('answers');
	$answers->email = $_SESSION['email'];
	$answers->quiz_code = $_GET['qcode'];
	$answers->number = $_GET['number'];
	$answers->answer = $_GET['ans'];
	R::store($answers);
	$sQuery = "UPDATE passquiz SET penalty= ".$_GET['penalty']." WHERE email = '".$_SESSION['email']."' and quiz_code = '".$_GET['qcode']."'";
	R::exec($sQuery);
	echo $sQuery;
	//print json_encode($rows);
}elseif(isset($_GET['fcode'])){
	$sQuery = "UPDATE passquiz SET status = 1 WHERE email = '".$_SESSION['email']."' and quiz_code = '".$_GET['fcode']."'";
	R::exec($sQuery);
	//header('Location: main.php');
	echo $sQuery;
}else echo "ERROR";

