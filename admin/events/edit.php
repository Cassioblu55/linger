<?php
include_once '../../config/config.php';
include_once $serverPath.'utils/db_post.php';
include_once $serverPath.'utils/postUtilities.php';
	
runOnPost("addOrUpdate");

function addOrUpdate(){
	$table = "events";
	$data = createDataFromPost($table);

	if (empty ( $_GET ['id'] )) {
		insert($table, $data);
	}
	else {
		update($table, $data);
	}
	header ( "Location: index.php");
	die ( "Redirecting to index.php" );
}

include_once $serverPath.'resources/templates/adminHead.php';
?>

<div ng-controller="AddEditEvent">
	<div class="container-fluid">
		<form action="edit.php<?php if(!empty($_GET['id'])){ echo "?id=".$_GET['id'];}?>" enctype="multipart/form-data" method="post">
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
							<input type="text" name="name" class="form-control" ng-model="event.name" placeholder="Name">
						</div>
						<!-- name ends -->
						
						<!-- type -->
						<div class="row form-group">
							<div class="col-md-6">
								<label>Type</label>
								<select name="type" ng-model="event.type" class="form-control">
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
										<input ng-model="event.startDate" type="date" class="form-control"/>
									</div>
									<div class="col-md-4">
										<label>Start Time</label>
										<input ng-model="days[0].startTime" type="time" class="form-control"/>
									</div>
									<div class="col-md-4">
										<label>End Time</label>
										<input ng-model="days[0].endTime" type="time" class="form-control"/>
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
										<button type="button" class="btn btn-primary btn-sm pull-right" ng-click='days.push({})'>Add</button>
									</div>
									<!-- panel header ends -->
									<!-- panel body -->
									<div class="panel-body">
									
										<div class="row form-group">
											<!-- start date -->
											<div class="col-md-6">
												<label for="startDate">Start Date</label>
												<input type="date" ng-model="event.startDate" class="form-control">
											</div>
											<!-- start date ends-->
											<!-- end date -->
											<div class="col-md-6">
												<label for="startDate">End Date</label>
												<input type="date" ng-model="event.endDate" class="form-control">
											</div>
											<!-- end date ends-->
										</div>
										<div ng-show="days.length==0">Add a Day</div>
										<!-- more then 0 dates -->
										
										
										<div ng-show="days.length>0">
											<div class="row">
												<div class="col-md-3"><label>Day</label></div>
												<div class="col-md-3"><label>Start Time</label></div>
												<div class="col-md-3"><label>End Time</label></div>
											</div>
											<!-- dates -->
											<div ng-repeat="day in days track by $index">
												<div class="row form-group">
													<!-- days of the week -->
													<div class="col-md-3">
														<select ng-model="day.dayOfWeek" class="form-control">
															<option value="">Select One</option>
															<option ng-repeat="d in daysOfTheWeek track by $index">{{d}}</option>
														</select>
													</div>
													<!-- days of the week ends -->
													<!-- start time -->
													<div class="col-md-3">
														<input ng-model="day.startTime" type="time" class="form-control"/>
													</div>
													<!-- start time ends -->
													<!-- end time -->
													<div class="col-md-3">
														<input ng-model="day.endTime" type="time" class="form-control"/>
													</div>
													<!-- end time ends -->
													<!-- delete -->
													<div class="col-md-3 form-group">
														<button class="btn btn-danger" type="button" ng-click="days.splice($index,1)">Delete</button>
													</div>
													<!-- delete ends -->
													
												</div>							
											</div>
											<!-- date end -->
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
						<textarea rows="5" name="description" class="form-control">{{event.description}}</textarea>
					</div>
					<!-- description ends -->
					
					<!-- image -->
					<div class="form-group">
						<button class="btn btn-primary" type="button" ng-click="editImage(eventImage, setEventImage)">{{!eventImage.source ? 'Get Image' : 'Change Image' }}</button>
						<button ng-show="eventImage.source" class="btn btn-danger" type="button" ng-click="eventImage={}">Clear Image</button>
					</div>
					<div class="form-group">
						<img ng-show="eventImage.source" class="selectableImage" ng-click="editImage(eventImage, setEventImage)" style="max-width: 50%" ng-src="{{eventImage.source}}" height="200px"/>
					</div>
					<!-- image ends -->
					
					<!-- active -->
					<div class="row form-group">
						<div class="col-md-6">
							<label for="active">Active</label>
							<select ng-model="event.active" name="active" class="form-control">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<!-- active ends -->
					
					<!--  panel body ends -->
					</div>
					</div>
					<!-- panel-footer -->
					<div class="panel-footer">
						<button class="btn btn-primary" type="submit">{{saveOrUpdate}}</button>
						<a href="index.php" class="btn btn-danger">Cancel</a>
					</div>
					<!-- panel-footer ends -->
					
					<!-- panel ends -->
				</div>
			</div>
			
			
			<input name="dates" class="hidden" ng-model="days_text" type="text">
			<input name="startDate" class="hidden" ng-model="startDateInMillis" type="text">
			<input name="endDate" class="hidden" ng-model="endDateInMillis" type="text">
			<input type="text" ng-model="imageText" class="hidden" name="image" >
			
			<?php include_once $serverPath.'resources/shared/imageSelectModal.php';?>
		</form>
	</div>
