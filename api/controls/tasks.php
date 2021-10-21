<?php

class TasksApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Task";
		$this->service = new TaskControl();
	}

	public function ChangeStatus($params) {
		$task_id = $params["id"];
		$new_status = $params["status"];
		$sql = $this->service->ChangeStatus($task_id, $new_status);
		return $sql;
	}

	public function Create() {
		$data = $this->GetPost();
		$t = new Task();
		$t->LoadObjectFromTableRow($data);
		if(!$t->status_id) $t->status_id = 1; // to do
		if(!$t->activity_id) $t->activity_id = 10; // unpaid
		if(!$t->priority) $t->priority = 0;
		if(!$t->urgency) $t->urgency = 0;
		if(!$t->hours_estimation) $t->hours_estimation = 8;
		if(!$t->hours_spent) $t->hours_spent = 0;
		if(!$t->value_final) $t->value_final = 0;
		$t->added_on = now();
		try {
			if($t->Insert()) {
				return $t;
			}
		} catch(Exception $ex) {
			throw $ex;
		}
	}

	public function Filter() {
		$filters = [];
		if (!$filters) {
			return $this->GetAll();
		}
	}

}

?>
