<?php
	

	class User extends DB
	{
		protected $tables;
		protected $rell;
		protected $accountid;

		public function __construct(){

			parent::__construct();

			if( Session::auth() ){
				$user = (object) Session::get();
				$this->accountid = $user->id_conta;
			}else{
				$this->accountid = 0;
			}

			$this->tables['vth_usuarios'] = [];
			$this->tables['vth_contas'] = [];
			$this->tables['vth_us_cargos'] = [];
			$this->tables['vth_us_setores'] = [];
			//$this->tables['log_filiais'] = [];

			$this->rell['vth_usuarios.conta_id'] = "vth_contas.id_conta";
			$this->rell['vth_usuarios.cargo_id'] = "vth_us_cargos.id_cargo";
			$this->rell['vth_usuarios.setor_id'] = "vth_us_setores.id_setor";
			//$this->rell['vth_usuarios.filial_id'] = "log_filiais.id_filial";
		}

		public function get($filter = null, $extra = null)
		{
			//$filter["id_conta"] = $this->accountid;
			return parent::select_join($this->tables, $this->rell, $filter, $extra);
		}

		public function post($data){
			$data["conta_id"] = $this->accountid;
			return parent::insert("vth_usuarios",$data,null);
		}

		public function put($data, $filter, $extra = null){
			if( $data == null or $filter == null){
				return false;
			}else{
				return parent::update("vth_usuarios",$data,$filter, $extra);
			}
		}

		public function del($filter, $extra = null){
			return parent::delete("vth_usuarios",$filter, $extra);
		}

	}	
?>