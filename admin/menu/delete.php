<?php
include_once '../../config/config.php';
include_once $serverPath.'admin/login/requireAdmin.php';
include_once $serverPath . 'utils/db_post.php';
if (! empty ( $_GET['id'] )){
	$table  = "drinks";
	deleteFrom($table, $_GET['id']);
}
?>