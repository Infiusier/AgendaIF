<?php

	
	/**
	* @category   DBSQL
	* @package    dbsql.src
	* @author     Eric Campos
	* @copyright  2019 Eric Campos
	* @license    http://www.php.net/license/3_0.txt  PHP License 3.0
	* @version    2.0
	*/


	class DB extends Connect{

		public function __construct(){
			parent::__construct();
		}

		public function insert($table, $data){

			$pdo = parent::get_instance();
			$fields = implode(", ", array_keys($data));
			$values = ":".implode(", :", array_keys($data));
			$query = "INSERT INTO $table";
			$query .= "($fields) ";
			$query .= "VALUES($values);";
			$statement = $pdo->prepare($query);

			foreach($data as $key=>$value){
				$value = filter_var($value);
				$statement->bindValue(":$key", $value, PDO::PARAM_STR);
			}

			if($statement->execute()){
				return $pdo->lastInsertId();
			}else{
				return false;
			}

		}

		public function select($table, $fields, $filters, $query_extra =""){
			
			$pdo = parent::get_instance();
			$query = "SELECT ";
			
			if($fields != null){
				$query .= implode(", ", $fields);
			}else{
				$query .= "*";
			}
			$query .= " FROM $table";

			if($filters != null){
				$query .= " WHERE ";
				foreach ($filters as $key => $value) {
					$query .= "$key=:$key AND ";
				}

				$query = substr($query, 0, -4);
			}

			$query .= $query_extra;

			//echo $query;
			
			$statement = $pdo->prepare($query);
			
			if($filters != null){

				foreach ($filters as $key => $value) {
					$value = filter_var($value);
					$statement->bindValue(":$key", $value, PDO::PARAM_STR);
				}

			}

			$statement->execute();

			if($statement->rowCount()){
				return $statement->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return false;
			}

		}

		public function update($table, $data, $filters, $query_extra=""){

			$pdo = parent::get_instance();
			$new_values = "";

			foreach ($data as $key => $value) {
				$new_values .= "$key=:$key, ";
			}

			$new_values = substr($new_values, 0, -2);

			foreach ($filters as $key => $value) {
				$filters_up = "$key=:$key AND ";
			}

			$filters_up = substr($filters_up, 0, -4);
			$query = "UPDATE $table SET $new_values WHERE $filters_up;";
			$query .= $query_extra;
			$statement = $pdo->prepare($query);

			foreach ($data as $key => $value) {
				$data[$key] = filter_var($value);

				$statement->bindValue(":$key", $value, PDO::PARAM_STR);
			}

			foreach ($filters as $key => $value){
				$statement->bindValue(":$key", $value, PDO::PARAM_STR);
			}
			
			if($statement->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function delete($table, $filters, $query_extra=""){

			$pdo = parent::get_instance();
			
			foreach ($filters as $key => $value) {
				$filters_delete = "$key=:$key AND ";
			}

			$filters_delete = substr($filters_delete, 0, -4);
			$query = "DELETE FROM $table WHERE $filters_delete;";
			$query .= $query_extra;
			$statement = $pdo->prepare($query);

			foreach ($filters as $key => $value){
				$statement->bindValue(":$key", $value, PDO::PARAM_STR);
			}

			if($statement->execute()){
				return true;
			}else{
				return false;
			}

		}

		public function select_join($tables, $relationships, $filters, $query_extra = ""){

			$pdo = parent::get_instance();
			$query = "SELECT ";
		
			foreach ($tables as $table=>$fields){
				if(!empty($fields)){
					foreach ($fields as $each_field){
						$query .= "$table.$each_field, ";
					}
				}else{
					$query .= "$table.*, ";
				}
			}

			$query = substr($query, 0, -2);
			$tables_names = array_keys($tables);
			$query .= " FROM ".implode(" INNER JOIN ", $tables_names);
			
			$query .= " ON ";
			foreach($relationships as $foreign=>$primary){
				$query .= "$foreign=$primary AND "; 
			}

			$query = substr($query, 0, -4);
			
			if(isset($filters)){
				$query .= " WHERE ";
				foreach($filters as $field=>$value){
					$query .= "$field=:$field AND ";
				}
				$query = substr($query, 0, -4);
			}

			$query .= $query_extra;

			//echo $query;

			$statement = $pdo->prepare($query);
			
			if(isset($filters)){

				foreach ($filters as $key => $value) {
					//$value = filter_var($value);

					$statement->bindValue(":$key", $value, PDO::PARAM_STR);
				}
			}

			$statement->execute();
			$data = "";

			if($statement->rowCount()){

				while($result = $statement->fetchAll(PDO::FETCH_ASSOC)){
					$data = $result;
				}

				return $data;
			}else{
				return false;
			}
		}

	}

?>