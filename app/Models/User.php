<?php

include(__DIR__."/Base/UserBase.php");

class User extends UserBase {
	// your code goes here!

	public static function EncryptPassword($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	public function SetPassword($password) {
		$this->password = User::EncryptPassword($password);
		return $this;
	}

}

class UserControl extends UserControlBase {
	// and here!

	public function Login($email, $password) {
//		$password = User::EncryptPassword($password);
		$query = MagratheaQuery::Select()
			->Obj(new User())
			->Where(array("email" => $email));
		$user = $this->Run($query)[0];
		if(!password_verify($password, $user->password)) {
			throw new Exception("Incorrect user/password (".$user->email.")", 4011);
		} else {
			try {
				$user->password = "-";
				return $user;
			} catch(Exception $ex) {
				throw new Exception("Error on login: ".$ex->getMessage(), 4011);
			}
		}
	}

}

?>