<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();
		$_POST["setor_descricao"] = "";
		if( $db->insert("vth_us_setores",$_POST,null) ){
			header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(true, "Setor Cadastrado"));
		}else{
			header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "Setor não cadastrado..."));
		}
	}else{
		header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "Sem requisição"));
	}