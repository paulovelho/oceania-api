<?php

	include($magrathea_path."/MagratheaApi.php");

	include("controls/users.php");
	include("controls/authentication.php");

	include("controls/activity.php");
	include("controls/clients.php");
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
			$clientsApi = new ClientsApi();
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

				// clients
				->Crud("client", $clientsApi, self::LOGGED)

				// projects
				->Crud("project", $projectsApi, self::LOGGED)
				
				// tasks
				->Crud("task", $tasksApi, self::LOGGED)
				->Add("POST", "task/:id/move-to/:status", $tasksApi, "ChangeStatus", self::LOGGED)
				->Add("POST", "tasks/:project_id/bulk-add", $tasksApi, "BulkAdd", self::LOGGED)
				->Add("POST", "task/:id/add-hour", $tasksApi, "AddHour", self::LOGGED)
				->Add("POST", "task/:id/remove-hour", $tasksApi, "RemoveHour", self::LOGGED)

				;

      return $api;
		}

	}

?>
