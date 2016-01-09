<?php
	$title = "Linger Menu";	
	include_once  '../../config/config.php';
	include_once $serverPath.'resources/templates/head.php';
	
?>

<div ng-controller="MenuViewIndexController">
	<div class="container-fluid">
		<!-- drink column -->
		<div ng-repeat="drink_column in drinks">
			<div class="col-md-6">
				<div ng-repeat = "drink_type in getKeys(drink_column)">
					<h2 class="text-center italic">{{drink_type}}</h2>
					<div ng-repeat="drink in drink_column[drink_type]">
						<div class="row">
							<h4 class="primary-color" ng-click="(drink.image.source) ? showImage(drink.image, drink.name) : ''" ng-class="(drink.image.source) ? 'imageClick' : ''">{{drink.name}}</h4>
						</div>
						<div class="row">
							<p ng-class="(drink.price != 0) ? 'col-sm-11' : ''">{{drink.description}}</p>
							<div ng-show="drink.price != 0" class="col-sm-1 bold">${{drink.price}}</div>
						</div>
					</div>
				</div>
			</div>
		<!-- end drink column -->
		</div>
	</div>
	
	<div id="imageModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    <div class="modal-content">
		    	<div class="modal-header">
		        	<button type="button" style="color: white;" class="close" data-dismiss="modal">&times;</button>
		    		<h3 class=" modal-title primary-color text-center">{{activeImage.drinkName}}</h3>
		        </div>
		      	<div class="modal-body">
		      		<div class="row">
		      			<div class="col-md-1"></div>
		      			<div class="col-md-10">
				      		<img width="100%" ng-src="{{activeImage.source}}">
		      			</div>
		      			<div class="col-md-1"></div>
		      		</div>
		     	</div>
			</div>
		</div>
	
	</div>
	
	
</div>

<script>
app.controller("MenuViewIndexController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));


	$scope.showImage = function(image, drinkName){
		$scope.activeImage = image;
		$scope.activeImage.drinkName = drinkName;
		$('#imageModal').modal('show');
	}
	
	//Pull drinks from database
	$scope.setFromGet('data.php?get=menu', function(data){
		//console.log(data);
		var drinks = {};
		//Divide them by type
		for(var i=0; i<data.length; i++){
			var drink = data[i];
			if(!drinks[drink.type] ){
				drinks[drink.type] = [];
			}
			if(drink.image){
				drink.image = drink.image.parseEscape();
				}
			drinks[drink.type].push(drink);
		}
		//Split the drinks in half make the number of drinks on each side as even as possible
		$scope.drinks = [{},{}];
		var columnOneTotal = 0, columnTwoTotal = 0;
		var types = $scope.getKeys(drinks);
		for(var i=0; i<types.length; i++){
			var type = types[i];
			if(drinks[type].length >0){
				if(columnOneTotal < columnTwoTotal){
					$scope.drinks[0][type] = drinks[type];
					columnOneTotal += drinks[type].length;
					}
				else{
					$scope.drinks[1][type] = drinks[type];
					columnTwoTotal += drinks[type].length;
					}
			}
		}		
	});

}]);
</script>