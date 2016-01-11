<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_get.php';
	
	if(!empty($_GET['get'])){
		$get = $_GET['get'];
		
		if($get=='whitelistedAlbumns'){
			$table = "photos";
			$columns = ['faceBookID'];
			echo json_encode(getSpecificData($table, $columns));
		}
		
		if($get=='carousel'){
			$table = 'carousel_images';
			echo json_encode(getAllData($table));
		}
		
	}

?>