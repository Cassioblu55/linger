<?php
	$title = "Linger Menu";	
	include_once  '../../config/config.php';
	include_once $serverPath.'resources/templates/head.php';
	
?>

<div ng-controller="MenuViewIndexController">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h4 class="primary-color"><span style="color: white;">*</span> Click to view photo</h4>
				<div ng-repeat="drink_column in drinks track by $index">
					<div class="col-md-6" id="drinkColumn{{$index}}">
						<div ng-repeat = "drink_type in getKeys(drink_column)">
							<h2 class="text-center italic">{{drink_type}}</h2>
							<div ng-repeat="drink in drink_column[drink_type]">
								<div class="row">
									<h4 class="primary-color col-sm-11" ng-click="(drink.image.source) ? showImage(drink.image, drink.name) : ''" ng-class="(drink.image.source) ? 'imageClick' : ''">
										<span style="color: white;" ng-show="drink.image.source">* </span>{{drink.name}}
									</h4>
									<div ng-show="drink.price != 0 && !drink.description" class="col-sm-1 bold">${{drink.price}} </div>
								</div>
								<div ng-show="drink.description" class="row">
									<p class="showDisplay" ng-class="(drink.price != 0) ? 'col-sm-11' : ''">{{drink.description}}</p>
									<div ng-show="drink.price != 0" class="col-sm-1 bold">${{drink.price}}</div>
								</div>


							</div>
						</div>
					</div>
				</div>
			</div>
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

	var minWidth = 999;

	function setStyle(large){
		if(large){
			$('#drinkColumn1').attr('style', "border-left: thin solid white; padding-left: 50px");
	        $('#drinkColumn0').attr("style","padding-right: 50px");
		}else{
			 $('#drinkColumn0').attr('style', '');
		     $('#drinkColumn1').attr('style', '');
		}
	}

	$(window).load(function(){
		setStyle($(window).width() > minWidth);
 	});
	
	
	$(window).bind("resize",function(){
		setStyle($(window).width() > minWidth);
	    });

	// ng-style="($index==1) ?  {'border-left': 'thin solid white', 'padding-left' : '50px'}: {'padding-right' : '50px'}"

	
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

<?php include_once $serverPath.'resources/templates/footer.php'; ?>