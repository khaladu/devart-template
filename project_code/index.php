<?php
require_once "include/common.inc.php";
require_once "db/DataHandler.php";
require_once "cms/User.php";
require_once "cms/Content.php";
session_start();
$do_login = false;
$login_error = false;
if(isset($_SESSION['user'])){
	$currentUser = new User();
	$userID = $_SESSION['user'];

	if($result == INVALID_USER){
		session_destroy();
	}
}
else{
	if(!isset($_POST['loginform'])){
		session_destroy();
		$do_login = true;
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['req'])){
		if($_GET['req'] == "logout"){
			session_destroy();
			$do_login = true;
		}
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST["loginform"])){
		$username = $_POST["username"];
		$password = $_POST["password"];
		$role = $_POST["role"];

		$user = new User();
		$result = $user->authenticate($username, $password, $role);
		//echo "<br>login result ".$result;
		if($result == LOGIN_SUCCESS){

			$_SESSION['user'] = $user->UserID;
			$_SESSION['user_role'] = $user->UserRole;
			$currentUser = $user;

		}
		else{
			$do_login = true;
			$login_error = true;
		}
	}
}

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>
<body>
	<?php
	if($do_login == true){
		require "public/login.php";
	}
	else{
		require "public/index.php";	
	}

	?>
</body>
</html>
