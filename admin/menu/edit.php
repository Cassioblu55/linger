<?php
	include_once '../../config/config.php';
	include_once $serverPath.'utils/db_post.php';
	
	$table = "drinks";
	
	if (! empty ( $_POST )) {
		$data = createDataFromPost($table);
		if (empty ( $_GET ['id'] )) {
			$id  = insertAndReturnId($table, $data);
		}
	
		else {
			update($table, $data);
			$id = $_GET['id'];
		}
		header ( "Location: index.php");
		die ( "Redirecting to index.php" );
	
	}
	
	include_once $serverPath.'resources/templates/adminHead.php';
?>

<div ng-controller="AddEditDrink">
	<div class="container-fluid">
		<form action="edit.php<?php if(!empty($_GET['id'])){ echo "?id=".$_GET['id'];}?>" enctype="multipart/form-data" method="post">
			<div class="row">
				<div class="col-md-6">
				<!-- panel -->
				<div class="panel panel-default">
					<!-- Header -->
							<div class="panel-heading">
								<h3 class="panel-title">{{addOrEdit}} {{drink.name || 'Drink'}}</h3>
							</div>
					<!-- Header ends-->
					<!-- body -->
					<div class="panel-body">
						<!-- name -->
						<div class="form-group">
							<label for='name'>Name</label>
							<input type="text" name="name" class="form-control" ng-model="drink.name" placeholder="Name">
						</div>
						<!-- name ends -->

						<!-- type -->
						<div class="row form-group" ng-hide="useNewType">
							<div class="col-md-6">
								<label for="type">Type</label>
								<select class="form-control" ng-disabled="useNewType" required="required" ng-model= "drink.type" id="type">
									<option value=''>Select One</option>
									<option ng-repeat="type in drink_types" ng-selected="drink.type==type">{{type}}</option>
								</select>
							</div>
						</div>
						<!-- type ends -->

						<!-- new type -->
						<div class="row form-group">
							<div class="col-md-6" ng-show="useNewType">
								<label>New Type</label>
								<input ng-disabled="!useNewType" ng-model="drink.type" class="form-control">
							</div>

						</div>

						<!-- use new type -->
						<label class="checkbox-inline ">
							<input type="checkbox" ng-model="useNewType"><span class="bold">Use New Type</span>
						</label>

						<!-- end use new type -->


						<input class="hidden" name="type" ng-model="drink.type">
						<!-- new type ends

						
					<!-- Description -->
					<div class="form-group">
						<label for="description">Description</label>
						<textarea rows="5" id="description" name="description" placeholder="Description" class="form-control">{{drink.description}}</textarea>
					</div>
					<!-- description ends -->
					
					<!-- price -->
					<div class="form-group">
						<label for="price">Price</label>
						<div class="input-group">
	  						<span class="input-group-addon">$</span>
							<input type="number" id="price" class="form-control" placeholder="Price" ng-model="drink.price" name="price">
						</div>
					</div>
					
					<!-- image -->
					<div class="form-group">
						<button class="btn btn-primary" type="button" ng-click="editImage(menuImage, setMenuImage)">{{!menuImage.source ? 'Get Image' : 'Change Image' }}</button>
						<button ng-show="menuImage.source" class="btn btn-danger" type="button" ng-click="menuImage={}">Clear Image</button>
					</div>
					<div class="form-group">
						<img ng-show="menuImage.source" class="selectableImage" ng-click="editImage(menuImage, setMenuImage)" style="max-width: 100%" ng-src="{{menuImage.source}}" height="200px"/>
					</div>
					<!-- image ends -->
					
					<!-- price ends -->
					<!--  panel body ends -->
					</div>
					</div>
					<!-- panel-footer -->
					<div class="panel-footer">
						<button class="btn btn-primary" type="submit">{{saveOrUpdate}}</button>
						<a href="index.php" class="btn btn-danger">Cancel</a>
					</div>
					<!-- panel-footer ends -->
					
					<!-- panel ends -->
				</div>
			</div>
				
			<input type="text" ng-model="imageText" class="hidden" name="image" >		
			
		</form>
	
		<?php include_once $serverPath.'resources/shared/imageSelectModal.php';?>
	</div>

</div>

<script>
app.controller('AddEditDrink', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('ImageSelectController', {$scope: $scope}));
	
	$scope.addOrEdit = "Add";
	$scope.saveOrUpdate = "Save";
	$scope.drink = {};

	$scope.setFromGet("data.php?get=drink_types", function(data){
		$scope.drink_types = data;
	});

	$scope.menuImage = {};

	$scope.$watch("useNewType", function(val){
		$scope.drink.type = '';
	});

	$scope.setMenuImage = function(image){
		$scope.menuImage = image;
		$('#imageSelectModal').modal('hide');
	}
	
	$scope.setById(function(drink){
		$scope.addOrEdit = "Edit";
		$scope.saveOrUpdate = "Update";
		$scope.drink = drink;
		$scope.drink.price = (drink.price) ? Number(drink.price) : '';
		$scope.menuImage = (drink.image) ? drink.image.parseEscape() : {};
				
		});

	$scope.$watch('menuImage', function(val){
		if(val){
			$scope.imageText = JSON.stringify(val).sanitize();
		}
	},true);

	
		
}]);
</script>
