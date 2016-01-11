<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	if(!empty($_GET['type'])){
		$type = $_GET['type'];
		
		if($type == 'carousel_image'){
			$_POST = json_decode(file_get_contents('php://input'), true);
			if(!empty($_POST)){
				$table = 'carousel_images';
				updateFromPost($table);		
			}
		}
		
	}
	
?>