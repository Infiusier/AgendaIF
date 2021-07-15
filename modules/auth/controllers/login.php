<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();
	$app->loadModels('sistema');

	if( !Session::auth() ){

		$user = new User();
		# validando email
		$log = $user->get(["usuario_email" => $_POST['email']]);
		if( $log ){
			# validando senha
			if( $log[0]['usuario_senha'] == sha1($_POST['password']) ){

				
					if( $log[0]['usuario_status'] == "Ativo" ){

						Session::new($log[0]);
						# redirect
						
						# Validação de Redirect
						$user = Session::get();
						$acesso = explode(" - ", $user['usuario_funcoes']);


						# notificação de sistema
						$notify = new UserNotification();
						$notify->set([
							"notificacao_titulo" => $log[0]["usuario_nome"] . " acabou de entrar",
							"notificacao_avatar" => Helper::avatar($log[0]["usuario_avatar"]),
							"notificacao_url" => "javascript:void(0);"
						])->sendAll(null," where id_usuario != " . $log[0]['id_usuario']);

					
						if(in_array("1", $acesso)){
							header("Location: " . $app->index() . "/sistema/usuarios/1" . Helper::notification(true,"Bem-vindo " . $log[0]["usuario_nome"]));
						}elseif (in_array("7", $acesso)) {
							header("Location: " . $app->index() . "/sistema/usuarios/" . Helper::notification(true,"Bem-vindo " . $log[0]["usuario_nome"]));							
						}else{
							header("Location: " . $app->index() . "/sistema/usuarios/" . Helper::notification(true,"Bem-vindo " . $log[0]["usuario_nome"]));
						}
						
					}else{

						switch($log[0]["usuario_status"]){
							case "Solicitado":
								$message = "Seu acesso foi solicitado e está pendente de aprovação, aguarde...";
							break;
							case "Bloqueado":
								$message = "Sua conta está bloqueada, entre em contato com o admin para mais detalhes...";
							break;
							default:
								$message = "Sua conta está corrompida, entre em contato com o admin para mais detalhes...";
							break;
						}

						header("Location: " . $app->index() . "/auth/entrar" . Helper::notification(false, $message));

					}

			}else{

				# senha incorreta
				header("Location: " . $app->index() . "/auth/entrar/" . Helper::notification(false,"Senha incorreta, tente novamente..."));
			}
		}else{
			# email não cadastrado
			header("Location: " . $app->index() . "/auth/entrar/" . Helper::notification(false,"E-mail não cadastrado"));
		}
	}else{
		# redirect to sistema panel
		header("Location: " . $app->index() . "/pedidos/listar/1" . Helper::notification(true,"Usuário já logado"));
	}
