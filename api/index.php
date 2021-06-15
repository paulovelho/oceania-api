<?php

	include("../app/inc/global.php");
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
