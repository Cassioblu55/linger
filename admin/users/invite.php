<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/adminHead.php';
	
	if(!empty($_POST) && !empty($_POST['email'])){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From:'.$webmasterMail.' <'.$webmasterMail.'>' . "\r\n";
		
		
		
		$link = $externalLink."admin/login/createAccount.php?email=".$_POST['email']."&secret=$secret";
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
	}
	
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



