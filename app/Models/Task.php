<?php

include(__DIR__."/Base/TaskBase.php");

class Task extends TaskBase {
	// your code goes here!

	public function Insert() {
		if(!$this->status_id) $this->status_id = 1; // to do
		if(!$this->activity_id) $this->activity_id = 10; // unpaid
		if(!$this->priority) $this->priority = 0;
		if(!$this->urgency) $this->urgency = 0;
		if(!$this->hours_estimation) $this->hours_estimation = 8;
		if(!$this->hours_spent) $this->hours_spent = 0;
		if(!$this->value_final) $this->value_final = 0;
		$this->added_on = now();
		return parent::Insert();
	}

}

class TaskControl extends TaskControlBase {
	
	public function ChangeStatus($task_id, $status_id) {
		$query = MagratheaQuery::Update()
			->Obj(new Task())
			->Where(array("id" => $task_id))
			->Set("status_id", $status_id);
		$rs = $this->Run($query);
		return $rs;
	}

	public function ChangeBulkStatus($arr_task_ids, $status_id) {
		$query = MagratheaQuery::Update()
			->Obj(new Task())
			->Where("id IN (".implode(',', $arr_task_ids).")")
			->Set("status_id", $status_id);
		return $this->Run($query);
	}

	public function HourChange($task_id, $sign) {
		$query = MagratheaQuery::Update()
			->Obj(new Task())
			->Where(array("id" => $task_id))
			->SetRaw("hours_spent = (hours_spent ".$sign." 1)");
		$rs = $this->Run($query);
		return $rs;
	}

	public function GetByStatus($status_id) {
		$query = MagratheaQuery::Select()
			->Obj(new Task())
			->Where(array("status_id" => $status_id));
		return $this->Run($query);
	}

}

?>