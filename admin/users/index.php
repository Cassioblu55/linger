<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/adminHead.php';
?>

<div ng-controller="UserIndexController">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Events</h4>
						<a href="invite.php" class ="btn btn-primary pull-right">Invite</a>
					</div>
					<div class="panel-body">
						<div ui-grid="gridModel" external-scopes="$scope"
							style="height: 400px;"></div>
					</div>
					<div class="panel-footer">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
app.controller("UserIndexController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('ImagePreviewController', {$scope: $scope}));
	
	$scope.gridModel = {enableFiltering: true, enableColumnMenus: false, enableColumnResizing: true, showColumnFooter: true , enableSorting: false, showGridFooter: true, enableRowHeaderSelection: false, rowHeight: 42};
	$scope.gridModel.columnDefs = [	{field: 'username'},{field: 'email'},{field: 'active'},
	                           		{field: 'Active/Deactivate', enableFiltering: false, width: 67,  cellTemplate: '<button class="btn btn-danger" ng-click="grid.appScope.deleteById(row.entity.id,row.entity.name, grid.appScope.updateGrid);">Delete</button>'}
	                           	];

	$scope.updateGrid = function(){
		$scope.setFromGet("data.php?get=grid", function(data){
			$scope.gridModel.data = data;
			$scope.addLink($scope.gridModel.data);
		});
	}
	$scope.updateGrid();
	
}]);
</script>