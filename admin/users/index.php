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
						<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Users</h4>
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
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));
	
	$scope.gridModel = {enableFiltering: true, enableColumnMenus: false, enableColumnResizing: true, showColumnFooter: true , enableSorting: false, showGridFooter: true, enableRowHeaderSelection: false, rowHeight: 42};
	$scope.gridModel.columnDefs = [	{field: 'username'},{field: 'email'},{field: 'active_display', name: 'Active'},
	                               	{field: 'activate', width: 95, cellTemplate: '<div class="btn" ng-class="(row.entity.active == 1) ? \'btn-info\' : \'btn-primary\'" ng-click="grid.appScope.activate(row.entity)">{{(row.entity.active==1) ? "Deactivate" : "Activate"}}</div>' },
	                           		{field: 'Delete', enableFiltering: false, width: 67,  cellTemplate: '<button class="btn btn-danger" ng-click="grid.appScope.deleteById(row.entity.id,row.entity.name, grid.appScope.updateGrid);">Delete</button>'}
	                           	];

	$scope.updateGrid = function(d){
		$scope.setFromGet("data.php?get=grid", function(data){
			$scope.gridModel.data = data;
			angular.forEach($scope.gridModel.data, function (row) {
				row.active_display = (row.active ==1) ? 'Yes' : 'No';
			});
		});
	}

	$scope.activate = function(user){
		if(window.confirm("Are you sure you want to "+((user.active == 1) ? 'deactivate ' : 'activate ' )+user.username+"?")){
			var post = "activateDeactivate.php";
			var a = (user.active==1) ? 0 : 1;
			var data = {id: user.id, active: a, email: user.email};
			$scope.runPost(post, data, $scope.updateGrid);
		}

	}
	
	$scope.updateGrid();
	
}]);
</script>