<?php
	

	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	$app->loadModels("sistema");

	if( isset($_POST["id_usuario"]) ){
		$user = new User();
		$edit = $user->put(["usuario_status" => "Ativo"],$_POST);
		if( $edit ){
			header("Location: " .  $app->index() . "/sistema/usuarios/" . Helper::notification(true, "O usuário foi desbloqueado com sucesso!"));
		}else{
			header("Location: " .  $app->index() . "/sistema/usuarios/" . Helper::notification(false, "Não foi possivel desbloquear o usuário, entre em contato com o suporte..."));
		}
	}else{
		header("Location: " .  $app->index() . "/sistema/usuarios/" . Helper::notification(false, "Sem requisição pendente..."));
	}