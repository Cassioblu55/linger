<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_get.php';
	
	$table = "drinks";
	
	if(!empty($_GET['get'])){
		$get = $_GET['get'];
		if($get == "grid"){
			echo json_encode(getAllData($table));
		}
	}

	if(!empty($_GET['id'])){
		$id = $_GET['id'];
		echo json_encode(findById($table, $id));
	}
	
?>