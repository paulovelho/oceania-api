<?php

include(__DIR__."/Base/TaskBase.php");

class Task extends TaskBase {
	// your code goes here!
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

}

?>