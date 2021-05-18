<?php

	include("../app/inc/global.php");
	MagratheaModel::IncludeAllModels();

	echo "ok1";
	include("api.php");

	echo "ok2";
	$api = OceaniaAPI::Start();
	$api->AllowAll();
//  $api->AddAcceptHeaders(["Authorization", "Content-Type", "charset", "boundary"]);
	if($_GET["magrathea_control"] == "debug" || empty($_GET["magrathea_control"])) {
		$api->Debug();
	} else {
		$api->Run();
	}

?>
