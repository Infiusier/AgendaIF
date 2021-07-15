<?php
	

	class CURL extends Module
	{

		protected $curlConnection;
		protected $appkey;
		protected $apptoken;
		protected $username;
		protected $pass;
		protected $response;
		protected $error;

		public function __construct($appkey, $apptoken, $username, $pass)
		{
			parent::__construct();
			$this->appkey 	= $appkey;
			$this->apptoken = $apptoken;
			$this->username = $username;
			$this->pass 	= $pass;
		}

		protected function send($set)
		{
			$this->curlConnection = curl_init();
			$set["environment"] = strtoupper($set['environment']);

			if( $set['environment'] == "VTEX" ){
				if( isset($set["header"]) and !empty($set["header"]) ){
					$headerConnection = $set["header"];
				}else{

					$headerConnection = array(
						'Accept: application/json',
						'Content-Type: application/json; charset=utf-8',
					  	'X-VTEX-API-AppKey: ' . $this->appkey,
					  	'X-VTEX-API-AppToken: ' . $this->apptoken
					);
				}
			}else{

				if( isset($set["header"]) and !empty($set["header"]) ){
					$headerConnection = $set["header"];
				}else{
					$headerConnection = array(
			  			"Accept: */*",
					    "Accept-Encoding: gzip, deflate",
					    "Authorization: Basic ".base64_encode($this->username . ":" . $this->pass),
					    "Cache-Control: no-cache",
					    "Connection: keep-alive",
					    "Host: 192.168.0.244:8204",
					    "Postman-Token: b0f477ce-521e-4d11-b562-34c72ad1ee0c,1ce6ef77-dcea-48a3-a98e-61158115f647",
					    "User-Agent: PostmanRuntime/7.17.1",
					    "cache-control: no-cache"
					);
				}
			}

			curl_setopt_array($this->curlConnection, array(
			  CURLOPT_URL => $set['url'],
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $set['method'],
			  CURLOPT_HTTPHEADER => $headerConnection,
			));

			# tratamento de dados de envio
			if( isset($set["content"]) ){
				curl_setopt_array($this->curlConnection, array(
				  CURLOPT_POSTFIELDS => json_encode($set['content'],JSON_UNESCAPED_UNICODE)
				));
			}

			# finalização
			$this->response = curl_exec($this->curlConnection);
			$this->error = curl_error($this->curlConnection);
			curl_close($this->curlConnection);
			
			if( !in_array($_SERVER["REMOTE_ADDR"], ['192.168.0.194']) ){

				# log request/response
				$log["datetime"] = date("Y-m-d H:i:s");
				$log["request"] = $set;
				$log["header"] = $headerConnection;
				$log["response"] = json_decode($this->response,true);
				$log["error"] = $this->error;

				# make directory
				if( $_SERVER["REMOTE_ADDR"] == "192.168.0.159" ){
					$logDir = parent::path() . "/storage/tmp/";
				}else{
					$logDir = parent::path() . "/storage/logs/curl/" . $_SERVER["REMOTE_ADDR"];
				}

				if( !file_exists($logDir) and is_dir($logDir) ){
					mkdir($logDir, 0777);
				}

				# save log
				if( is_dir($logDir) ){
					file_put_contents($logDir ."/".date("YmdHis").".json", json_encode($log,JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES));
				}
			}
			

			#return
			return utf8_encode($this->response);

		}
	}
?>