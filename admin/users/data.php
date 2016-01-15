<?php

include_once '../../config/config.php';
include_once $serverPath.'admin/login/requireAdmin.php';
include_once $serverPath.'utils/db_get.php';

$table = 'users';
if(!empty($_GET['get'])){
	$get = $_GET['get'];
	
	if($get =='grid'){
		$columns = ['username', 'email', 'active'];
		echo json_encode(getSpecificData($table, $columns));
	}
}

?>
