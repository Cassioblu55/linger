<?php
if(empty($_GET['id'])){
	header("Location: ". $baseURL."views/events/");
}

include_once '../../config/config.php';
include_once  $serverPath.'resources/templates/head.php';
?>



