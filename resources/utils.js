var app = angular.module('app',['ui.grid']);

function getUrlParam(param){
	var p = location.search.split(param+"=")[1]
    return (p) ? p.split("&")[0] : null;
}

function getID(){
	var id = getUrlParam("id");
	return (id && isNumeric(id)) ? id : null;
}

function getWidthPlus(width, percent){
	return width+(width*percent);
}

String.prototype.escapeSpecialChars = function() {
    return this.replace(new RegExp( "\n", "g" ), "\\n")
    			replace(new RegExp( "'", "g" ), "\\'")
    		   .replace(new RegExp("\'", "g"), "\\'")
    		   .replace(new RegExp("\&", "g"), "\\&")
    		   .replace(new RegExp("\r", "g"), "\\r")
    		   .replace(new RegExp("\t", "g"), "\\t")
    		   .replace(new RegExp("\b", "g"), "\\b")
    		   .replace(new RegExp("\f", "g"), "\\f");
};


String.prototype.parseEscape = function(){
	return JSON.parse(this.escapeSpecialChars());
}

String.prototype.display = function(){
	 return this.replace(new RegExp( "\n", "g" ), "<br />")
}

function clone(h){
	var hash = {};
	if(h){
		var keys= Object.keys(h);
		for(var i=0; i<keys.length; i++){
			var key = keys[i];
			hash[key] = h[key];
		}
	}
	return hash;
	
}

function getFractionString(float){
	var f = new Fraction(Number(float));
	return (f.denominator > 1) ? f.numerator + '/' + f.denominator : f.numerator;
}

function keyFromValue(hash, value){
	for ( key in hash){
		if(hash[key] == value){
			return key;
		}
	}
}

function convertValuesToNumbers(hash, list){
	for(var i=0; i<list.length; i++){
		var value = list[i];
		hash[value] = Number(hash[value]);
	}
	return hash;
}

function convertListHashValuesToNumbers(array, list){
	for(var i=0; i<array.length; i++){
		array[i] = convertValuesToNumbers(array[i], list);
	}
	return array;
}

function isNumeric(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
}

function randomRange(min, max){
	return Math.floor(Math.random() * max) + min;
}

function cutString(string, n){
	return string.substring(0, (string.length-n));
}

String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

//Will run function if one is passed
function run(funt){
	if(funt){funt();}
}

function logObject(object){
	console.log(JSON.stringify(object));
}

function failedHTTPLog(){
	console.log("HTTP call was not sucessfull.");
}

function combine(s1, s2){
	return s1+" "+s2;
}

function getFeet(n){
	return Math.floor(Number(n)/12);
}

function getInches(n){
	return Math.floor(Number(n)%12);
}

function getHeightDisplay(n){
	return getFeet(n)+"' "+getInches(n)+"''";
}

function displaySex(sex){
	if(sex=="M"){return "Male";}
	else if(sex=="F"){return "Female";}
	return "Other";
}

function randomKeyFromHash(hash){
	return randomFromArray(Object.keys(hash));
}

//Will take an array and return a value at a random interval
function randomFromArray(array){
	return array[Math.floor((Math.random() * array.length))];
}

function isEdit(){
	return getID() != null;
}

function getTrapSting(traps){
	var trapStrings = [];
	for(var i=0; i< traps.length; i++){
		var trapString = []; var trap = traps[i];
		trapString.push(trap.id);
		trapString.push(trap.column);
		trapString.push(trap.row);
		trapStrings.push(trapString);
	}
	return JSON.stringify(trapStrings);
}

app.controller("UtilsController", ['$scope', "$http", "$window", function($scope, $http, $window){	
	
	$scope.deleteById = function(id, name, runOnSuccess, runOnFailed){
		runOnFailed = runOnFailed || failedHTTPLog;
		if(window.confirm("Are you sure you want to delete "+name+"?")){
			$http.post('delete.php?id='+id)
			.then(function(response){
				run(runOnSuccess);
			}, function errorCallback(response){
				run(runOnFailed);
			});
		}
	}
	
	$scope.deleteWithRedirect = function(id, name){
		$scope.deleteById(id, name, $scope.redirectToIndex);
	}
	
	$scope.redirectToIndex = function(){
		$window.location.href ="index.php";
	}
	
	$scope.getModifer = function(stat){
		if(!stat){return "";}
		var modifer = (stat) ? Math.floor((stat-10)/2): 0;
		return (modifer >0) ? "+"+modifer : modifer;
	}
	
	$scope.setFromGet = function(get, setFunct, runOnFailed){
		runOnFailed = runOnFailed || failedHTTPLog;
		$http.get(get).then(function(response){
			setFunct(response.data);
		}, function errorCallback(response){
			run(runOnFailed);
		});
	}
	
	$scope.capitalizeFirstLetter = function(s){
		return s.capitalizeFirstLetter();
	}
	
	$scope.setById = function(setFunct){
		var id = getID();
		if(id){
			var get = 'data.php?id='+id;
			$scope.setFromGet(get, setFunct);
		}
	}
	
	$scope.arrayToString = function(array){
		var string = "";
		if(array){
			for(var i=0; i<array.length; i++){
				string += array[i]+", ";
			}
			return cutString(string, 2);
		}
		return string;
	}
	
	$scope.hashArrayValueToString = function(hashList, value){
		var string = "";
		if(hashList && value){
			for(var i=0; i<hashList.length; i++){
				var hash = hashList[i];
				string += hash[value]+", ";
			}
			return cutString(string, 2);
		}
		return string;
	}
	
	$scope.columnSizeByHash = function(hash, size, max){
		var length = Object.keys(hash).length;
		var c = "col-"+size+"-";
		return (length <= 12 && length >0 && length <=max) ? 'col-'+size+'-'+(Math.floor(12/length)) : '';
	}
	
	$scope.columnSizeByArray = function(array, size, max){
		var length = array.length;
		var c = "col-"+size+"-";
		return (length <= 12 && length >0 && length <=max) ? 'col-'+size+'-'+(Math.floor(12/length)) : '';
	}
	
}]);