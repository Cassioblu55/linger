<?php
	include_once '../config/config.php';
	include_once $serverPath . 'utils/db_get.php';
	$table = "photos";
	
	if($_GET['get']=='whitelistedAlbumns'){
		$columns = ['faceBookID'];
		echo json_encode(getSpecificData($table, $columns));
	}

?>