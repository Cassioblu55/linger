<div ng-controller="FooterController">
	<div class="container-fluid">
		<hr style="margin-top: 15px" class="title_line">
		<div class="col-md-10 col-md-offset-2" style="margin-bottom: 30px">
			<div class="row">
				<div class="col-md-4">
					<h4 class="italic">Hours</h4>
					<div ng-repeat = "hourKey in getKeys(timesOpen)" ng-class="(boldDay(hourKey)) ? 'bold italic' : ''">
						<span class="primary-color">{{hourKey}}</span>: <span style="color: red;" ng-show="timesOpen[hourKey].length==0">Closed</span> <span ng-repeat="openTime in timesOpen[hourKey]">{{openTime.open}}-{{openTime.close}} </span>
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

	var daysApprevHash ={'Sunday': 'sun','Monday' : 'mon', 'Tuesday': 'tue', 'Wednesday': 'wed', 'Thursday' : 'thu','Friday': 'fri','Saturday':'sat'}

	$scope.timesOpen = {'Sunday' : [], 'Monday': [], 'Tuesday' : [], 'Wednesday' : [], 'Thursday': [], 'Friday' : [], 'Saturday' : []};
	
	$scope.setFromFacebook("https://graph.facebook.com/157036440997632?fields=hours", function(data){
		//console.log(data.hours);
		var hours = data.hours;
		var daysKeys = Object.keys(daysApprevHash)
		var hourKeys = Object.keys(hours);
		for(var y=0; y<daysKeys.length; y++){
			var key = daysKeys[y];
			for(var x=0; x<hourKeys.length; x++){
				var hourKey = hourKeys[x];
				var gotTime = hourKey.split(daysApprevHash[key]);
				if(gotTime.length == 2){
					var openClose = (hourKey.split('open').length==2) ? 'open' : 'close';
					addTime($scope.timesOpen, key, openClose, hours[hourKey]);
				}
			}
		}
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
	

	function addTime(hash, day, openClosed, time){
		var timeDisplay = getDisplayFromMilitaryString(time);
		var currentDay = hash[day];
		var placed = false
		angular.forEach(currentDay, function (row) {
			if(!row[openClosed]){
				row[openClosed] = timeDisplay;
				placed = true;
			}
		});
		if(!placed){currentDay.push({}); currentDay[currentDay.length-1][openClosed] = timeDisplay;}
	}

	
	
}]);
</script>

</html>