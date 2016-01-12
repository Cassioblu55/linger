<?php 
	include_once 'config/config.php';
	include_once $serverPath.'resources/templates/head.php';
?>
<div ng-controller="LandingPageController">
	<div class="container-fluid" style="margin-bottom: 30px">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<!-- carousel -->
				<div class="row">
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
				<!-- carousel ends-->
				
				<!-- events -->
				<div class="row">
					<div ng-repeat="event in events">
						<div class="col-md-3 col-sm-6">
							<h4 class="hideOverFlowWithEllipis primary-color" style="text-align: center; 	white-space: nowrap;">{{event.name}}</h4>
							<hr class="title_line">
							<div style="height: 150px; width: 100%; border: white;">
								<a href="<?php echo $baseURL;?>views/events/">
									<img src="<?php echo $baseURL;?>resources/images/lingerDefaultImage.png" class="mainPageEventImages" ng-hide="event.image.source">
									<img class="mainPageEventImages" ng-show="event.image.source" ng-src="{{event.image.source}}"></a>
							</div>
							<hr class="title_line">
							<p class="hideOverFlowWithEllipis" style="height: 100px;">{{event.description}}</p>
						</div>
					</div>
				
				</div>
				<!-- events end -->
				
				
				
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>

<script src="<?php echo $baseURL;?>resources/eventSort.js"></script>
<script>
app.controller("LandingPageController", ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('GetEventsController', {$scope: $scope}));

	$scope.setFromGet('<?php echo $baseURL;?>resources/data.php?get=carousel', function(data){
		angular.forEach(data, function (row) {
			row.image = row.image.parseEscape();
			});
		$scope.carouselPhotos = data;
	});

	$scope.start_date = moment().format('MM/DD/YY');
	$scope.end_date = moment().add(7, 'days').format('MM/DD/YY');

	$scope.getEvents($scope.start_date, $scope.end_date, function(data){
		$scope.events = data.slice(0,4);
	})

}]);

</script>

<?php include_once $serverPath.'resources/templates/footer.php'; ?>




