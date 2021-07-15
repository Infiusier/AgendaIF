<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();
	$app->loadModels("sistema");

	if( isset($_POST["id_notificacao"]) ){
		$notify = new UserNotification();
		$notify->checkView($_POST["id_notificacao"]);
	}