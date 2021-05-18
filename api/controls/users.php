<?php

class UsersApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "User";
		$this->service = new UsersControl();
	}

	public function ToggleActive($params) {
		$id = $params["id"];
		$user = new User($id);
		if($user->active) {
			$user->active = 0;
		} else {
			$user->active = 1;
		}
		$user->Save();
		return $user;
	}

	public function UpdatePassword() {
		$put = $this->GetPut();
		$user = AuthenticationApi::Instance()->getUser();
		$newPassword = $put["password"];
		$user->SetPassword($newPassword);
		$user->Save();
		$user->password = "-";
		return array("password" => $newPassword, "user" => $user);
	}

}

?>
