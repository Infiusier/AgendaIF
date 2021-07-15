<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){
		$_POST["usuario_email"] = $_POST["usuario_email"] . "@josuerangus.com.br";
		$_POST["usuario_status"] = "Ativo";

		if($_POST['usuario_senha'] != ""){
			$_POST['usuario_senha'] = sha1($_POST['usuario_senha']);
		}else{
			unset($_POST['usuario_senha']);
		}

		$db = new DB();
		if( $db->update("vth_usuarios",$_POST,['id_usuario' => $_POST['id_usuario']],null) ){
			header("Location: " . $app->index() . "/sistema/usuarios/" . Helper::notification(true, "usuario atualizado"));
		}else{
			header("Location: " . $app->index() . "/sistema/usuarios/" . Helper::notification(false, "usuario não atualizado..."));
		}
	}else{
		header("Location: " . $app->index() . "/sistema/usuarios/" . Helper::notification(false, "Sem requisição"));
	}