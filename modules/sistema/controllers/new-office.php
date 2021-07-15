<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();
		if( $db->insert("vth_us_cargos",$_POST,null) ){
			header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(true, "Cargo Cadastrado"));
		}else{
			header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Cargo não cadastrado..."));
		}
	}else{
		header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Sem requisição"));
	}