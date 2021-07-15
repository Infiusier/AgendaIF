<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$app->loadModels("sistema");

		$notify = new UserNotification();
		$notify->set($_POST)->sendAll();
		header("location:" . $app->index() . "/sistema/notificacoes" . Helper::notification(true, "Notifificações Enviadas!"));
	}