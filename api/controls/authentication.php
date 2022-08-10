<?php
require("../vendor/autoload.php");
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthenticationApi extends MagratheaApiControl {

	public $userInfo = false;

	protected static $inst = null;
	private function __construct() {
		$this->model = "User";
		$this->service = new UserControl();
		$this->secret = MagratheaConfig::Instance()->GetConfigFromDefault("jwt_secret");
		$this->jwtEncodeType = "HS256";
	}

	public static function Instance(){
		if(!isset(self::$inst)){
			self::$inst = new AuthenticationApi();
		}
		return self::$inst;
	}

	/** 
	* Get header Authorization
	* */
	private function getAuthorizationHeader(){
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) { // htaccess rules
			$headers = trim($_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}
	public function GetHeaders() {
		return $this->getAuthorizationHeader();
	}
	/**
	* get access token from header
	* */
	public function getBearerToken() {
		$headers = $this->getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	public function getUser() {
		return new User($this->userInfo->id);
	}

	public function jwtDecode($token) {
		return JWT::decode($token, new Key(strtr($this->secret, '-_', '+/'), $this->jwtEncodeType));
	}
	public function jwtEncode($payload) {
		return JWT::encode($payload, strtr($this->secret, '-_', '+/'), $this->jwtEncodeType);
	}

	public function GetTokenInfo($token=false) {
		if(!$token) {
			$token = $this->getBearerToken();
		}
		if(!$token) return false;
		$this->userInfo = $this->jwtDecode($token);
		return $this->userInfo;
	}

	public function ResponseLogin($user) {
		$expire = date('Y-m-d h:i:s', strtotime($Date. ' + 7 days'));
		$payload = [
			"id" => $user->id,
			"email" => $user->email,
			"name" => $user->name
		];
		$jwtRefresh = $this->jwtEncode($payload);
		$payload["refresh"] = $jwtRefresh;
		$payload["expire"] = $expire;
		$jwt = $this->jwtEncode($payload);
		return [
			"refresh_token" => $jwtRefresh,
			"token" => $jwt,
			"user" => $user
		];
	}

	public function Refresh() {
		$refresh_token = $_GET["refresh_token"];
		$info = $this->GetTokenInfo();
		if(empty($info)) throw new Exception("invalid token", 4011);
		$saved_refresh = $info->refresh;
		if($refresh_token != $saved_refresh) {
			throw new Exception("refresh token invalid", 4015);
		}
		$user = new User($info->id);
		$user->SaveLogin();
		try {
			return $this->ResponseLogin($user);
		} catch(Exception $ex) {
			throw new Exception($ex->getMessage(), 500);
		}
	}

	public function Login() {
		$post = $this->GetPost();
		$user = $this->service->Login($post["email"], $post["password"]);
//		p_r($user);
		try {
			return $this->ResponseLogin($user);
		} catch(Exception $ex) {
			throw new Exception($ex->getMessage(), 500);
		}
	}

	// Authorization Levels:
	public function CheckExpire() {
		$timeStampExp = strtotime($this->userInfo->expire);
		$timeStampNow = strtotime(now());
		if($timeStampExp < $timeStampNow) {
			$ex = new MagratheaApiException("token expired", 4010);
			$ex->SetData(["expiredAt" => $timeStampExp]);
			throw $ex;
		}
		return true;
	}

	public function IsLogged() {
		try {
			if($this->GetTokenInfo()) {
				return $this->CheckExpire();
			}
			return false;
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function IsAdmin() {
		try {
			return $this->IsLogged();
		} catch(Exception $ex) {
			throw $ex;
		}
	}

}

?>
