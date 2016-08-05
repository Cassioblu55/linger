<?php
include_once '../config/config.php';
include_once $serverPath.'utils/db_get.php';

$table = 'drinks';
if($_GET['get'] == 'menu'){
	echo json_encode(getAllData($table));
}

?>