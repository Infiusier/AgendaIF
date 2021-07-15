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
			'meus-tickets' => [
				'title'   => 'Meus Tickets',
				'file' 	  => 'meus-tickets',
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