<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();

		# verificando se existe usuario entrelaçado
		$search = $db->select("vth_usuarios",["id_usuario"],["cargo_id"=>$_POST["id_cargo"]],null);
		if( $search ){
			header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Não é possivel deletar o cargo pois existem usuarios pertencentes a ela ainda, total:" . count($search)));
		}else{
			if( $db->delete("vth_us_cargos",$_POST,null) ){
				header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(true, "Cargo Deletado"));
			}else{
				header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Cargo não deletado..."));
			}
		}
		
	}else{
		header("Location: " . $app->index() . "/sistema/cargos/" . Helper::notification(false, "Sem requisição"));
	}