<?php

include_once '../../config/config.php';
include_once $serverPath."admin/login/requireAdmin.php";
include_once $serverPath.'utils/db_post.php';
include_once $serverPath . "utils/emailUtilities.php";
include_once $serverPath."utils/postUtilities.php";

$listOfRequiredPostParameters = ["email"];
runOnPostWithAllRequiredParametersWithErrorReroute('sendInviteEmail', $listOfRequiredPostParameters);

function sendInviteEmail(){
	$emailAddressToSendInviteTo = $_POST['email'];
	$emailSentSuccessfully = attemptSendInviteEmail($emailAddressToSendInviteTo);

	redirectToIndexShowErrorOnFailed($emailSentSuccessfully);
}

function attemptSendInviteEmail($emailAddressToSendInviteTo){
	$subject = "You have been invited to create an account for: The Linger Martini Bar";

	$headers = getEmailHeader($_SESSION['user']['email'], "html");
	$emailContent = getInviteEmailContent($emailAddressToSendInviteTo);

	$emailSentSuccessfully = mail($emailAddressToSendInviteTo, $subject, $emailContent,$headers);
	return $emailSentSuccessfully;
}

function getInviteEmailContent($email){
	$link = getInviteLink($email);
	$message = "
			<html>
				<body>
				<p>Follow this link and create your account:</p>
				<p><a href=".$link.">Click Here</a></p>
			
			</body>
			
			</html>
			";
	return $message;
}

function getInviteLink($email){
	global $externalLink;
	$inviteKey = getInviteKey($email);
	return $externalLink."admin/login/createAccount.php?inviteKey=$inviteKey";
}

function getInviteKey($email){
	$table = "invitations";
	$sentInviteKey = runQuery("SELECT inviteKey FROM ".getTableQuote($table)." WHERE email='$email';");
	if(count($sentInviteKey) == 1){
		$inviteKey = $sentInviteKey[0]['inviteKey'];
	}else {
		$inviteKey = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

	}
	return $inviteKey;
}

function redirectToIndexShowErrorOnFailed($emailSentSuccessfully){
	global $baseURL;

	$errorMessage = "Email could not be sent";
	$successMessage = "Invite sent successfully";
	$url = $baseURL."admin/users/index.php";

	$url = ($emailSentSuccessfully) ? addSuccessMessageToUrl($url, $successMessage) : addErrorMessageToUrl($url, $errorMessage);

	header("Location: $url");
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
	angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));

}]);

</script>



