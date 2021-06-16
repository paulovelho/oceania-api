<?php

class TasksApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Task";
		$this->service = new TaskControl();
	}

	public function Create() {
		$data = $this->GetPost();
		$t = new Task();
		$t->LoadObjectFromTableRow($data);
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

}

?>
