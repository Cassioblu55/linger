<div id="imageSelectModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">{{(!image.source) ? 'Add' : 'Change'}} Image</h4>
		      </div>
		      <div class="modal-body">
		        <!-- albumn select -->
		        <select class="form-group form-control" ng-model="imageSelectActiveAlbumn" ng-options="albumn as albumn.name for albumn in modal_albums">
					<option value=''>Select One</option>
				</select>
		        <!-- albumn select ends -->
		        
		        <!-- image select -->
		        <span ng-repeat="photo in modal_photos">
		        <img height="200px" style="max-width: 100%;" ng-click="imageClick(photo)"  ng-style='image.source == photo.source ? selected : ""' ng-src="{{photo.source}}">
		        </span>
		        <!-- image select ends -->		        
		      </div>
			</div>
  		</div>
	</div>


<script>
app.controller('ImageSelectController', ['$scope', "$controller", function($scope, $controller){
	angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));

	$scope.image = {};

	$scope.selected = {border: "5px solid red"};
	
	$scope.setFromFacebook("https://graph.facebook.com/157036440997632/albums?fields=id,name", function(albums){
		$scope.modal_albums = albums.data;
	});

	$scope.$watch('imageSelectActiveAlbumn', function(val){
		if(val){
			$scope.setFromFacebook("https://graph.facebook.com/"+val.id+"/photos?fields=name,source,id,album", function(photos){
				$scope.modal_photos = photos.data;
				//console.log(photos.data);
			});
		}
	},true);
	
	$scope.getImage = function(funct){
		$scope.imageClick = funct;
		$('#imageSelectModal').modal('show');
	}

	$scope.editImage = function(image, funct){
		$scope.imageClick = funct;
		$scope.image = image;
		if($scope.image.album){
			$scope.imageSelectActiveAlbumn = $scope.modal_albums.findByProperty($scope.image.album.id);
		}
		$('#imageSelectModal').modal('show');
	}

	$scope.setImage = function(image, name){
		$scope[name] = image;
	}

}]);


</script>