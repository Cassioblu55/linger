<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	
	$table  = "photos";
	
		if(!empty($_GET['faceBookID'])){
			insert($table, ['faceBookID' =>$_GET['faceBookID']]);
		}
	

?>