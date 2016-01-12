<?php
	include_once '../config/config.php';
	include_once $serverPath.'utils/db_get.php';
	
	if($_GET['get']){
		$get = $_GET['get'];
		
		if($get=='carousel'){
			$table ='carousel_images';
			echo json_encode(getAllData($table));
		}
		
		if($get=='events'){
			$table = 'events';
			echo json_encode(getAllData($table));
		}
		
	}
	
?>

