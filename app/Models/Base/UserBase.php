<?php

## FILE GENERATED BY MAGRATHEA.
## SHOULD NOT BE CHANGED MANUALLY

class UserBase extends MagratheaModel implements iMagratheaModel {

	public $id, $email, $name, $password, $active;
	public $created_at, $updated_at;
	protected $autoload = null;

	public function __construct(  $id=0  ){ 
		$this->MagratheaStart();
		if( !empty($id) ){
			$pk = $this->dbPk;
			$this->$pk = $id;
			$this->GetById($id);
		}
	}
	public function MagratheaStart(){
		$this->dbTable = "users";
		$this->dbPk = "id";
		$this->dbValues["id"] = "int";
		$this->dbValues["email"] = "string";
		$this->dbValues["name"] = "string";
		$this->dbValues["password"] = "string";
		$this->dbValues["active"] = "int";

		$this->dbValues["created_at"] =  "datetime";
		$this->dbValues["updated_at"] =  "datetime";

	}

	// >>> relations:

}

class UserControlBase extends MagratheaModelControl {
	protected static $modelName = "User";
	protected static $dbTable = "users";
}
?>