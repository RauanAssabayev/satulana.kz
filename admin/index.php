<?

require "../db.php";

// $admins = R::dispense('admins');
// $admins->login = 'dinara';
// $admins->email = 'dinara.aitaeva@is.sdu.edu.kz';
// $admins->password = md5('12345');
// R::store($admins);


if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['login'])){
    	$loginsql = "select * from admins where login = '".$_POST['login']."'
		and password = '".md5($_POST['password'])."' ";
		$admins	 = R::getAll($loginsql);
	    if($admins){
	    	session_start();
			$_SESSION['login'] = $_POST['login'];
			header('Location: main.php');
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LOGIN</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="main-wrapper">
		<header>
			<div class="logo">
				<img src="../img/main_logo.png" alt="logo">
			</div>
			<div class="login">
				<form action="" method="POST">
					<div class="label-wrapper">
						<label> Логин* </label>
						<input name="login" type="text" placeholder="">
					</div>
					<div class="label-wrapper">
						<label> Пароль* </label>
						<input name="password" type="text" placeholder="">
					</div>
					<input type="submit" value="Войти">
					<span id="forgotpassword">  Забыли пароль </span>
				</form>
			</div>
		</header>
	</div>
</body>
</html>