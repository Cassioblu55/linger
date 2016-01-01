<?php

include_once '../../config/config.php';
include_once $serverPath.'utils/db_get.php';
$table = 'events';

if(!empty($_GET['id'])){
	$id = $_GET['id'];
	echo json_encode(findById($table, $id));
}

if(!empty($_GET['startDate']) && !empty($_GET['endDate'])){
	$startDate = $_GET['startDate'];
	$endDate = $_GET['endDate'];
	$query= "Select * FROM ".getTableQuote($table)." WHERE active='Yes' AND ((startDate <= $endDate AND endDate >= $startDate) 
				OR (startDate=0 AND endDate >= $startDate) OR  (startDate <= $endDate AND endDate=0) OR (startDate=0 AND endDate=0));";
	echo json_encode(runQuery($query));
}

?>