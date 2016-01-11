<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/adminHead.php';
?>

<div ng-controller="PhotoAdminIndexController">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Main Page Images</h4>
						<button type="button" class="btn btn-primary pull-right" ng-click="showCarouselInput = !showCarouselInput">{{(showCarouselInput) ? 'Hide' : 'Show'}}</button>
					</div>
					<div ng-show="showCarouselInput" class="panel-body">
						<div class="row">
							<div class="col-md-12 form-group">
								<button type="button" class="btn btn-primary" ng-click="getImage(addImageToCarousel)">Add Photo</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<span ng-repeat="photo in carouselPhotos">
									<img ng-src="{{photo.image.source}}" style="max-width: 100%; padding: 2px" ng-class="(selectedPhoto.image.source == photo.image.source) ? 'selectedImage' : 'selectableImage'" ng-click="setSelected(photo)" height="200px">
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<button type="button" ng-show="selectedPhoto.image.source != null" ng-click="removeSelectedPhoto()" class="btn btn-danger">Remove Photo</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Albumns Displayed</h4>
						<button type="button" class="btn btn-primary pull-right" ng-click="showAlbumnDisplay = !showAlbumnDisplay">{{(showAlbumnDisplay) ? 'Hide' : 'Show'}}</button>
					</div>
					<div ng-show="showAlbumnDisplay" class="panel-body">
						<div ui-grid="ShownAlbumnsGrid" ng-if="showAlbumnDisplay" external-scopes="$scope" style="height: 400px;"></div>
					</div>
					
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Albumns Not Displayed</h4>
						<button type="button" class="btn btn-primary pull-right" ng-click="hideAlbumnDisplay = !hideAlbumnDisplay">{{(hideAlbumnDisplay) ? 'Hide' : 'Show'}}</button>
					</div>
					<div class="panel-body" ng-show="hideAlbumnDisplay">
						<div ui-grid="HiddenAlbumnsGrid" ng-if="hideAlbumnDisplay"  external-scopes="$scope" style="height: 400px;"></div>
					</div>	
				</div>
			</div>
		</div>
		<?php include_once $serverPath.'resources/shared/imageSelectModal.php';?>
		
	</div>
</div>

<script>
app.controller("PhotoAdminIndexController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('ImageSelectController', {$scope: $scope}));

	$scope.showCarouselInput = true;
	$scope.selectedPhoto = {};
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

	$scope.addImageToCarousel = function(image){
		var post = "insert.php?carousel_image=true";
		$scope.runPost(post, {image: JSON.stringify(image).sanitize()},$scope.getCarosuelImages);
		$('#imageSelectModal').modal('hide');
	}

	$scope.getCarosuelImages = function(){
		$scope.setFromGet("data.php?get=carousel", function(data){
			angular.forEach(data, function (row) {
				row.image = row.image.parseEscape();
			});
			//console.log(data);
			$scope.carouselPhotos = data;
			
		});
	}
	$scope.getCarosuelImages();
	

	$scope.deleteWhiteList = function(value){
		var post = "delete.php?faceBookID="+value;
		$scope.runPost(post, {},$scope.updateGrids);
		
	}

	$scope.removeSelectedPhoto = function(){
		$scope.runPost("delete.php?carousel_image_id="+$scope.selectedPhoto.id, {}, $scope.getCarosuelImages);
		$scope.selectedPhoto = {};
	}

	$scope.addWhiteList = function(value){
		var post = "insert.php?faceBookID="+value;
		$scope.runPost(post, {}, $scope.updateGrids);		
	}

	$scope.setSelected = function(photo){
		$scope.selectedPhoto = ($scope.selectedPhoto == photo) ? {} : photo;	
	}
	
	$scope.updateGrids();
	

}]);
	
</script>