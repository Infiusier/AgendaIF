<?php 
	

	class UserNotification extends User {

		private $data;
		private $tNot;
		private $relNot;

		public function __construct(){

			parent::__construct();

			$this->tbNot['vth_usuarios'] = [];
			$this->tbNot['vth_notificacoes'] = [];
			$this->relNot['vth_notificacoes.usuario_id'] = "vth_usuarios.id_usuario";			
		}

		public function set($data = array()){

			$this->data = $data;
			$this->data['notificacao_visualizado'] = 0;
			$this->data['notificacao_alertasonoro'] = 0;

			return $this;
		}

		# inserir notificações para todos
		public function sendAll($filter = null,$extra = null){
			if( !empty($this->data) ){
				$users = parent::get($filter,$extra);
				if( $users ){
					foreach($users as $user){
						$this->data["usuario_id"] = $user["id_usuario"];
						parent::insert("vth_notificacoes",$this->data, null);
					}
				}
			}else{
				return false;
			}
		}

		# inserir notificações por setor
		public function bySector($id_sector){
			if( !empty($this->data) ){
				$users = parent::get(["id_setor" => $id_setor]);
				foreach($users as $user){
					$this->data["usuario_id"] = $user["id_usuario"];
					parent::insert("vth_notificacoes",$this->data,null);
				}
			}else{
				return false;
			}
		}

		# inserir notificacoes por cargo
		public function byOffice($filter = null){
			if( !empty($this->data) ){
				$users = parent::get($filter);
				foreach($users as $user){
					$this->data["usuario_id"] = $user["id_usuario"];
					parent::insert("vth_notificacoes",$this->data,null);
				}
			}else{
				return false;
			}
		}

		# retornar todas as notificações pendentes
		public function pending(){
			$user = Session::get();
			return parent::select_join($this->tbNot,$this->relNot,["id_usuario" => $user["id_usuario"],"notificacao_visualizado" => 0,"notificacao_alertasonoro" => 0]," order by notificacao_datacadastro desc");
		}

		# função que desmarca os pendentes de beep alert
		public function endBeepAlert(){
			$user = Session::get();
			parent::update("vth_notificacoes",["notificacao_alertasonoro" => 1],["usuario_id" => $user["id_usuario"]],null);
		}

		# get de minhas notificações
		public function getNotify(){
			$user = Session::get();
			return parent::select_join($this->tbNot, $this->relNot, ["id_usuario" => $user["id_usuario"]], " order by notificacao_datacadastro desc");
		}

		public function checkView($id){
			parent::update("vth_notificacoes",["notificacao_visualizado"=>1],["id_notificacao"=>$id],null);
		}

		public function getAll($filter = null, $extra = null){
			return parent::select_join($this->tbNot,$this->relNot,$filter,$extra);
		}
	}
?>