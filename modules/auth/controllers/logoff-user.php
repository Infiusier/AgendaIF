<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";
	$app = new Module();

	$fileActivity = $app->path() . "/storage/system/activity-user.json";
	if( file_exists($fileActivity) ){
		$file = json_decode(file_get_contents($fileActivity),true);
		if( isset($file[$_POST['id_usuario']]) ){
			$file[$_POST['id_usuario']]['status'] = 0;
			file_put_contents($app->path() . "/storage/system/activity-user.json", json_encode($file));
			echo true;
		}else{
			echo false;
		}
	}else{
		echo false;
	}
