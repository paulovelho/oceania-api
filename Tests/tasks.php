<pre>
<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	SimpleTest::prefer(new TextReporter());

	MagratheaModel::IncludeAllModels();
	include(__DIR__.'/../app/inc/config.php');
	include(__DIR__.'/../api/api.php');

	echo "</pre><hr/><br/>";
	echo "bulk tasks: [ok]<br/>";
	echo "<br/><hr/><br/><pre>";

	include("_bulkTask.php");

?>
</pre>