</div>

<script>
app.controller('AddEditEvent', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('ImageSelectController', {$scope: $scope}));

	$scope.daysOfTheWeek = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
	
	$scope.addOrEdit = "Add";
	$scope.saveOrUpdate = "Save";
	$scope.event = {};
	$scope.event.type="recurring";
	$scope.days =[];
	$scope.event.active="Yes";
	$scope.eventImage = {};
	

	$scope.$watch('event.type', function(val, oldVal){
		if(oldVal && oldVal != val){
			$scope.days =[];
			if(val == 'singleDay'){
				$scope.days.push({});
			}
		}
	});

	$scope.$watch('days', function(val){
			$scope.days_text = (val) ? JSON.stringify(val) : null;
	},true);

	$scope.$watch('event.startDate', function(val){
		if(val && val instanceof Date){
			$scope.startDateInMillis = val.getTime();
		}else{
			$scope.startDateInMillis = null;
		}
	});

	$scope.setEventImage = function(image){
		$scope.eventImage= image;
		$('#imageSelectModal').modal('hide');
	}

	$scope.$watch('startDateInMillis', function(val){
		if($scope.event && $scope.event.type=='singleDay'){$scope.endDateInMillis = val;}
	});
	
	$scope.$watch('event.endDate', function(val){
		if(val && val instanceof Date){
			$scope.endDateInMillis = val.getTime();
		}else{
			$scope.endDateInMillis = null;
		}
	});

	$scope.$watch('eventImage', function(val){
		if(val){
			$scope.imageText = JSON.stringify(val).escapeSpecialChars();
		}
	},true);
	
	function setEvent(event){
		$scope.addOrEdit = "Edit";
		$scope.saveOrUpdate = "Update";
		$scope.event = event;
		$scope.eventImage = (event.image) ? event.image.parseEscape() : {};
		$scope.days = JSON.parse(event.dates);
		$scope.event.startDate = ($scope.event.startDate && $scope.event.startDate != 0) ? new Date(Number($scope.event.startDate)) : null;
		$scope.event.endDate = ($scope.event.endDate && $scope.event.endDate != 0) ? new Date(Number($scope.event.endDate)) : null;
		for(var i=0; i<$scope.days.length; i++){
			$scope.days[i].startTime = new Date($scope.days[i].startTime);
			$scope.days[i].endTime = new Date($scope.days[i].endTime);
			}		
		}
	
	$scope.setById(setEvent);


		
}]);
</script>