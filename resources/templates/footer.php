<div ng-controller="FooterController">
	<div class="container-fluid">
		<hr style="margin-top: 15px" class="title_line">
		<div class="col-md-10 col-md-offset-2" style="margin-bottom: 30px">
			<div class="row">
				<div class="col-md-4">
					<h4 class="italic">Hours</h4>
					<span>We are now: <span ng-class="(!open) ? 'color-danger' : 'primary-color'">{{(open) ? 'Open' : 'Closed'}}</span></span>
					<div ng-repeat = "hourKey in getKeys(timesOpen)" ng-class="(boldDay(hourKey)) ? 'bold italic' : ''">
						<span class="primary-color">{{hourKey}}</span>: <span ng-show="timesOpen[hourKey].length==0">Closed</span> <span ng-repeat="openTime in timesOpen[hourKey]">{{openTime.open}}-{{openTime.close}} </span>
					</div>
				</div>
				<div class="col-md-4">
					<h4 class="italic">Contact Us</h4>
					<ul style="padding: 0px;">
						<li class="link"><a class="link primary-color-on-hover" href="http://maps.apple.com/?q=4142 167th St Oak Forest, Illinois">Visit: <span class="underline">4142 167th St Oak Forest, Illinois</span></a>
						<li class="link"><a class="link primary-color-on-hover" ng-href="tel: {{getPhoneCall(phoneNumber)}}">Call: <span class="underline">{{phoneNumber}}</span></a></li>
						<li class="link"><a class="link primary-color-on-hover" href="mailto:<?php echo $contactMail;?>">Email Us: <span class="underline"><?php echo $contactMail;?></span></a>
					</ul>
					
				</div>
				<div class="col-md-4">
					<h4 class="italic">Links</h4>
					<ul style="padding: 0px;">
						<li class="link"><a class="link primary-color-on-hover underline" href="https://www.facebook.com/thelingermartinibar/timeline">Facebook</a></li>
						<li class="link"><a class="link primary-color-on-hover underline" href="https://www.instagram.com/linger_martini_bar/">Instagram</a></li>
						<li class="link"><a class="link primary-color-on-hover underline" href="<?php echo $baseURL;?>admin/">Admin</a></li>
					</ul>
				</div>
				
			</div>
		</div>
	
	</div>


</div>



<script>
app.controller("FooterController", ['$scope', "$controller", function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));	

	$scope.setFromFacebook("https://graph.facebook.com/157036440997632?fields=hours", function(data){
		$scope.timesOpen= $scope.parseHours(data.hours);
	});

	$scope.setFromFacebook("https://graph.facebook.com/157036440997632?fields=hours", function(data){
		$scope.open = $scope.parseOpen(data.hours);	
	});
	
	$scope.boldDay = function(day){
		//console.log(new Date().getDay()  == daysToNumbersHash[day]);
		return new Date().getDay()  == daysToNumbersHash[day];
	}

	$scope.getPhoneCall = function(n){
		var number= n+"";
		number = number.replace("(", "").replace(")", "").replace(" ", "-");
		return "+1-"+number;
		
	}
	
	$scope.setFromFacebook("https://graph.facebook.com/157036440997632?fields=phone", function(data){
		$scope.phoneNumber = data.phone;
		});
	
}]);
</script>

</html>