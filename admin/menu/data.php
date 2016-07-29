<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_get.php';
	
	$table = "drinks";

mysqli_set_charset(connect(), "utf8");

	if(!empty($_GET['get'])){
		$get = $_GET['get'];
		if($get == "grid"){
			$data = getAllData($table);
			echo json_encode($data, true);
		}elseif ($get=="drink_types"){
			$queryStatement = "SELECT DISTINCT(type) FROM $table;";
			$data = runQuery($queryStatement);
			$array = [];
			foreach ($data as $row){
				array_push($array, $row['type']);
			}


			echo json_encode($array);
		}
	}

	if(!empty($_GET['id'])){
		$id = $_GET['id'];
		echo json_encode(findById($table, $id));
	}
?>