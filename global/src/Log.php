<?php
	

	class Log {

		public static function new($path, $data){
			if( file_exists($path) ){
				file_put_contents($path . date("Y-m-d-H-i-s") . ".log", json_encode($data));
			}else{
				# gerar log de sistema, lembrar disso
			}
		}

	}
?>