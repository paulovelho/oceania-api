<?php
	require("inc/global.php");

	$email = @$_POST["email"];
	$pass = @$_POST["password"];

	if($email == "paulovelho" && $pass = "123") {
		$_SESSION["magrathea_user"] = $email;
	}

	if(empty($_SESSION["magrathea_user"]))
		header("Location: admin.php?error=login_error");
	else 
		header("Location: admin.php");
?>
