<?php

class ProjectsApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Project";
		$this->service = new ProjectControl();
	}

	public function Create() {
		$data = $this->GetPost();
		$p = new Project();
		$p->name = $data["name"];
		$p->short_desc = $data["short_desc"];
		$p->active = true;
		$p->client_id = $data["client_id"] || 1;
		$p->value = 0;
		try {
			if($p->Insert()) {
				return $p;
			}
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function List() {
		return $this->service->GetAllWithClients();
	}

}

?>
