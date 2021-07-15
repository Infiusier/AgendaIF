<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();
		if( $db->update("vth_us_cargos",['cargo_nome' => $_POST['cargo_nome']],['id_cargo' => $_POST['id_cargo']],null) ){
			header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(true, "Cargo atualizado"));
		}else{
			header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Cargo não atualizado..."));
		}
	}else{
		header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Sem requisição"));
	}