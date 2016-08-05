<div id="imagePreview" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    <div class="modal-content">
		    	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		    		<h3 class=" modal-title text-center">{{activeImage.drinkName}}</h3>
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

<script>
app.controller('ImagePreviewController', ['$scope', "$controller", function($scope, $controller){
	angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));

	$scope.addLink = function(array){
		angular.forEach(array, function (row) {
			 row.image = (row.image) ? row.image.parseEscape() : {};
		      row.imagePresent = function () {
					return (Object.keys(row.image).length==0) ? "No" : "Yes";
		      	};
		    });
	}

	$scope.previewImage = function(image, name){
		$scope.activeImage = image;
		$scope.activeImage.drinkName = name;
		$('#imagePreview').modal('show')
		
	}

	
}]);

</script>