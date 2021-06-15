<?php

class StatusApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Status";
		$this->service = new StatusControl();
	}

}

?>
