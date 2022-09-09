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
		try {
			if($t->Insert()) {
				return $t;
			} else {
				throw new MagratheaApiException("Error Inserting task", 500, $t);
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

	public function AddHour($params) {
		$id = +$params["id"];
		$this->service->HourChange($id, '+');
		$t = new Task($id);
		return $t;
	}
	public function RemoveHour($params) {
		$id = +$params["id"];
		$sql = $this->service->HourChange($id, '-');
		$t = new Task($id);
		if ($t->hours_spent < 0) {
			$t->hours_spent = 0;
			$t->Save();
		}
		return $t;
	}

	public function Archive() {
		$data = $this->GetPost();
		$ts = $data["tasks"];
		$task_ids = explode(',', $ts);
		$archive_st = 9;
		return $this->service->ChangeBulkStatus($task_ids, 9);
	}

	public function TasksByStatus($params) {
		$status = +$params["status_id"];
		return $this->service->GetByStatus($status);
	}


	/* bulk add task */
	private function CreateFromBase($name, $project_id, $hours=8, $activity=null, $depends_on=false) {
		$t = new Task();
		$t->task = $name;
		$t->project_id = $project_id;
		$t->hours_estimation = intval($hours);
		if($activity) {
			$t->activity_id = $activity;
		}
		if($depends_on) {
			$t->depends_on = $depends_on;
		}
		$t->Insert();
		return $t;
	}
	public function lineToTask($taskStr) {
		$taskParts = explode("-", trim($taskStr));
		if(count($taskParts) == 1) return array('name' => trim($taskStr), 'hours' => null, 'depth' => 0);

		$hours = strtolower(array_pop($taskParts));
		if(substr($hours, -1) == "h") {
			$hours = substr($hours, 0, -1);
		}
		if(!is_numeric($hours)) {
			array_push($taskParts, $hours);
			$hours = null;
		}
		$depth = 0;
		while(empty(trim($taskParts[0]))) {
			$depth ++;
			array_shift($taskParts);
		}
		$name = trim(implode('-', $taskParts));
		return array('name' => $name, 'hours' => $hours, 'depth' => $depth);
	}
	public function manageBulk($project_id, $text, $activity_id = null) {
		$strings = array_reverse(explode("\n", $text));
		$data = array_map(array($this, "lineToTask"), $strings);

		$tasks = [];
		$depends = null;
		$sumHours = 0;
		foreach ($data as $task) {
			if ($task['depth'] > 0) {
				$t = $this->CreateFromBase($task['name'], $project_id, $task['hours'], $activity_id);
				if(!$depends) $depends = [];
				$sumHours += $t->hours_estimation;
				array_push($depends, $t->id);
			} else {
				if ($sumHours == 0) {
					$hours = $task['hours'];
				} else {
					$hours = $sumHours;
					$sumHours = 0;
				}
				$t = $this->CreateFromBase($task['name'], $project_id, $hours, $activity_id, $depends);
				$depends = null;
			}
			array_push($tasks, $t);
		}

		return $tasks;
	}

	public function BulkAdd($params) {
		$project_id = $params["project_id"];
		$post = $this->GetPost();
		$ts = $post["tasks"];
		$activity = $post["activity"];

		if(empty($ts)) {
			throw new MagratheaApiException("invalid tasks", 401);
		}

		return $this->manageBulk($project_id, $ts, $activity);
	}

}

?>
