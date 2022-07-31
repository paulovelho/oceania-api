<?php

include(__DIR__."/Base/ProjectBase.php");

class Project extends ProjectBase {
	// your code goes here!
}

class ProjectControl extends ProjectControlBase {
	public function GetAllWithClients() {
		$query = MagratheaQuery::Select()
			->Obj(new Project())
			->HasOne(new Client(), "client_id");
		$rs = $this->Run($query);
		return $rs;
	}
}

?>