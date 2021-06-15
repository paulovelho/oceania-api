<?php

	include($magrathea_path."/MagratheaApi.php");

	include("controls/users.php");
	include("controls/status.php");
	include("controls/authentication.php");

	class OceaniaAPI {

		const OPEN = false;
		const LOGGED = "IsLogged";
		const ADMIN = "IsAdmin";

		public static function Start() {

			$authApi = AuthenticationApi::Instance();
			$usersApi = new UsersApi();
			$statusApi = new StatusApi();

			$api = MagratheaApi::Instance()
				->BaseAuthorization($authApi, self::LOGGED)     

				// auth
				->Add("POST", "login", $authApi, "Login", self::OPEN)
				->Add("GET", "token", $authApi, "GetTokenInfo", self::OPEN)

				// users
				->Crud("user", $usersApi, self::ADMIN)
				->Add("PUT", "update-password", $usersApi, "UpdatePassword", self::LOGGED)
				->Add("PUT", "user/:id/toggle", $usersApi, "ToggleActive", self::ADMIN)

				// status
				->Crud(["status", "statuses"], $statusApi)

				;

      return $api;
		}

	}

?>
