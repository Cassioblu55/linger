<?php
	include_once '../../config/config.php';
	include_once $serverPath.'resources/templates/adminHead.php';
?>

<div ng-controller="AddEditEvent">
	<form action="edit.php<?php if(!empty($_GET['id'])){ echo "?id=".$_GET['id'];}?>" method="post">
		<div class="row">
			<div class="col-md-6">
			<!-- panel -->
			<div class="panel panel-default">
				<!-- Header -->
						<div class="panel-heading">
							<h3 class="panel-title">{{addOrEdit}} {{event.name || 'Event'}}</h3>
						</div>
				<!-- Header ends-->
				<!-- body -->
				<div class="panel-body">
					<!-- name -->
					<div class="form-group">
						<label for='name'>Name</label>
						<input type="text" class="form-control" ng-model="event.name" placeholder="Name">
					</div>
					<!-- name ends -->
					
					<!-- type -->
					<div class="row form-group">
						<div class="col-md-6">
							<label>Type</label>
							<select ng-model="event.type" class="form-control">
								<option value="recurring">Recurring</option>
								<option value="singleDay">Single Day</option>
<!-- 								<option value="multiDay">Multiple Days</option> -->
							</select>						
						</div>
					</div>
					<!-- type ends -->
					
					<!-- single day -->
						<div ng-show="event.type=='singleDay'" class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="singleDay">Date</label>
									<input ng-model="dates[0].singleDay" type="date" class="form-control"/>
								</div>
								<div class="col-md-4">
									<label>Start Time</label>
									<input ng-model="dates[0].startTime" type="time" class="form-control"/>
								</div>
								<div class="col-md-4">
									<label>End Time</label>
									<input ng-model="dates[0].endTime" type="time" class="form-control"/>
								</div>
							
							</div>
							
						</div>
					<!-- single day ends -->
					
					<!-- recurring days -->
						<div ng-show="event.type=='recurring'" class="form-group">
						
							<!-- recurring panel -->
							<div class="panel panel-default">
								<!-- panel  header -->
								<div class="panel-heading clearfix">
									<h3 class="panel-title pull-left">Days</h3>
									<button type="button" class="btn btn-primary btn-sm pull-right" ng-click='dates.push({})'>Add</button>
								</div>
								<!-- panel header ends -->
								<!-- panel body -->
								<div class="panel-body">
								
									<div class="row form-group">
										<!-- start date -->
										<div class="col-md-6">
											<label for="startDate">Start Date</label>
											<input type="date" ng-model="date.startDate" class="form-control">
										</div>
										<!-- start date ends-->
										<!-- end date -->
										<div class="col-md-6">
											<label for="startDate">End Date</label>
											<input type="date" ng-model="date.endDate" class="form-control">
										</div>
										<!-- end date ends-->
									</div>
									<div ng-show="dates.length==0">Add a Day</div>
									<!-- more then 0 dates -->
									
									
									<div ng-show="dates.length>0">
										<div class="row">
											<div class="col-md-3"><label>Day</label></div>
											<div class="col-md-3"><label>Start Time</label></div>
											<div class="col-md-3"><label>End Time</label></div>
										</div>
										<!-- dates -->
										<div ng-repeat="date in dates track by $index">
											<div class="row form-group">
												<!-- days of the week -->
												<div class="col-md-3">
													<select ng-model="date.dayOfWeek" class="form-control">
														<option value="">Select One</option>
														<option ng-repeat="d in daysOfTheWeek track by $index">{{d}}</option>
													</select>
												</div>
												<!-- days of the week ends -->
												<!-- start time -->
												<div class="col-md-3">
													<input ng-model="date.startTime" type="time" class="form-control"/>
												</div>
												<!-- start time ends -->
												<!-- end time -->
												<div class="col-md-3">
													<input ng-model="date.endTime" type="time" class="form-control"/>
												</div>
												<!-- end time ends -->
												<!-- delete -->
												<div class="col-md-3 form-group">
													<button class="btn btn-danger" type="button" ng-click="dates.splice($index,1)">Delete</button>
												</div>
												<!-- delete ends -->
												
											</div>							
										</div>
										<!-- dates end -->
									</div>
									<!-- dates over 0 end -->
								</div>
							</div>
							<!-- recuring panel ends -->
						</div>
					<!-- recurring ends -->
					
				<!-- Description -->
				<div class="form-group">
					<label for="description">Description</label>
					<textarea rows="5" class="form-control">{{event.description}}</textarea>
				</div>
				<!-- description ends -->
				<!--  panel body ends -->
				</div>
				</div>
				<!-- panel ends -->
			</div>
		</div>
	</form>

</div>

<script>
app.controller('AddEditEvent', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('UtilsController', {$scope: $scope}));

	$scope.daysOfTheWeek = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
	
	$scope.addOrEdit = "Add";
	$scope.event = {};
	$scope.event.type="recurring";
	$scope.dates =[];

	$scope.$watch('event.type', function(oldVal, val){
		if(oldVal && oldVal != val){
			$scope.dates =[];
			if(val == 'singleDay'){
				$scope.dates.push({});
			}
		}
	});

	//$scope.$watch('event.
	

}]);

</script>