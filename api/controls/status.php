<?php

class StatusApi extends MagratheaApiControl {

	private $bootstraps = array("to do", "queue", "waiting", "wip", "done", "cancelled", "blocked");

	public function __construct() {
		$this->model = "Status";
		$this->service = new StatusControl();
	}

	public function Initialize() {
		return "Status already initialized!";
		$statusArr = [];
		foreach ($this->bootstraps as $st) {
			$s = new Status();
			$s->title = $st;
			$s->Insert();
			array_push($statusArr, $s);
		}
		return $statusArr;
	}

}

?>
