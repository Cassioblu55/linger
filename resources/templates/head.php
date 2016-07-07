<?php session_start();

$defaultTitle="The Linger"?>
<!doctype html>
<html ng-app="app">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script type="text/javascript">var baseURL = "<?php echo $baseURL;?>";</script>
<link rel="icon" href="<?php echo $baseURL;?>resources/icons/favicon.ico">

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
<div class="main_subtitle italic">
	<span id="sub_title">Where Friends Gather</span>
</div>
</div>
<?php include_once $serverPath.'resources/templates/menu.php';?>

<script src="//connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">

var baseURL = '<?php echo $baseURL;?>';

app.controller("TitleController", ['$scope', "$controller", function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));	

	$scope.largeLine = {'width': getWidthPlus($('#main_title').width(), 0.1)};
	$scope.smallLine = {'width': getWidthPlus($('#main_title').width(), 0.05)};

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
  
  <script>(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src="//x.instagramfollowbutton.com/follow.js";s.parentNode.insertBefore(g,s);}(document,"script"));</script>
  


