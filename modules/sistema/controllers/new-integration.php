<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();
		if( $db->insert("vth_contas",$_POST,null) ){
			header("Location: " . $app->index() . "/sistema/configuracoes/" . Helper::notification(true, "Conta Cadastrada"));
		}else{
			header("Location: " . $app->index() . "/sistema/configuracoes/" . Helper::notification(false, "Conta não cadastrada..."));
		}
	}else{
		header("Location: " . $app->index() . "/sistema/configuracoes/" . Helper::notification(false, "Sem requisição"));
	}