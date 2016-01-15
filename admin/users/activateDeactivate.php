<?php
include_once '../../config/config.php';
include_once $serverPath.'admin/login/requireAdmin.php';
include_once $serverPath.'utils/db_post.php';
include_once $serverPath.'utils/db_get.php';

$table = 'users';
$_POST = json_decode(file_get_contents('php://input'), true);
if(!empty($_POST)){
	if(!empty($_POST['email']) && !empty($_POST['id']) && $_POST['id'] != $_SESSION['user']['id']  && ($_POST['active']==1 || $_POST['active']==0 )){
		$user = findById($table, $_POST['id']);
		if($user['protected'] != '1'){
			$update = "Update ".getTableQuote($table)." SET active=".$_POST['active']." WHERE id=".$_POST['id'].";";
			runInsert($update);
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From:'.$webmasterMail.' <'.$webmasterMail.'>' . "\r\n";
			
			$activated = ( $_POST['active']==0) ? 'deactivated' : 'activated';
			$link = ( $_POST['active']==1) ? '<p>Click here to login: <a href="'.$externalLink.'admin/login/">Login</a></p>' : '';
			
			$message = "
					<html>
						<body>
						<p>Your account has been $activated</p>
						$link
			
					</body>
			
					</html>
					";
			
			$subject = "Your account has been $activated for The Linger Martini Bar";
			mail($_POST['email'], $subject, $message, $headers);
			
			}
		
	}
	
	
}



?>
