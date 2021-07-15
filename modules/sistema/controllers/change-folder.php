<?php

	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();
	$app->loadModels('sistema');

	if( Session::auth() ){

		$user = Session::get();

		if( isset($_POST['imglink']) and $_POST["imglink"] != "" ){
			# validação de link
			$User = new User();
			$edit = $User->put(['usuario_capa' => $_POST["imglink"]],['id_usuario' => $user['id_usuario']]);
			if( $edit ){
				if( Session::edit(['usuario_capa' => $_POST["imglink"]]) ){
					# capa setado
					header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(true,"capa atualizado"));
				}else{
					# falha ao atualizar capa
					header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao atualizar capa na sessão, saia e logue novamente para carregar as atualizações"));
				}
			}else{
				# falha ao atualizar capa
				header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao atualizar capa"));
			}
		}else{
			# validação de file
			if( isset($_FILES['imgfile']) and $_FILES['imgfile']['name'] != "" ){
				$imgname = date('YmdHis').".jpg";
				if( move_uploaded_file($_FILES['imgfile']['tmp_name'], $app->path() . "/storage/folder/" . $imgname) ){
					# atualizar no banco de dados
					$User = new User();
					$edit = $User->put(['usuario_capa' => $imgname],['id_usuario' => $user['id_usuario']]);
					if( $edit ){
						if( Session::edit(['usuario_capa' => $imgname]) ){
							# capa setado
							header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(true,"capa atualizado"));
						}else{
							# falha ao atualizar capa
							header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao atualizar capa na sessão, saia e logue novamente para carregar as atualizações"));
						}
					}else{
						# falha ao atualizar capa
						header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao atualizar capa"));
					}
				}else{
					# falha ao realizar upload da imagem
					header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Falha ao realizar upload da imagem..."));
				}
			}else{
				header("Location: " . $app->index() . "/sistema/perfil" . Helper::notification(false,"Sem requisição..."));
			}
		}

	}else{
		# sessão caiu
		header("Location: " . $app->index() . "/auth/entrar" . Helper::notification(false,"Entre com seu usuário"));
	}