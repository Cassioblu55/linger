<?php
if(empty($_GET['id'])){
	header("Location: ". $baseURL."views/events/");
}

include_once '../../config/config.php';
include_once  $serverPath.'resources/templates/head.php';
?>

<div ng-controller="EventShowController">

<h1 class="text-center">{{event.name}}</h1>

<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<!-- days -->
		<!-- single day -->
		<div ng-show="event.type=='singleDay'">
			<div class="row">
				<div class="col-md-4">
					<p>Day</p>
					<div>{{getDateDisplay(date.startDate)}}</div>
				</div>
				<div class="col-md-4">
					<p>Start Time</p>
					<div>{{date.day[0].startTime}}</div>
				</div>
				<div class="col-md-4">
					<p>End Time</p>
					<div>{{date.day[0].endTime}}</div>
				</div>
			</div>
		</div>
		<!-- single day ends -->
		<!-- recurring -->
		<div ng-show="event.type=='recurring'">
			<!-- start/end dates -->
			<div class="row">
				<div>{{getStartString()}}</div>
			</div>
			<!-- start/end dates ends-->
			
			<!-- days -->
			<div class="row">
				<div ng-repeat="day in date.days">
					<p>{{day.dayOfWeek}}s from {{getTimeDisplay(day.startTime)}} to {{getTimeDisplay(day.endTime)}}
				</div>
			</div>
			<!-- days ends-->
			
		</div>
		<!-- recurring ends -->
		
		<!-- days ends -->
		<!-- description -->
		<div class="row">
			<div class="showDisplay">{{event.description}}</div>
		</div>
		<!-- description ends -->

	</div>
	<div class="col-md-2"></div>
</div>


</div>

<script>
app.controller('EventShowController', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));

	function setEvent(event){
		$scope.event = event;
		$scope.date = JSON.parse(event.dates);
	}

	$scope.getStartString = function(){
		if($scope.date){
			if($scope.date.startDate && !$scope.date.endDate){
				return "Event begins "+$scope.getDateDisplay($scope.date.startDate);
				}
	
			else if($scope.date.endDate && !$scope.date.startDate){
				return "Event ends "+$scope.getDateDisplay($scope.date.endDate);
				}
	
			else if($scope.date.endDate && $scope.date.startDate){
				var starts = $scope.getDateDisplay($scope.date.startDate);
				var ends = $scope.getDateDisplay($scope.date.endDate);
				return "Event begins "+starts+" and ends "+ends;
			}
		}
		return '';
	}
	
	$scope.setById(setEvent);

}]);

</script>


