<?php
	
	class Scan {

		public static function configAtom($atom_file){

			if( file_exists($atom_file) ){
				$configAtom = file($atom_file);
				$response = [];
				foreach($configAtom as $config){
					$pieces = explode("=", $config);
					$response[$pieces[0]] = trim($pieces[1]); 
				}
				return (object) $response;
			}else{
				return false;
			}
		}

		public static function dir($path){

			$response = [];
			if( file_exists($path) ){
				$global = dir($path);
				while( $file = $global->read() ){
					if( !in_array($file, ['.','..']) ){
						$response[] = $path."/".$file;
					}
				}
				return $response;
			}else{
				return [];
			}
		}
	}
?>