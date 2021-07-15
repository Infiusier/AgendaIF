<?php
	

	class Spreadsheet extends Atom
	{
		private $filename;
		private $storage;
		private $destiny;
		private $scope;
		private $fields;
		public $data;

		public function __construct()
		{
			parent::__construct();
			$this->filename = date("ymdhis").".xls";
			$this->destiny = parent::path()."/storage/spreadsheet/";
			$this->scope = "";
			$this->fields = "";
			$this->data = "";
		}

		public function setFilename($name)
		{
			$this->filename = $name;
		}

		public function setFields($fields = array())
		{
			$this->fields = "<td>" . implode("</td><td>", $fields) . "</td>";

			return $this;
		}

		public function setContent($content = array())
		{
			$this->data .= "<tr><td>" . implode("</td><td>", $content) . "</td></tr>";

			return $this;
		}

		public function make()
		{
			if( $this->scope == "" ){
				$this->scope = "
					<table>
						<tr>
							".$this->fields."
						</tr>
						".$this->data."
					</table>
				";
			}

			return $this;
		}

		public function setTable($table){
			$this->scope = $table;

			return $this;
		}

		public function dump()
		{
			$this->make();
			header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment;filename="'.$this->filename.'"');
		    header('Cache-Control: max-age=0');
		    header('Cache-Control: max-age=1');
		    echo $this->scope;  
		    exit;
		}

		public function save($optionalUrl = null)
		{
			$this->make();
			header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment;filename="'.$this->filename.'"');
		    header('Cache-Control: max-age=0');
		    header('Cache-Control: max-age=1');

			$locale = ($optionalUrl!=null) ? $this->destiny . $this->filename : $optionalUrl ."/".$this->filename;
			if( file_put_contents($locale, $this->scope) ){
				return [
					'error' => false,
					'message' => 'Arquivo gravado com sucesso em ' . $optionalUrl
				];
			}else{
				return [
					'error' => true,
					'message' => 'falha ao salvar arquivo xls em ' . $optionalUrl
				];
			}
		}
	}
?>