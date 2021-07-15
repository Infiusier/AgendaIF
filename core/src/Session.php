<?php
	

	class Session extends Core {

		private static $server;
		private static $name;
		private static $path;

		public function __construct(){

			parent::__construct();

			$core = new Core();

			if( $core->login_access_status == 1 ){
				self::$name = $core->login_access_name;
			}

			self::$path = $this->routes['path'];
		}

		public static function new($data = array(), $name = null ){

			@session_start();
			$name = ($name == null) ? self::$name : $name;
			$data['server'] = $_SERVER;
			$_SESSION[sha1($name)] = $data;
			Session::log($data);

		}

		public static function auth($name = null){

			@session_start();
			$name = ($name == null) ? self::$name : $name;
			return isset($_SESSION[sha1($name)]);

		}

		
		public static function get($name = null){

			@session_start();
			$name = ($name == null) ? self::$name : $name;
			return (Session::auth($name)) ? $_SESSION[sha1($name)] : false;

		}

		public static function edit($data = [], $name = null){
			@session_start();
			$name = ($name == null) ? self::$name : $name;
			if( Session::auth($name) ){

				$log = Session::get($name);
				foreach($data as $k => $v){
					$log[$k] = $v;
				}

				$_SESSION[sha1($name)] = $log;

				return true;
			}else{
				return false;
			}
		}

		public static function log($data){

			$logPath = self::$path . "/storage/logs/session/" . date('Y-m-d') . ".json";
			if( file_exists($logPath) ){
				$log = json_decode(file_get_contents($logPath),true);
				array_unshift($log, $data);
				file_put_contents($logPath, json_encode($log));
			}else{
				$new = [];
				$new[] = $data;
				file_put_contents($logPath, json_encode($new));
				chmod($logPath, 0777);
			}

		}

		public static function done($name = null){

			@session_start();
			if($name == null){
				session_destroy();
			}else{
				unset($_SESSION[sha1($name)]);
			}

		}

	}
?>