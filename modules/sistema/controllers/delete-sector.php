<?php
	
	# autoload application
	require dirname(dirname(dirname(__DIR__))) . "/autoload.php";

	$app = new Module();

	if( isset($_POST) ){

		$db = new DB();

		# verificando se existe usuario entrelaçado
		$search = $db->select("vth_usuarios",["id_usuario"],["setor_id"=>$_POST["id_setor"]],null);
		if( $search ){
			header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "Não é possivel deletar o setor pois existem usuarios pertencentes a ela ainda, total:" . count($search)));
		}else{
			if( $db->delete("vth_us_setores",$_POST,null) ){
				header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(true, "setor Deletado"));
			}else{
				header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "setor não deletado..."));
			}
		}
		
	}else{
		header("Location: " . $app->index() . "/sistema/setores/" . Helper::notification(false, "Sem requisição"));
	}