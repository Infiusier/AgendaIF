<?php


	class TEngine extends Module {

		private $packages;
		private $errors;

		public function __construct(){

			parent::__construct();

			if( file_exists(parent::path() . "/public/packages.json") ){
				$this->packages = json_decode(file_get_contents(parent::path()."/public/packages.json"),true);
			}else{
				$this->packages = false;
			}
		}

		public function set($data){
			if( isset( $data[parent::uri(2)]) ){
				$GLOBALS['template_engine'] = $data[parent::uri(2)];
			}else{
				$GLOBALS['template_engine'] = false;
			}
		}

		public function error($data = array()){
			if( isset($GLOBALS['template_engine']) and $GLOBALS['template_engine'] == false ){
				$GLOBALS['template_engine'] = $data;
			}
		}

		public function invokeView(){

			if( isset($GLOBALS['template_engine']) ){
				
				$path = $this->md_path . "/views/" . $GLOBALS['template_engine']['file'] . ".php";
				if( file_exists($path) ){
					require $path;
				}else{
					# load 404, view not found
					parent::coreError("Error 404", "File not found...");
				}

			}else{
				parent::coreError("Error 500","Failed to render module...");
			}
		}

		public function component($name){

			# invoke theme component
			$pathComponent = parent::path() . "/app/components/" . $name . ".php";
			if( file_exists($pathComponent) ){
				require $pathComponent;
			}else{
				parent::coreError("Failed to include", "Component " .$name. " not found...");
			}
		}

		public function title(){
			if( isset($GLOBALS['template_engine']) ){
				return $GLOBALS['template_engine']['title'];
			}else{
				return 'title view not found...';
			}
		}

		public function css(){
			if( isset($GLOBALS['template_engine']['packages']) ){
				$output = "\n";
				foreach($GLOBALS['template_engine']['packages'] as $pack){
					foreach($this->packages[$pack]['css'] as $css){

						$remote = substr($css,0,4);
						$css = ($remote != "http") ? parent::index() . "/" . $css : $css;

						$output .= '<link rel="stylesheet" type="text/css" href="'.$css.'" />'."\n";
					}
				}

				echo $output;
			}else{
				return false;
			}
		}

		public function js(){

			if( isset($GLOBALS['template_engine']['packages']) ){
				$output = "\n";
				foreach($GLOBALS['template_engine']['packages'] as $pack){
					foreach($this->packages[$pack]['js'] as $js){

						$remote = substr($js,0,4);
						$js = ($remote != "http") ? parent::index() . "/" . $js : $js;

						$output .= '<script src="'.$js.'"></script>'."\n";
					}
				}

				echo $output;
			}else{
				return false;
			}
		}
	}
?>