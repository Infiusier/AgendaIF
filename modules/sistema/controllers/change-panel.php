<?php
	

	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( Session::auth() ){

		$db = new DB();
		$account = $db->select("vth_contas",null,["id_conta" => $_POST["id_conta"]],null);
		
		if( $account ){
			$edit = Session::edit($account[0]);
			if( $edit ){

				echo json_encode([
					'error' => false
				]);

			}else{

				echo json_encode([
					'error' => true,
					'message' => 'Falha ao modificar conta...'
				]);
			}
		}else{

			echo json_encode([
				'error' => true,
				'message' => 'Conta não encontrada...'
			]);
		}

	}else{

		echo json_encode([
			'error' => true,
			'message' => 'Usuário não logado...'
		]);
	}