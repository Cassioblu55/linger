<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/head.php';
?>

<div ng-controller="EventIndexController">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 main_border">
			<h1>Events</h1>
			<h3>From {{start_date}} to {{end_date}}</h3>
			<!-- repate events -->
			<hr>
			<div ng-repeat="event in events">
				<h3 style="color: #d9ca76">{{event.name}}</h3>
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
				<div class="showDisplay">{{event.description}}</div>
				<hr>
			</div>
		</div>
		<div class="col-md-2"></div>
	
	</div>

</div>
<?php include $serverPath.'resources/templates/footer.php';?>

<script>
	app.controller('EventIndexController', ['$scope', '$controller', function($scope, $controller){
		angular.extend(this, $controller('UtilsController', {$scope: $scope}));	


		var daysToNumbersHash ={'Sunday': 0,'Monday' : 1, 'Tuesday': 2, 'Wednesday': 3, 'Thursday' : 4,'Friday': 5,'Saturday':6}
		
		$scope.start_date = moment().format('MM/DD/YY');
		$scope.end_date = moment().add(7, 'days').format('MM/DD/YY');

		function setEvents(events){
			$scope.events = events;
			for(var i=0; i<$scope.events.length; i++){
				$scope.events[i].dates = JSON.parse($scope.events[i].dates);
				$scope.events[i].startDate = Number($scope.events[i].startDate);
				$scope.events[i].endDate = Number($scope.events[i].endDate);
				}
			$scope.events.sort(sortEvents);
			}

		function getDateQuery(){
			var startDate = Date.parse($scope.start_date);
			var endDate = Date.parse($scope.end_date);
			var query ='data.php?startDate='+startDate+'&endDate='+endDate;
			console.log(query);
			return query;
		}

		function sortEvents(a,b){
			var aNumber = getDayNumber(a); 
			var bNumber = getDayNumber(b);
			if (aNumber < bNumber){
			    return -1;
			    }
			  if (aNumber > bNumber){
			    return 1;
			  }
			  return 0;

		}

		function getDayNumber(event){
			var number;
			if(event.type =='recurring'){
				var days = [];
				for(var i=0; i<event.dates.length; i++){
					days.push(daysToNumbersHash[event.dates[i].dayOfWeek]);
				}
				number= Math.min.apply(null, days);
			}else if(event.type =='singleDay'){
				number = new Date(event.startDate).getDay();
			}
			number = number - new Date().getDay();
			if(number <0){number +=7;}
			return number;
		}
		
		$scope.setFromGet(getDateQuery(), setEvents);

		
		
	}]);

</script>