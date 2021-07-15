<?php
	

	class Helper {

		public static function json($string)
		{
			return utf8_decode(utf8_encode($string));
		}

		public static function productColors(){
			$colors["ROXO"] = "purple";
			$colors["BRANCO"] = "white";
			$colors["ROSA"] = "pink";
			$colors["VERDE"] = "green";
			$colors["PRETO"] = "black";
			$colors["AZUL"] = "blue";
			$colors["VERMELHO"] = "red";

			return $colors;
		}

		public static function checkCheckboxStatus($status)
		{
			$checked = "";
			if( Session::auth('search-order') ){
				$check = Session::get("search-order");
				if( isset($check["pedido_status"]) and !empty($check["pedido_status"]) ){
					if( in_array($status, $check) ){
						$checked = "checked";
					}
				}
			}

			return $checked;
		}

		public static function checkOrderDateStatus($date){
			$dateNow = new DateTime(date('Y-m-d H:i:s'));
			$dateOrder = new DateTime($date);
			$dateInterval = $dateOrder->diff($dateNow);
			if( $dateInterval->d == 0 and $dateInterval->h < 2){
				$blinkEffect = ($dateInterval->i <= 10) ? 'fa-blink' : '';
				return '<p class="'.$blinkEffect.' text-warning font-weight-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> há ' . $dateInterval->i . ' min</p>';
			}else{
				return date('d/m/Y',strtotime($date));
			}
		}

		public static function adminPermission($id = null){
			if( $id == null ){
				if( Session::auth() ){
					$user = Session::get();
					return (in_array($user['id_cargo'], [1,2,3])) ? true : false;
				}else{
					return false;
				}
			}else{
				return (in_array($id, [1,2,3])) ? true : false;
			}
		}

		public static function notification($success = true, $message = "Notificação de sistema"){
			if( $success ){
				return "/alert/" . base64_encode("success=" . $message);
			}else{
				return "/alert/" . base64_encode("error=" . $message);
			}
		}

		public static function simpleArrangement($elements, $sizeArrange, $combinations = []){
			
			$combinations = (empty($combinations)) ? $elements : $combinations;

			if( $sizeArrange == 1 ){
				return $combinations;
			}

			$newCombination = [];

			foreach($combinations as $combination){
				foreach($elements as $element){
					if( $combination != $element ){
						$newCombination[] = [$combination=>$element];
					}
				}
			}

			return Helper::simpleArrangement($elements,($sizeArrange - 1),$newCombination);
		}

		public static function sanitize($string){
			$from 	= array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
			$_to 	= array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U');
			return str_replace($from, $_to, $string);
		}

		public static function br_date($date){
			return date("d/m/Y", strtotime($date));
		}

		public static function vtexMoney($money){
			return number_format(($money/100),2);
		}

		public static function libStatus(){
			return [
				'invoiced' => [
					'icon' => 'fa fa-check-square-o',
					'bg' => 'success'
				],
				'window-to-cancel' => [
					'icon' => 'fa fa-circle-o-notch fa-spin',
					'bg' => 'info'
				],
				'ready-for-handling' => [
					'icon' => 'fa fa-hand-paper-o',
					'bg' => 'primary'
				],
				'handling' => [
					'icon' => 'fa fa-truck',
					'bg' => 'warning'
				],
				'payment-pending' => [
					'icon' => 'fa fa-credit-card',
					'bg' => 'warning'
				],
				'payment-approved' => [
					'icon' => 'fa fa-credit-card',
					'bg' => 'info'
				],
				'canceled' => [
					'icon' => 'fa fa-times',
					'bg' => 'danger'
				],
				'cancellation-requested' => [
					'icon' => 'fa fa-clock',
					'bg' => 'danger'
				],
				'waiting-ffmt-authorization' => [
					'icon' => 'fa fa-clock-o',
					'bg' => 'warning'
				]
			];
		}

		public static function avatar($name = "default.png"){

			$http = substr($name, 0, 4);
			if( $http == "http" ){
				return $name;
			}else{
				$app = new Module();
				if( file_exists($app->path() . "/storage/avatar/" . $name) and !is_dir($app->path() . "/storage/avatar/" . $name) ){
					return $app->index() . "/storage/avatar/" . $name;
				}else{
					return $app->index() . "/app/components/imgs/default-user-image.png";
				}
			}
		}

		public static function folder($name = "default.png"){

			$http = substr($name, 0, 4);
			if( $http == "http" ){
				return $name;
			}else{
				$app = new Module();
				if( file_exists($app->path() . "/storage/folder/" . $name) and !is_dir($app->path() . "/storage/folder/" . $name) ){
					return $app->index() . "/storage/folder/" . $name;
				}else{
					return $app->index() . "/app/components/imgs/default-folder.png";
				}
			}
		}

	}
?>