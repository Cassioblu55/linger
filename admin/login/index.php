<?php session_start();
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_get.php';
	include_once $serverPath."utils/redirectUtilities.php";
	include_once $serverPath."utils/postUtilities.php";
	include_once $serverPath."utils/generalUtilities.php";

	$listOfRequiredPostParameters = ['password', 'username'];
	runOnPostWithAllRequiredParametersWithErrorReroute('attemptLogin', $listOfRequiredPostParameters);

	function attemptLogin(){
		$user = getUserByUsernameOrEmail($_POST['username']);
		$login_ok = ($user != null && isValidLogin($user, $_POST['password']));
		if ($login_ok) {
			setUserSession($user);
		}
		routeOnSuccessfulLoginOrReturnError($login_ok);
	}

	function getUserByUsernameOrEmail($usernameOrEmail){
		$possibleUser = findUserByUsernameOrEmail($usernameOrEmail);

		$listOfRequiredParameters = ['salt', 'password', 'username'];
		$user = (hasAllRequiredParameters($possibleUser, $listOfRequiredParameters)) ? $possibleUser : null;
		return $user;
	}

	function findUserByUsernameOrEmail($usernameOrEmail){
		$table = getTableQuote("users");
		$query = "SELECT * FROM $table WHERE (username='$usernameOrEmail' OR email='$usernameOrEmail') AND active=1;";
		$queryReturn = runQuery($query);

		$possibleUser = (count($queryReturn) == 1) ? $queryReturn[0] : null;
		return $possibleUser;
	}

	function isValidLogin($user, $passwordGivenByUser){
		$hashedPassword = getHashedPassword($passwordGivenByUser, $user["salt"]);
		return $user['password'] == $hashedPassword;
	}

	function getHashedPassword($passwordGivenByUser, $salt){
		$check_password = hash ( 'sha256', $passwordGivenByUser . $salt );
		for($round = 0; $round < 65536; $round ++) {
			$check_password = hash ( 'sha256', $check_password . $salt );
		}
		return $check_password;
	}

	function setUserSession($userSuccessfullyAuthenticated){
		unset ( $userSuccessfullyAuthenticated['salt'] );
		unset ( $userSuccessfullyAuthenticated ['password'] );
		$_SESSION['user'] = $userSuccessfullyAuthenticated;
	}

	function routeOnSuccessfulLoginOrReturnError($login_ok){
		global $baseURL;

		if($login_ok){
			header ( "Location: ".$baseURL."admin/");
			die ( "Redirecting to: admin home page" );
		}else{
			$errorMessage = "Username not found or password is incorrect";
			$url = $baseURL."admin/login";
			$redirectUrl = addErrorMessageToUrl($url, $errorMessage);

			header ( "Location: $redirectUrl");
			die ( "Redirecting to: admin login page" );
		}
	}
	
	include_once $serverPath.'resources/templates/header.php';
	
?>
<link rel="stylesheet" href="<?php echo $baseURL;?>resources/adminLayout.css"/>	
<div class="container-fluid">
	<form action="index.php" method="post">
		<div class="row">
			<div class="col-md-6 col-md-offset-3" style="margin-top: 20px">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Login</div>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="username">Username Or Email</label>
							<input class="form-control" id='username' pattern="[a-zA-Z0-9_@.]+" title="Must be a vaild username" type="text" name='username' ng-model='username' required="required" placeholder="Username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input class="form-control" id='password' type="password" name='password' ng-model='password' required="required" placeholder="Password">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Login</button>
							<a class="btn btn-danger" href="<?php echo $baseURL;?>">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

