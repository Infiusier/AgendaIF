<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	Session::done();

	header("Location:" . $app->index() . "/auth/entrar" . Helper::notification(true, "Volte Sempre!") );