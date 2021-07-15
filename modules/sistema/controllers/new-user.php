<?php
	

	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	$app->loadModels("sistema");

	# implementando e-mail
	$_POST["usuario_email"] = $_POST["usuario_email"] . "@josuerangus.com.br";
	$_POST["usuario_status"] = "Ativo";
	$_POST["usuario_funcoes"] = "1 - 2 - 3 - 4 - 5";

	if( isset($_POST) and !empty($_POST) ){

		$user = new User();
		if( !$user->get(['usuario_email' => $_POST['usuario_email']]) ){
			
			# validação de pass
			$_POST['usuario_senha'] = sha1($_POST['usuario_senha']);
			
			# cadastro
			$new = $user->post($_POST);

			if( $new ){
				# usuário cadastrado
				header("location: " . $app->index() . "/sistema/usuarios" . Helper::notification(true, "Usuário ".$_POST['usuario_nome']." cadastrado"));
			}else{
				# falha de cadastro
				header("location: " . $app->index() . "/sistema/usuarios" . Helper::notification(false, "Falha ao cadastrar o usuário..."));
			}

		}else{
			# usuário já cadastrado
			header("location: " . $app->index() . "/sistema/usuarios" . Helper::notification(false, "Usuário ".$_POST['usuario_nome']." já cadastrado..."));
		}
	}else{
		# sem requisição
	}
