<?php 
	include_once 'config/config.php';
	include_once $serverPath.'resources/templates/head.php';
?>
<div ng-controller="LandingPageController">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div id="carousel" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				  	<li ng-repeat="d in carouselPhotos track by $index" data-target="#carousel" data-slide-to="{{$index}}" ng-class="($index==0 ? 'active' : '')"></li>
				  </ol>
				
				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
					    <div ng-repeat="photo in carouselPhotos | orderBy:'-order' track by $index" class="item" ng-class="($index==0) ? 'active' : ''">
					      <img ng-src="{{photo.image.source}}" class="carouselImages">
					    </div>	  	
				  </div>
				
				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>

<script>
app.controller("LandingPageController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));

	$scope.setFromGet('<?php echo $baseURL;?>resources/data.php?get=carousel', function(data){
		angular.forEach(data, function (row) {
			console.log(row);
			row.image = row.image.parseEscape();
			});
		$scope.carouselPhotos = data;
	});
	

}]);

</script>

<?php include_once $serverPath.'resources/templates/footer.php'; ?>




