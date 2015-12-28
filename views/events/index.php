<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/head.php';
?>

<div ng-controller="EventIndexController">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 main_border">
			<h1>Events</h1>
			<h3>For {{start_date}} to {{end_date}}</h3>
		</div>
		<div class="col-md-2"></div>
	
	</div>

</div>
<?php include $serverPath.'resources/templates/footer.php';?>

<script>
	app.controller('EventIndexController', ['$scope', '$controller', function($scope, $controller){
		angular.extend(this, $controller('UtilsController', {$scope: $scope}));	

		$scope.start_date = moment().format('MM/DD/YY');
		$scope.end_date = moment().add(7, 'days').format('MM/DD/YY');

		function setEvents(events){$scope.events = events;}

		function getDateQuery(){
			var startDate = Date.parse($scope.start_date);
			var endDate = Date.parse($scope.end_date);
			return 'data.php?start_date='+startDate+'&end_date='+endDate;
		}
		
		$scope.setFromGet(getDateQuery(), setEvents);

		
		
	}]);

</script>