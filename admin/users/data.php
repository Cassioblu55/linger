<?php

include_once '../../config/config.php';
include_once $serverPath.'admin/login/requireAdmin.php';
include_once $serverPath.'utils/db_get.php';

$table = 'users';
if(!empty($_GET['get'])){
	$get = $_GET['get'];
	
	if($get =='grid'){
		$query = "SELECT id, username, email, active FROM ".getTableQuote($table)." WHERE protected != 1;";
		
		echo json_encode(runQuery($query));
	}
}

?>
