<?php
	include("../app/inc/global.php");

	$activePassword = MagratheaConfig::Instance()->GetConfigFromDefault("admin_password");

	$email = @$_POST["email"];
	$pass = @$_POST["password"];

	if($email == "paulovelho" && $pass = $activePassword) {
		$_SESSION["magrathea_user"] = $email;
	}

	if(empty($_SESSION["magrathea_user"]))
		header("Location: admin.php?error=login_error");
	else 
		header("Location: admin.php");
?>
