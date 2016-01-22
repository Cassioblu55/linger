
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
	var number; var todayNumber = new Date().getDay();
	if(event.type =='recurring'){
		//This will loop through the days a recurring event happens and will use the closest day in the future
		for(var i=0; i<event.dates.length; i++){
			var n = daysToNumbersHash[event.dates[i].dayOfWeek];
			if(!number){number = n;}
			else if(n-todayNumber >= 0 && n-todayNumber < number){
				number = n;
			}
		}
	}else if(event.type =='singleDay'){
		number = new Date(event.startDate).getDay();
	}
	number = number - todayNumber;
	if(number <0){number +=7;}
	return number;
}

function getDateQuery(startDate, endDate){
	var startDate = Date.parse(startDate);
	var endDate = Date.parse(endDate);
	var query = baseURL+'/views/events/data.php?startDate='+startDate+'&endDate='+endDate;
	return query;
}

app.controller('GetEventsController', ['$scope', '$controller', function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));	
	
	$scope.getEvents = function(startDate, endDate, setFunct){
		$scope.setFromGet(getDateQuery(startDate, endDate), function(e){
			var events = e;
			angular.forEach(events, function(event) {
				event.image = (event.image) ? event.image.parseEscape() : {};
				event.dates = JSON.parse(event.dates);
				event.startDate = Number(event.startDate);
				event.endDate = Number(event.endDate);
			});
			setFunct(events.sort(sortEvents));
		});
	}
	
	
}]);
	

