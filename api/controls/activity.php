<?php

class ActivityApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Activity";
		$this->service = new ActivityControl();
	}

	private function insertBasic($name, $value, $fixed) {
		$a = new Activity();
		$a->name = $name;
		$a->value = $value;
		$a->fixed = $fixed;
		$a->Insert();
		return $a;
	}

	public function Initialize() {
		return "Activities already initialized!";
		$actArr = [];
		array_push($actArr, $this->insertBasic("admin", 5, 1));
		array_push($actArr, $this->insertBasic("bonus", 1, 0));
		array_push($actArr, $this->insertBasic("critic article", 25, 1));
		array_push($actArr, $this->insertBasic("dev external", 50, 0));
		array_push($actArr, $this->insertBasic("development", 30, 0));
		array_push($actArr, $this->insertBasic("drawing", 10, 1));
		array_push($actArr, $this->insertBasic("meeting", 10, 1));
		array_push($actArr, $this->insertBasic("report", 10, 1));
		array_push($actArr, $this->insertBasic("research", 10, 0));
		array_push($actArr, $this->insertBasic("unpaid", 0, 1));
		array_push($actArr, $this->insertBasic("writing", 20, 0));
		array_push($actArr, $this->insertBasic("writing external", 30, 0));
		return $actArr;
	}

}

?>
