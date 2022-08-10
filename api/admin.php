<?php
	include("../app/inc/global.php");
	include($magrathea_path."/MagratheaAdmin.php"); //  should already be declared

	class LoginController extends MagratheaController {
		public static function Login(){
			if(@$_GET["error"] == "login_error")
				self::GetSmarty()->assign("message", "Login or password incorrect!");
			self::GetSmarty()->display("login.html");
		}
	}

	if(!empty($_SESSION["magrathea_user"])) {
		$admin = new MagratheaAdmin(); // adds the admin file
		$admin->AddPlugin("colorbox");
		$admin->AddPlugin("dropzone");
//		$admin->AddPlugin("MagratheaImages2");
		$admin->Load(); // load!
	} else {
		LoginController::Login();
	}

?>
