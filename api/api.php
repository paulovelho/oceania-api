<?php

	include($magrathea_path."/MagratheaApi.php");

	include("controls/users.php");
	include("controls/authentication.php");

	include("controls/activity.php");
	include("controls/status.php");
	include("controls/projects.php");
	include("controls/tasks.php");

	class OceaniaAPI {

		const OPEN = false;
		const LOGGED = "IsLogged";
		const ADMIN = "IsAdmin";

		public static function Start() {

			$authApi = AuthenticationApi::Instance();
			$activityApi = new ActivityApi();
			$projectsApi = new ProjectsApi();
			$statusApi = new StatusApi();
			$tasksApi = new TasksApi();
			$usersApi = new UsersApi();

			$api = MagratheaApi::Instance()
				->BaseAuthorization($authApi, self::LOGGED)     

				// auth
				->Add("POST", "login", $authApi, "Login", self::OPEN)
				->Add("GET", "token", $authApi, "GetTokenInfo", self::OPEN)

				// users
				->Crud("user", $usersApi, self::ADMIN)
				->Add("POST", "bootstrap", $usersApi, "Initialize", self::OPEN)
				->Add("PUT", "update-password", $usersApi, "UpdatePassword", self::LOGGED)
				->Add("PUT", "user/:id/toggle", $usersApi, "ToggleActive", self::ADMIN)

				// status
				->Crud(["status", "statuses"], $statusApi)
				->Add("POST", "status/bootstrap", $statusApi, "Initialize", self::OPEN)

				// activity
				->Crud(["activity", "activities"], $activityApi)
				->Add("POST", "activities/bootstrap", $activityApi, "Initialize", self::OPEN)

				// projects
				->Crud("project", $projectsApi, self::LOGGED)
				
				// tasks
				->Crud("task", $tasksApi, self::LOGGED)
				->Add("POST", "task/:id/move-to/:status", $tasksApi, "ChangeStatus", self::ADMIN)

				;

      return $api;
		}

	}

?>
