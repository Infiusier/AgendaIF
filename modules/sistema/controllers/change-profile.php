<?php

	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();
	$app->loadModels('sistema');

	if( Session::auth() ){

		$user = Session::get();

		if( isset($_POST) and !empty($_POST) ){

			$pass['old'] = $_POST["oldpass"];
			$pass['new'] = $_POST['newpass'];

			# removendo campos não usados
			unset($_POST["oldpass"]);
			unset($_POST["newpass"]);

			if( $pass['old'] != "" and $pass['new'] != "" ){
				if( $user['usuario_senha'] == sha1($pass['old']) ){
					$_POST['usuario_senha'] = sha1($pass['new']);
					# modificando dados de usuário
					$User = new User();
					$edit = $User->put($_POST,['id_usuario' => $user['id_usuario']]);
					if( $edit ){
						# editando informações na sessão
						if( Session::edit($_POST) ){
							# informações atualizadas na sessão
							header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(true,"Dados atualizados com sucessso!"));
						}else{
							# falha ao atualizar dados na sessão
							header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(true,"Dados atualizados, porém os dados de sessão não foram atualizados, por favor, realize um novo login para carregar as novas informações!"));
						}
					}else{
						# falha ao editar dados no db
						header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao editar dados no banco de dados"));
					}
				}else{
					header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"A senha antiga não bate com a sua senha atual..."));
				}
			}else{

				# modificando dados de usuário
				$User = new User();
				$edit = $User->put($_POST,['id_usuario' => $user['id_usuario']]);
				if( $edit ){
					# editando informações na sessão
					if( Session::edit($_POST) ){
						# informações atualizadas na sessão
						header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(true,"Dados atualizados com sucessso!"));
					}else{
						# falha ao atualizar dados na sessão
						header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(true,"Dados atualizados, porém os dados de sessão não foram atualizados, por favor, realize um novo login para carregar as novas informações!"));
					}
				}else{
					# falha ao editar dados no db
					header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao editar dados no banco de dados"));
				}
			}

		}else{
			# sem requisição
			header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Sem requisição..."));
		}

	}else{
		# sem sessão ativa
		header("Location: " . $app->index() . "/auth/entrar" . Helper::notification(false,"Entre com seu usuário..."));
	}