<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	
		if(!empty($_GET['faceBookID'])){
			$table  = "photos";
			insert($table, ['faceBookID' =>$_GET['faceBookID']]);
		}
		
		if(!empty($_GET['carousel_image'])){
			$_POST = json_decode(file_get_contents('php://input'), true);
			if(!empty($_POST)){
				$table = 'carousel_images';
				insert($table, ['image' =>$_POST['image']]);
				
			}
		}
	

?>