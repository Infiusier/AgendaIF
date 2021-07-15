<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();
	$app->loadModels('sistema');

	$user = new User();

	if( !isset($_POST) ){
		header("Location: " . $app->index());
		exit;
	}

	if( !$user->get(["usuario_email" => $_POST["usuario_email"]]) ){
		$_POST["usuario_senha"] = sha1("cf2020");
		$_POST["usuario_status"] = "Solicitado";
		$_POST["usuario_avatar"] = "";
		$new = $user->post($_POST);
		if(  $new ){
			header("Location: " . $app->index() . "/auth/entrar/" . Helper::notification(true, "Sua solicitação foi realizada com sucesso!"));
		}else{
			header("Location: " . $app->index() . "/auth/entrar/" . Helper::notification(false, "Falha ao realizar solicitação, entre em contato com o suporte do sistema"));
		}
	}else{
		header("Location: " . $app->index() . "/auth/entrar/" . Helper::notification(false, "E-mail já cadastrado, entre via login ou aguarde sua aprovação"));
	}