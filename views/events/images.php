<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_get.php';
	
	$table = 'events';
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
		$query = "SELECT image FROM $table WHERE id=$id";
		
		$data = runQuery($query);
		header("Content-type: image/jpeg");
		echo $data[0]['image'];
		
		
	}

?>