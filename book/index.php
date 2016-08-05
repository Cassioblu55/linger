<?php
	$title = "Book a Linger Party";
	include_once '../config/config.php';
	include_once $serverPath . 'resources/templates/head.php';
?>
<div ng-controller="BookAPartyIndexController">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 main_border">
				<h1 class="primary-color">Host your Linger Private Party</h1>
				
				<h3>Fundraisers, Family Get Togethers, Bachelorette, Office & Launch Parties, Baby Showers</h3>
				
				<div class="row">
					<div class="col-md-6" style="height: 300px">
						<h4>Sunday and Monday</h4>
						
						<p class="time primary-color">11am-3pm</p>
						<p class="time primary-color">4pm-8pm</p>
						<p class="time primary-color">9pm-1am</p>
						
						<h4>$200 Rental Fee</h4>
						<p>plus $100 refundable deposit</p>
						
						<p style="font-weight: bold; font-style: italic;">No rental Fee for "non profit organizations!"</p>
					</div>
					<div class="col-md-6" style="max-height: 300px">
						<img alt="book a party" style="max-width: 100%" src="<?php echo $baseURL?>resources/photos/bookParty.jpg">
					</div>
				</div>
				
				<h1 class="primary-color">Free Parties</h1>
				<h4>Tuesday - Saturday</h4>
				<p class="time primary-color">5pm-8pm</p>
				
				<p>$100 bottle purchase for reserved section 9pm-close Thursday-Saturday</p>
				
				<h4 class="primary-color">Contact us at {{phoneNumber}}.</h4>
				
			</div>
		</div>
	</div>
</div>
		
<script type="text/javascript">
	setMainMenuActiveLink("mainMenu_book");

	app.controller('BookAPartyIndexController', ['$scope', '$controller', function($scope, $controller){
		angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));

		$scope.setFromFacebook("https://graph.facebook.com/157036440997632?fields=phone", function(data){
			$scope.phoneNumber = data.phone;
			});

	}]);

</script>		

<?php include_once $serverPath . 'resources/templates/footer.php'; ?>