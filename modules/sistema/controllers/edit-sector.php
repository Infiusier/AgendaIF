<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();
		if( $db->update("vth_us_setores",['setor_nome' => $_POST['setor_nome']],['id_setor' => $_POST['id_setor']],null) ){
			header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(true, "setor atualizado"));
		}else{
			header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "setor não atualizado..."));
		}
	}else{
		header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "Sem requisição"));
	}