<?php $defaultTitle="The Linger"?>
<!doctype html>
<html ng-app="app">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script type="text/javascript">var baseURL = "<?php echo $baseURL;?>";</script>
<?php include_once $serverPath.'resources/templates/header.php';?>
<link rel="stylesheet" href="<?php echo $baseURL;?>resources/layout.css"/>	
<title><?php if(isset($title)){echo $title;}else{echo $defaultTitle;}?></title>
<script> 	
var baseURL = "<?php echo $baseURL;?>";
</script>
<div ng-controller="TitleController">
<div class="main_title">
<hr class="title_line" ng-style="largeLine"></hr>
<hr class="title_line small top" ng-style="smallLine"></hr>
	<span id="main_title">The Linger Martini Bar</span>
<hr class="title_line small bottom" ng-style="smallLine"></hr>
<hr class="title_line" ng-style="largeLine"></hr>
</div>
<div class="main_subtitle">
	<span id="sub_title">Where Friends Gather</span>
</div>
</div>
<?php include_once $serverPath.'resources/templates/menu.php';?>

<script type="text/javascript">
app.controller("TitleController", ['$scope', "$controller", function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));	

	$scope.largeLine = {'width': getWidthPlus($('#main_title').width(), 0.1)};
	$scope.smallLine = {'width': getWidthPlus($('#main_title').width(), 0.05)};

}]);

</script>


