<?php
	
	$module   = new Module();
	$template = new TEngine();

	# validate view
	if( $module->uri(2) == false ){
		$module->goToModule();
	}

	# validando session
	if( !Session::auth() ){
		header("Location: " . $module->index());
	}

	$validate = $module->validate();

	if( $validate['error'] == false ){
		
		# default routes
		$template->set([
			'usuarios' => [
				'title'   => 'Controle de Usuários',
				'file' 	  => 'usuarios',
				'packages' => ['atlantis-default','datatable']
			],
			'setores' => [
				'title'   => 'Controle de Setores',
				'file' 	  => 'setores',
				'packages' => ['atlantis-default']
			],
			'cargos' => [
				'title'   => 'Controle de Cargos',
				'file' 	  => 'cargos',
				'packages' => ['atlantis-default']
			],
			'configuracoes' => [
				'title'   => 'Configurações',
				'file' 	  => 'configuracoes',
				'packages' => ['atlantis-default','datatable']
			],
			'perfil' => [
				'title'   => 'Meu Perfil',
				'file' 	  => 'perfil',
				'packages' => ['atlantis-default']
			],
			'auditoria' => [
				'title'   => 'Auditorias',
				'file' 	  => 'auditoria',
				'packages' => ['atlantis-default','datatable']
			],
			'notificacoes' => [
				'title'   => 'Notificações',
				'file' 	  => 'notificacoes',
				'packages' => ['atlantis-default','datatable']
			]
		]);

		$template->error([
			'title' => 'Falha ao renderizar template',
			'file' => '404',
			'packages' => ['atlantis-default']
		]);

	}else{
		# show error core
		$module->coreError("Internal Error" , $validate['message']);
	}


?>