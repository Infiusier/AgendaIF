<?php
	

	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	$app->loadModels("sistema");

	if( isset($_POST["id_usuario"]) ){
		$user = new User();
		$delete = $user->del($_POST);
		if( $delete ){
			header("Location: " .  $app->index() . "/sistema/usuarios/" . Helper::notification(true, "O usuário foi deletado com sucesso!"));
		}else{
			header("Location: " .  $app->index() . "/sistema/usuarios/" . Helper::notification(false, "Não foi possivel deletar o usuário, entre em contato com o suporte..."));
		}
	}else{
		header("Location: " .  $app->index() . "/sistema/usuarios/" . Helper::notification(false, "Sem requisição pendente..."));
	}