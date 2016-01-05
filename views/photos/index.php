<?php
$title = "Photos from The Linger";
include_once '../../config/config.php';
include_once $serverPath.'resources/templates/head.php';

?>

<div ng-controller="PhotoIndex">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<span ng-repeat ="album in albums">
				<img class="albumDisplay" title="{{album.name}}" ng-src="{{album.cover_photo.source}}" ng-click="showAlbum(album.id)" height="200px">
			</span>
		</div>	
		<div class="col-md-1"></div>
	</div>
	
	<!-- album modal -->
	<div id="albumModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
		        <h3 class="modal-title albumTitle">{{activeAlbum.name}}</h4>
		      </div>
		      <div class="modal-body">
      			<table style="width: 100%;">
      			<tr>
      				<td class="photoNav noselect" ng-click="photoBack()"><</td>
      				<td>
						<img id="activePhoto" width="100%" ng-src="{{activePhoto.source}}">
      				</td>
      				<td class="photoNav noselect" ng-click="photoForward()">></td>
      			</tr>
      			</table>
      		</div>
			<div class="model-footer">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">{{activePhoto.name}}</div>
					<div class="col-md-1"></div>
				</div>
			</div>
		</div>
  		</div>
	</div>
	<!-- Model end -->
	

</div>

<script>
app.controller('PhotoIndex', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));
	
	function setAlbums(a){	
		var data = a.data;
		$scope.albums = [];
		$scope.setFromGet('data.php?get=whitelistedAlbumns', function(whiteListed){
			var whitListedIds = [];
			for(var i=0; i<whiteListed.length; i++){
				whitListedIds.push(whiteListed[i].faceBookID);
			}	
			for(var i=0; i<data.length; i++){
				if(whitListedIds.indexOf(data[i].id) > -1){$scope.albums.push(data[i]);}
			}
			
		});
	}

	function setActivePhotos(photos){
		$scope.activePhotos = photos.data;
		$scope.activePhoto = $scope.activePhotos[0];
	}

	function findByParam(array, param, paramName){
		paramName = paramName || 'id';
		for(var i=0; i<array.length; i++){
			if(array[i][paramName] == param){return array[i];}
		}
		return null;
	}

	$scope.getImageHeight = function(id){
		return  document.getElementById(id).offsetHeight;;
	}

	function getIndexById(array, id){
		for(var i=0; i<array.length; i++){
			if(array[i].id == id){return i;}
		}
		return null;
	}	
	
	$scope.photoBack = function(){
		var index = getIndexById($scope.activePhotos,$scope.activePhoto.id);
		if(index==0){$scope.activePhoto = $scope.activePhotos[$scope.activePhotos.length-1];}
		else{$scope.activePhoto = $scope.activePhotos[--index];}
	}

	$scope.photoForward = function(){
		var index = getIndexById($scope.activePhotos,$scope.activePhoto.id);
		if(index==$scope.activePhotos.length-1){$scope.activePhoto = $scope.activePhotos[0];}
		else{$scope.activePhoto = $scope.activePhotos[++index];}
	}	

	

	$scope.showAlbum = function(id){
		$scope.activeAlbum = findByParam($scope.albums, id);
		var photosRequest ="https://graph.facebook.com/"+id+"/photos?fields=name,source,id";
		$scope.setFromFacebook(photosRequest, setActivePhotos);
		$('#albumModal').modal('show') 
	}

	var request = "https://graph.facebook.com/157036440997632/albums?fields=id,link,name,count,cover_photo{id,source}";
	$scope.setFromFacebook(request, setAlbums);
	
}]);
</script>