<?php

## FILE GENERATED BY MAGRATHEA.
## SHOULD NOT BE CHANGED MANUALLY

class TaskBase extends MagratheaModel implements iMagratheaModel {

	public $id, $project_id, $epic, $task, $activity_id, $status_id, $priority, $urgency, $hours_estimation, $hours_spent, $hours_total, $value_expected, $value_final, $depends_on, $deadline, $notes, $added_on;
	public $created_at, $updated_at;
	protected $autoload = array("Status" => "status_id");
	public $Status;

	public function __construct(  $id=0  ){ 
		$this->MagratheaStart();
		if( !empty($id) ){
			$pk = $this->dbPk;
			$this->$pk = $id;
			$this->GetById($id);
		}
	}
	public function MagratheaStart(){
		$this->dbTable = "tasks";
		$this->dbPk = "id";
		$this->dbValues["id"] = "int";
		$this->dbValues["project_id"] = "int";
		$this->dbValues["epic"] = "string";
		$this->dbValues["task"] = "string";
		$this->dbValues["activity_id"] = "int";
		$this->dbValues["status_id"] = "int";
		$this->dbValues["priority"] = "int";
		$this->dbValues["urgency"] = "int";
		$this->dbValues["hours_estimation"] = "int";
		$this->dbValues["hours_spent"] = "int";
		$this->dbValues["hours_total"] = "int";
		$this->dbValues["value_expected"] = "float";
		$this->dbValues["value_final"] = "float";
		$this->dbValues["depends_on"] = "int";
		$this->dbValues["deadline"] = "datetime";
		$this->dbValues["notes"] = "text";
		$this->dbValues["added_on"] = "datetime";

		$this->relations["properties"]["Activitys"] = null;
		$this->relations["methods"]["Activitys"] = "GetActivitys";
		$this->relations["lazyload"]["Activitys"] = "false";
		$this->relations["properties"]["Projects"] = null;
		$this->relations["methods"]["Projects"] = "GetProjects";
		$this->relations["lazyload"]["Projects"] = "false";
		$this->relations["properties"]["Status"] = null;
		$this->relations["methods"]["Status"] = "GetStatus";
		$this->relations["lazyload"]["Status"] = "false";
		$this->dbValues["created_at"] =  "datetime";
		$this->dbValues["updated_at"] =  "datetime";

	}

	// >>> relations:
	public function GetActivitys(){
		if($this->relations["properties"]["Activitys"] != null) return $this->relations["properties"]["Activitys"];
		$this->relations["properties"]["Activitys"] = new Activity($this->activity_id);
		return $this->relations["properties"]["Activitys"];
	}
	public function SetActivitys($activitys){
		$this->relations["properties"]["Activitys"] = $activitys;
		$this->activity_id = $activitys->GetID();
		return $this;
	}
	public function GetProjects(){
		if($this->relations["properties"]["Projects"] != null) return $this->relations["properties"]["Projects"];
		$this->relations["properties"]["Projects"] = new Project($this->project_id);
		return $this->relations["properties"]["Projects"];
	}
	public function SetProjects($projects){
		$this->relations["properties"]["Projects"] = $projects;
		$this->project_id = $projects->GetID();
		return $this;
	}
	public function GetStatus(){
		if($this->relations["properties"]["Status"] != null) return $this->relations["properties"]["Status"];
		$this->relations["properties"]["Status"] = new Status($this->status_id);
		return $this->relations["properties"]["Status"];
	}
	public function SetStatus($status){
		$this->relations["properties"]["Status"] = $status;
		$this->status_id = $status->GetID();
		return $this;
	}

}

class TaskControlBase extends MagratheaModelControl {
	protected static $modelName = "Task";
	protected static $dbTable = "tasks";
}
?>