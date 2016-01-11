<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	
	
	if(!empty($_GET['faceBookID'])){
		$table  = "photos";
		$insert = "DELETE FROM ".getTableQuote($table)." WHERE faceBookID=".$_GET['faceBookID'].";";
		runInsert($insert);
	}
	
	if(!empty($_GET['carousel_image_id'])){
		$table  = "carousel_images";
		deleteFrom($table, $_GET['carousel_image_id']);
	}
	
?>