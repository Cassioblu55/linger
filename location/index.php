<?php
	$title = "Linger Location";	
	include_once  '../config/config.php';
	include_once $serverPath . 'resources/templates/head.php';
	
?>
<div ng-controller = "LocationIndexController">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-md-6">
					<h2 class="primary-color">Come Visit Us</h2>
					<h3>
						<a class="link primary-color-on-hover underline" href="http://maps.apple.com/?q=4142 167th St Oak Forest, Illinois">4142 167th St Oak Forest, Illinois</a>
					</h3>
					<img style="margin-top: 10px" alt="" src="<?php echo $baseURL;?>resources/photos/location.jpg">
					
				</div>
				<div class="col-md-6">
					<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="100%" height="440" 
						src="https://maps.google.com/maps?hl=en&q=4142 West 167th Street, Oak Forest, Illinois 60452&ie=UTF8&t=roadmap&z=10&iwloc=B&output=embed">
					</iframe>
				
				</div>
			
			
			</div>
		
	</div>
	
	</div>
</div>



</div>


<script>
	setMainMenuActiveLink("mainMenu_location");

	app.controller("LocationIndexController", ['$scope', "$controller" , function($scope, $controller){
		angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));


	}]);

</script>

							
							
<?php include_once $serverPath . 'resources/templates/footer.php'; ?>