<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/adminHead.php';
	
?>

<div ng-controller="MenuAdminIndexController">
	
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Menu Items</h4>
			<a href="edit.php" class="btn btn-primary pull-right">Add</a>
		</div>
		<div class="panel-body">
			<div ui-grid="gridModel" external-scopes="$scope" style="height: 400px;"></div>
		</div>
	
	</div>
	

</div>



<script>
app.controller("MenuAdminIndexController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));
	
	$scope.gridModel = {enableFiltering: true, enableColumnMenus: false, enableColumnResizing: true, showColumnFooter: true , enableSorting: false, showGridFooter: true, enableRowHeaderSelection: false, rowHeight: 42};


	$scope.gridModel.columnDefs = [{field: 'edit', enableFiltering: false, width: 53, cellTemplate: '<a class="btn btn-primary" role="button" ng-href="edit.php?id={{row.entity.id}}">Edit</a>'},
	                               	{field: 'name'},{field: 'type'},{field: 'description'},
	                           		{field: 'delete', enableFiltering: false, width: 67,  cellTemplate: '<button class="btn btn-danger" ng-click="grid.appScope.deleteById(row.entity.id,row.entity.name, grid.appScope.updateGrid);">Delete</button>'}
	                           	];
	$scope.updateGrid = function(){
	  	$scope.setFromGet('data.php?get=grid', function(data){
			$scope.gridModel.data = data;
	  	});
	}
		
	$scope.updateGrid();

}]);


</script>