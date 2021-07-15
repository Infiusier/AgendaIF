<?php
	

	class Connect extends Module {

		private $connection;
		private $db = [];

		public function __construct(){
			parent::__construct();
		}

		protected function get_instance() {

			try{
				$this->connection = new PDO("mysql:host=".$this->dbconfig->dbhost.";dbname=" . $this->dbconfig->dbname, $this->dbconfig->dbuser, $this->dbconfig->dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->connection->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
				return $this->connection;
			}catch(PDOException $e){
				return false;
			}
		}

		public function status(){
			if( !$this->get_instance() ){
				echo "Conexão com o banco de dados falhou !!!";
			}
		}

	}
?>