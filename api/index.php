<?php

	header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type');
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json, charset=utf-8');

	include(__DIR__."/../app/inc/global.php");
	MagratheaModel::IncludeAllModels();

	include("api.php");

	$api = OceaniaAPI::Start();
	$api->AllowAll();
//  $api->AddAcceptHeaders(["Authorization", "Content-Type", "charset", "boundary"]);
	if($_GET["magrathea_control"] == "debug" || empty($_GET["magrathea_control"])) {
		$api->Debug();
	} else {
		$api->Run();
	}

?>
