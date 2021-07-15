<?php
	
	class Core {

		protected $config;
		protected $routes;
		protected $dbconfig;

		public function __construct(){
			# loading app define
			$this->config = Scan::configAtom(dirname(dirname(__DIR__)) . "/core/config/config.atomo");

			if( $this->config ){
				# make routes
				$this->routes['index'] = $this->config->protocol . "://" . $_SERVER['SERVER_NAME'] . $this->config->folder;
				$this->routes['path'] = $_SERVER['DOCUMENT_ROOT'] . $this->config->folder;
				# make object routes
				$this->routes = (object) $this->routes;
				# make engine db
				$this->dbconfig = $this->engineDB();
			}else{
				$this->coreError("Internal error", "Core is fail...");
			}
		}

		protected function engineDB(){
			switch($this->config->engine_db){
				case "pdo-mysql":
					$this->dbconfig = Scan::configAtom(dirname(dirname(__DIR__)) . "/core/src/db/mysql/db-config.atomo");
					# include pdo files
					include_once $this->routes->path . "/core/src/db/mysql/Connect.php";
					include_once $this->routes->path . "/core/src/db/mysql/DB.php";
				break;
			}

			return $this->dbconfig;
		}

		public function coreError($title, $content){
			echo '
				<fieldset style="background: #444;">
					<legend style="padding: 20px; background: darkred; color: #fff;">
						<b>'.$title.'</b>
					</legend>
					<h2 style="font-weight: bold; padding: 10px;color: #ddd;">'.$content.'</h2>
					<p style="color: #ccc; padding: 10px;">
						<img src="https://images.vexels.com/media/users/3/153024/isolated/preview/b954f58d35c3eb88de83550322d3ff53-atom-school-illustration-by-vexels.png" height="40" width="auto" />
						<b>Atomo Framework</b> - report at: '.date('d/m/Y').' in '.date('H:i:s') .'
					</p>
				</fieldset>
			';
		}

	}
?>