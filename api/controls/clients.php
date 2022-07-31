<?php

class ClientsApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Client";
		$this->service = new ClientControl();
	}

	public function Create() {
		$data = $this->GetPost();
		$c = new Client();
		$c->name = $data["name"];
		$c->active = true;
		try {
			if($c->Insert()) {
				return $c;
			}
		} catch(Exception $ex) {
			throw $ex;
		}
	}

}

?>
