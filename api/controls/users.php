<?php

class UsersApi extends MagratheaApiControl {

	private $bootstrapEmail = "paulovelho@paulovelho.com";
	private $bootstrapName = "Paulo Velho";
	private $bootstrapPassword = "cosmos-sagan";

	public function __construct() {
		$this->model = "User";
		$this->service = new UserControl();
	}

	public function Initialize() {
		try {
			$existing = $this->service->GetByEmail($this->bootstrapEmail);
			if($existing != null) {
				return array('message' => "bootstrap user already exists", 'data' => $existing);
			}
			$u = new User();
			$u->name = $this->bootstrapName;
			$u->email = $this->bootstrapEmail;
			$u->SetPassword($this->bootstrapPassword);
			$u->active = true;
			if($u->Insert()) {
				return $u;
			}
			return array('message' => "could not create bootstrap user");
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function Create() {
		$data = $this->GetPost();
		$u = new User();
		$u->name = $data["name"];
		$u->email = $data["email"];
		$u->active = true;
		$u->SetPassword($data["password"]);
		try {
			if($u->Insert()) {
				return $u;
			}
		} catch(Exception $ex) {
			throw $ex;
		}
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
