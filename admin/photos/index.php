<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/adminHead.php';
?>

<div ng-controller="PhotoAdminIndexController">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Albumns Displayed</h4>
				</div>
				<div class="panel-body">
					<div ui-grid="ShownAlbumnsGrid" external-scopes="$scope" style="height: 400px;"></div>
				</div>
				
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Albumns Not Displayed</h4>
				</div>
				<div class="panel-body" ng-show="HiddenAlbumnsGridShow">
					<div ui-grid="HiddenAlbumnsGrid"  external-scopes="$scope" style="height: 400px;"></div>
				</div>	
			</div>
		</div>
	</div>
</div>

<script>
app.controller("PhotoAdminIndexController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));

	$scope.HiddenAlbumnsGridShow = true;
	var gridOptions = {enableFiltering: true, enableColumnMenus: false, enableColumnResizing: true, showColumnFooter: true , enableSorting: false, showGridFooter: true, enableRowHeaderSelection: false, rowHeight: 42};

	$scope.ShownAlbumnsGrid = clone(gridOptions);
	$scope.HiddenAlbumnsGrid = clone(gridOptions);
	$scope.ShownAlbumnsGrid.columnDefs = [{field: 'name'}, {field: 'hide', enableFiltering: false, width: 67,  cellTemplate: '<button class="btn btn-danger" ng-click="grid.appScope.deleteWhiteList(row.entity.id);">Hide</button>'}];
	$scope.HiddenAlbumnsGrid.columnDefs = [{field: 'show', enableFiltering: false, width: 67,  cellTemplate: '<button class="btn btn-primary" ng-click="grid.appScope.addWhiteList(row.entity.id);">Show</button>'},{field: 'name'}];

	$scope.updateGrids = function(){
		var requestAlbumns = "https://graph.facebook.com/157036440997632/albums?fields=id,name";
		$scope.setFromFacebook(requestAlbumns, function(facebookAlbums){
			var albumns = facebookAlbums.data;
			$scope.albumns = {shown: [], hidden: []};
			$scope.setFromGet('data.php?get=whitelistedAlbumns', function(whiteListed){
				var whitListedIds = [];
				for(var i=0; i<whiteListed.length; i++){
					whitListedIds.push(whiteListed[i].faceBookID);
				}	
				for(var i=0; i<albumns.length; i++){
					if(whitListedIds.indexOf(albumns[i].id) > -1){
						$scope.albumns.shown.push(albumns[i]);
					}else{
						$scope.albumns.hidden.push(albumns[i]);
					}
				}
				$scope.ShownAlbumnsGrid.data = $scope.albumns.shown;
				$scope.HiddenAlbumnsGrid.data = $scope.albumns.hidden;
			});
		});
	}

	$scope.deleteWhiteList = function(value){
		var post = "delete.php?faceBookID="+value;
		$scope.runPost(post, {},$scope.updateGrids);
		
	}

	$scope.addWhiteList = function(value){
		var post = "insert.php?faceBookID="+value;
		$scope.runPost(post, {}, $scope.updateGrids);
		
		
	}
	
	$scope.updateGrids();
	

}]);
	
</script>