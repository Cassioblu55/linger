var daysToNumbersHash ={'Sunday': 0,'Monday' : 1, 'Tuesday': 2, 'Wednesday': 3, 'Thursday' : 4,'Friday': 5,'Saturday':6}
var daysApprevHash ={'Sunday': 'sun','Monday' : 'mon', 'Tuesday': 'tue', 'Wednesday': 'wed', 'Thursday' : 'thu','Friday': 'fri','Saturday':'sat'}


var app = angular.module('app',['ui.grid']);

function addTime(hash, day, openClosed, time){
	var timeDisplay = getDisplayMilitaryTime(time);
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

function getMinutesPastMidnight(timeString){
	var amOrPm = (timeString.split("am").length == 2) ? "am": "pm";
	var t = timeString.split(amOrPm)[0];
	var time = {hour:  Number(t.split(":")[0]), minute: Number(t.split(":")[1]) };
	return (((amOrPm =="am") ? time.hour : time.hour+12)*60)+time.minute;

}

//Assumes that am is am next day
function getMinutesPastSundayMidnight(timeString, dayAsString){
	var dayAsNumber = daysToNumbersHash[dayAsString];
	var amOrPm = (timeString.split("am").length == 2) ? "am": "pm";
	dayAsNumber = (amOrPm =="am") ? (dayAsNumber==6) ? 0 : dayAsNumber+1 : dayAsNumber ;
	return getMinutesPastMidnight(timeString) + (1440 * (dayAsNumber));
}

app.controller("LingerUtilsController", ['$scope', "$http", "$window", "$controller", function($scope, $http, $window, $controller){
	angular.extend(this, $controller('StandardUtilitiesController', {$scope: $scope}));

	$scope.setFromFacebook = function(get, setFunct, runOnFailed){
		var hash =  {client_id : "104201949958641", client_secret : "92ce6504f5ed39bd37a9ce788c2e60e6",grant_type : "client_credentials" };
		var tokenUrl = createRequestUrlWithParams("https://graph.facebook.com/oauth/access_token", hash);
		$http.get(tokenUrl).then(function(reponse){
			var token =  reponse.data;
			$scope.setFromGet(get+"&"+token, setFunct, runOnFailed);
		});
		
	}

	$scope.parseHours = function(hours){
		var timesOpen = {'Sunday' : [], 'Monday': [], 'Tuesday' : [], 'Wednesday' : [], 'Thursday': [], 'Friday' : [], 'Saturday' : []};
		angular.forEach(Object.keys(daysApprevHash), function(dayKey){
			angular.forEach(Object.keys(hours), function(hourKey){
				var gotTime = hourKey.split(daysApprevHash[dayKey]);
				if(gotTime.length == 2){
					var openClose = (hourKey.split('open').length==2) ? 'open' : 'close';
					addTime(timesOpen, dayKey, openClose, hours[hourKey]);
				}
			});
		});
		return timesOpen;
	}
	
	$scope.parseOpen = function(hours){
		var hoursAfterSundayMidnight = [];
		var open = false;
		var hours = $scope.parseHours(hours);
		//hours.Sunday.push({open: "5:00pm", close:"2:00am"})
		angular.forEach(Object.keys(hours), function(dayKey){
			angular.forEach(hours[dayKey], function(time){
				var hash = {};
				hash.open = getMinutesPastSundayMidnight(time.open, dayKey);
				hash.close = getMinutesPastSundayMidnight(time.close, dayKey);
				hoursAfterSundayMidnight.push(hash);
			});
		});
		var today = new Date();
		var now = (today.getDay()*1440) + (today.getHours()*60) + today.getMinutes();
		angular.forEach(hoursAfterSundayMidnight, function(row){
			if(row.open >= row.close){
				//Saturday to Sunday
				if(now <= row.close || now >= row.open){open= true;}
			}else{
				if(now >= row.open && now <= row.close){open= true;}
			}
			
		});
		return open;
	}
	
}]);