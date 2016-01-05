<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	
	$table  = "photos";
	
	if(!empty($_GET['faceBookID'])){
		$insert = "DELETE FROM ".getTableQuote($table)." WHERE faceBookID=".$_GET['faceBookID'].";";
		runInsert($insert);
	}
	
?>