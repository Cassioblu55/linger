<?php
	$title = "Linger Events";
	include_once '../config/config.php';
	include_once $serverPath . 'resources/templates/head.php';
?>

<div ng-controller="EventIndexController">
	<div class="container-fluid">
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2 main_border">
			<h1>Events</h1>
			<h3>From {{start_date}} to {{end_date}}</h3>
			<!-- repate events -->
			<hr>
			<div ng-repeat="event in events">
				<h3 class="primary-color">{{event.name}}</h3>
				<div ng-show="event.type=='singleDay'">
					<div>{{getDateDisplay(event.startDate)}} from {{getTimeDisplay(event.dates[0].startTime)}} to {{getTimeDisplay(event.dates[0].endTime)}}</div>
				</div>
				<!-- days -->
				<div ng-show="event.type=='recurring'">
					<div ng-repeat="day in event.dates">
						<p>{{day.dayOfWeek}}s from {{getTimeDisplay(day.startTime)}} to {{getTimeDisplay(day.endTime)}}
					</div>
				</div>
				<!-- days ends-->
<!-- 			<img ng-show="event.image" ng-src="data:image/png;base64,'.base64_encode({{event.image}}).'"> -->
				<div class="row">
					<div class="col-md-12">
						<img align=left ng-show="event.image.source" ng-src="{{event.image.source}}" height="200px" style="max-width: 100%">
						<div ng-style="(event.image.source) ? {'padding': '5px'} : ''" class="showDisplay">{{event.description}}</div>
					
					</div>
				
				</div>
				<hr>
			</div>
		</div>
	
	</div>
	</div>
</div>
<?php include $serverPath . 'resources/templates/footer.php';?>
<script src="<?php echo $baseURL;?>resources/eventSort.js"></script>

<script>
	setMainMenuActiveLink("mainMenu_events");

	app.controller('EventIndexController', ['$scope', '$controller', function($scope, $controller){
		angular.extend(this, $controller('GetEventsController', {$scope: $scope}));	
				
		$scope.start_date = moment().format('MM/DD/YY');
		$scope.end_date = moment().add(7, 'days').format('MM/DD/YY');

		$scope.getEvents($scope.start_date, $scope.end_date, function(data){
			$scope.events = data;
		});
		
	}]);

</script>

<?php include_once $serverPath . 'resources/templates/footer.php'; ?>