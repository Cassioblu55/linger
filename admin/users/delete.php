<?php
include_once '../../config/config.php';
include_once $serverPath.'admin/login/requireAdmin.php';
include_once $serverPath . 'utils/db_post.php';
include_once $serverPath.'utils/db_get.php';

if (! empty ( $_GET['id'] ) && $_SESSION['user']['id'] != $_GET['id']){	
	$table  = "users";
	$user = findById($table, $_GET['id']);
	if($user['protected'] != 1){
			deleteFrom($table, $_GET['id']);
	}
	
	
	
}
?>