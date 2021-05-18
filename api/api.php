<?php

	include($magrathea_path."/MagratheaApi.php");

	include("controls/users.php");
	include("controls/authentication.php");

	class OceaniaAPI {

		const OPEN = false;
		const LOGGED = "IsLogged";
		const ADMIN = "IsAdmin";

		public static function Start() {

			$authControl = AuthenticationApi::Instance();
			$usersControl = new UserControl();

			$api = MagratheaApi::Instance()
				->BaseAuthorization($authControl, self::LOGGED)     


				// users
				->Crud("user", $usersControl, self::ADMIN)
				->Add("PUT", "update-password", $usersControl, "UpdatePassword", self::LOGGED)
				->Add("PUT", "user/:id/toggle", $usersControl, "ToggleActive", self::ADMIN);


      return $api;
		}

	}

?>
