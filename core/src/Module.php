<?php
	

	class Module extends Atom {

		protected $md_app;
		protected $md_name;
		protected $md_view;
		protected $md_path;
		protected $md_config;
		protected $md_404;

		public function __construct(){

			parent::__construct();
		
			# valor default do modulo
			$this->md_name = (parent::uri(1) != false) ? parent::uri(1) : $this->config->default_module;

			# validação secundária interna de modulo
			$validateModule = $this->validate();
			if( $validateModule['error'] == false ){

				# validação terciaria, sessão
				$this->md_path = parent::path() . "/modules/" . $this->md_name;
				$this->md_config = Scan::configAtom( $this->md_path . "/config.module" );

				# valor default da view
				$this->md_view = (parent::uri(2) != false) ? parent::uri(2) : $this->md_config->default_view;

				if( $this->config->login_access_status == 1 and $this->md_config->use_session == 1 ){
					if( !Session::auth() ){
						$this->md_name = $this->config->login_access_module;
						$this->md_view = $this->config->login_access_view;
					}
				}

			}else{
				# erro de core
				if( $this->config->debug  == 1 ){
					Core::coreError("Module Error" , $validateModule['message']);
				}
			}
		}

		public function render(){
			# validate module
			$validate = $this->validate();

			if( $validate['error'] == false ){

				# redirect do modulo e view carregados
				if( parent::uri(2) == false ){
					$this->redirect();
				}

				# load models of module
				$this->loadModels();
				
				###### start application #########
				# init validate module
				require $this->md_path . "/validate.php";
				# init helpers module
				require $this->md_path . "/helpers.php";
				# init base application
				require parent::path() . "/app/" . $this->md_config->app . ".php";

			}else{

				# redirect do modulo e view carregados
				if( parent::uri(2) == false ){
					$this->redirect();
				}

				if( $this->config->debug  == 1 ){
					parent::coreError("Error Module", $validate['message']);
				}
			}		
		}

		public function sortClass($foo){

			$return = [];
			$saporra = [];
		    foreach($foo as $k=>$a){
		        $saporra[$k] = strlen($a);
		    }

		    asort($saporra);
		    
		    foreach($saporra as $chaveDesseKrl => $aPorraDoArquivo){
		        $return[] = $foo[$chaveDesseKrl];
		    }

		    return $return;   
		}

		public function loadModels($module = null, $class = null){

			$modules = [];

			$this->md_name = ($module == null) ? $this->md_name : $module;

			if( $class != null and is_array($class) ){

				foreach($class as $c){
					$modules[] = $this->path() . "/modules/" . $this->md_name . "/models/" . $c . ".php";
				}

			}else{

				$modules = Scan::dir($this->path() . "/modules/" . $this->md_name . "/models");
				$modules = $this->sortClass($modules);

			}

			if( !empty($modules) ){
				foreach($modules as $md){
					require_once $md;
				}
			}
		}

		protected function authModule(){
			if( $this->config->login_access_status  == 1 and $this->md_config->use_session == 1 ){

				if( !Session::auth() ){

					$this->md_name = $this->config->login_access_module;
					$this->md_path = parent::path() . "/modules/" . $this->md_name;
					$this->md_config = Scan::configAtom( $this->md_path . "/config.module" );


					if( $this->md_config->use_session == 1 ){
						if( $this->config->debug  == 1 ){
							Core::coreError("Erro de modularização","Você não pode definir um modulo de autenticação como usuário de sessão, no seu arquivo de configuração do modulo em /modules/".$this->md_name."/config.module altere o campo use_session para 0. ex: use_session=0");
						}
					}else{
						header("Location: " . parent::index() . "/" . $this->config->login_access_module . "/" . $this->config->login_access_view);
					}

				}else{

					$this->md_name = (parent::uri(1) != false) ? parent::uri(1) : $this->config->default_module;
					$this->md_path = parent::path() . "/modules/" . $this->md_name;
					$this->md_config = Scan::configAtom( $this->md_path . "/config.module" );

					header("Location: " . parent::index() . "/" . $this->md_name . "/" . $this->md_view);
				}

			}
		}

		public function getModules(){

			$response= [];
			$modules = Scan::dir(parent::path() . "/modules");
			if( !empty($modules) ){
				foreach($modules as $pathModule){
					$md_config = Scan::configAtom($pathModule . "/config.module");
					if( $md_config->visibility == 'public' and !in_array($md_config->name, $response) ){
						$response[] = $md_config->name;
					}
				}
			}

			return $response;
		}
	
		protected function validate(){

			$pathModule = parent::path()."/modules/".$this->md_name;
			# check if exist base
			if( file_exists($pathModule) ){
				if( file_exists($pathModule."/validate.php") ){
					if( file_exists($pathModule."/config.module") ){
						return [
							'error' => false
						];
					}else{
						# config file not found
						return [
							'error' => true,
							'message' => 'config.module not found...'
						];
					}
				}else{
					# validate.php not found
					return [
						'error' => true,
						'message' => 'validate.php not found...'
					];
				}
			}else{

				# module not found
				return [
					'error' => true,
					'message' => 'module ' . $this->md_name . ' not found...'
				];
			}
		}

		public function redirect($module = null, $view = null){
			$this->md_name = ($module != null) ? $module : $this->md_name;
			$this->md_view = ($view != null) ? $view : $this->md_view;
			$urlTo = parent::index() . "/" . $this->md_name . "/" . $this->md_view;
			$urlFrom = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if( $urlFrom != $urlTo ){
				header("Location: " . $urlTo);
			}
		}
	}
?>