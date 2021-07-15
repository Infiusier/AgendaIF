<?php
	
	$module   = new Module();
	$template = new TEngine();

	# validate view
	if( $module->uri(2) == false ){
		$module->goToModule();
	}

	# validate session
	if( Session::auth() ){
		header("Location: " . $module->index() . "/sistema/");
	}

	$validate = $module->validate();

	if( $validate['error'] == false ){
		
		# default routes
		$template->set([
			'entrar' => [
				'title'   => 'Entrar',
				'file' 	  => 'login',
				'packages' => ['atlantis-login']
			],
			'esqueci-minha-senha' => [
				'title'   => 'Esqueci minha senha',
				'file' 	  => 'forgot-password',
				'packages' => ['atlantis-login']
			]
		]);

		$template->error([
			'title' => 'Falha ao renderizar template',
			'file' => '404',
			'packages' => ['atlantis-login']
		]);

	}else{
		# show error core
		$module->coreError("Internal Error" , $validate['message']);
	}


?>