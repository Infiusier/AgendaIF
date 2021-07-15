<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();
	$app->loadModels('sistema');

	if( Session::auth() ){
		$notify = new UserNotification();
		$check  = $notify->pending();
		if( $check ){
			echo count($check);
		}else{
			echo false;
		}
	}else{
		echo false;
	}