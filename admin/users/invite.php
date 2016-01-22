<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	
	if(!empty($_POST) && !empty($_POST['email'])){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From:'.$webmasterMail.' <'.$webmasterMail.'>' . "\r\n";
		
		$table = "invitations";
		$users = runQuery("SELECT inviteKey FROM ".getTableQuote($table)." WHERE email='".$_POST['email']."';");
		if(count($users) == 1){
			$inviteKey = $users[0]['inviteKey'];
		}else{
			$inviteKey = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)). dechex(mt_rand(0, 2147483647));
			$table = 'invitations';
			$data = [email => $_POST['email'], inviteKey => $inviteKey];
			insert($table, $data);
		}
		
		
		$link = $externalLink."admin/login/createAccount.php?inviteKey=$inviteKey";
		$message = "
				<html>
					<body>
					<p>Follow this link and create this account:</p>
					<p><a href=".$link.">Click Here</a></p>
				
				</body>
				
				</html>
				";
		
		$subject = "You have been invited to create an account for: The Linger Martini Bar";
		mail($_POST['email'], $subject, $message, $headers);
		
		header("Location: ". $baseURL."admin/users/");
		
		die("Redirecting to users");
		
	}
	
	include_once $serverPath.'resources/templates/adminHead.php';
	
	
?>

<div ng-controller="InviteController">
	<div class="container-fluid">
		<form action="invite.php" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Invite {{email || 'Someone'}}</div>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="email">Email</label>
								<input class="form-control" type="email" name='email' ng-model='email' required="required" placeholder="Email">
							</div>
							<div class="form-group">
								<button class="btn btn-primary" type="submit">Send</button>
								<a class="btn btn-danger" href="index.php">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
app.controller('InviteController', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));

	
	
}]);

</script>



