<?php
$defaultTitle="The Linger";
$defaultDescription = "The Linger Martini Bar";

?>
<!doctype html>
<html ng-app="app">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script type="text/javascript">var baseURL = "<?php echo $baseURL;?>";</script>

<?php include_once $serverPath.'resources/templates/header.php';?>
<link rel="stylesheet" href="<?php echo $baseURL;?>resources/layout.css"/>
<script>
var baseURL = "<?php echo $baseURL;?>";
</script>
<div ng-controller="TitleController">
	<div class="main_title">
		<hr class="title_line" ng-style="largeLine">
		<hr class="title_line small top" ng-style="smallLine">
			<span id="main_title">The Linger Martini Bar</span>
		<hr class="title_line small bottom" ng-style="smallLine">
		<hr class="title_line" ng-style="largeLine">
	</div>
	<div class="main_subtitle italic">
		<span id="sub_title">Where Friends Gather</span>
	</div>
</div>
<?php include_once $serverPath.'resources/templates/menu.php';?>

<script src="//connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">

var baseURL = '<?php echo $baseURL;?>';

app.controller("TitleController", ['$scope', "$controller", function($scope, $controller){
	angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));

	$scope.largeLine = {'width': getWidthPlusPercent($('#main_title').width(), 0.1)};
	$scope.smallLine = {'width': getWidthPlusPercent($('#main_title').width(), 0.05)};

}]);

window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $appId;?>',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


  

</script>

<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=104201949958641";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  


