<?php

include_once '../../config/config.php';
include_once $serverPath.'utils/db_post.php';

$table = "drinks";

function rerouteWithError($errorMessage, $destination=null){
	$currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	if($destination== null){$destination = $currentUrl;}

	$newUrl = $destination."?error=".$errorMessage;
	header( 'Location: '.$newUrl) ;

	die("Redirected to: $newUrl");
}

function findByProperty($table, $columnName, $value){
	$queryStatement = "SELECT * FROM $table WHERE $columnName='$value';";
	$values = runQuery($queryStatement);
	return (count($values) == 0 ) ? null : $values[0];
}

function listByProperty($table, $columnName, $value){
	$queryStatement = "SELECT * FROM $table, WHERE $columnName='$value';";
	$values = runQuery($queryStatement);
	return (count($values) == 0) ? null :$values;
}

function escapeString($string){
	$db = connect();
	return mysqli_real_escape_string($db, $string);
}

uploadFile();

function uploadFile(){
	if(isset($_POST) && isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])){
		$file = $_FILES['file'];
		checkErrors($file);

		$fileData = fopen($_FILES['file']['tmp_name'], 'r');
		$menuData = getMenuData($fileData);

		importMenuData($menuData);

		header( 'Location: index.php') ;
		die("Redirected to: index.php");
	}
}

function checkErrors($file){
	if($file['error'] > 0){
		rerouteWithError("There was an error uploading the file");
	}

	if($file['type'] != "text/csv"){
		rerouteWithError("File must be a .csv format");
	}
}

function getMenuData($fileData){
	$firstRow = true;
	$menuData =[];
	while (($dataLine = fgetcsv($fileData, 1000, ',')) !== FALSE){
		if(!$firstRow){
			$menuLineItem = getMenuLineItem($dataLine);
			array_push($menuData, $menuLineItem);
		}
		if($firstRow){$firstRow = !$firstRow;}
	}
	return $menuData;
}

function getMenuLineItem($dataLine){
	$menuLineItem = [];
	$menuLineItem['name'] = escapeString($dataLine[0]);
	$menuLineItem['price'] = getDataLineQuanity($dataLine[1]);
	$menuLineItem['description'] = escapeString($dataLine[2]);
	$menuLineItem['type'] = escapeString($dataLine[3]);
	return $menuLineItem;
}

function getDataLineQuanity($dataLineQuanity){
	$numberValue = (int) str_replace("$", "",$dataLineQuanity);
	return ($numberValue == 0) ? null : escapeString($numberValue);
}

function importMenuData($menuData){
	global $table;

	foreach ($menuData as $menuDataRow){
		$currentMenuItem = findByProperty($table, "name", $menuDataRow['name']);

		if($currentMenuItem == null){
			$menuItemImportOrUpdateStatement = getMenuItemImportStatement($menuDataRow);
		}else{
			$menuItemImportOrUpdateStatement = getMenuUpdateStatement($menuDataRow);
		}
		runInsert($menuItemImportOrUpdateStatement);
	}
}

function getMenuItemImportStatement($menuDataRow){
	global $table;
	$name = $menuDataRow['name'];
	$price = $menuDataRow['price'];
	$description = $menuDataRow['description'];
	$type = $menuDataRow['type'];

	$insertStatement = "INSERT INTO $table (name, description, price, type) VALUES ('$name', '$description', '$price', '$type');";
	return $insertStatement;
}

function getMenuUpdateStatement($menuDataRow){
	global $table;
	$name = $menuDataRow['name'];
	$price = $menuDataRow['price'];
	$description = $menuDataRow['description'];
	$type = $menuDataRow['type'];

	$updateStatement = "UPDATE $table SET price='$price', description='$description', $table.type='$type' WHERE $table.name='$name';";
	return $updateStatement;
}

include_once $serverPath.'resources/templates/adminHead.php';
?>


<div ng-controller="MenuAdminImportController">
	<form action="import.php" method="post" enctype="multipart/form-data">
		<div class="container-fluid col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title">Import Menu Items</h1>
				</div>


				<div class="panel-body">

					<div class="form-group">
						<label for='file'>File</label>
						<input name="file" class="form-control" id="name" type="file">
					</div>
				</div>

				<div class="panel-footer">
					<button type="submit" class="btn btn-primary">Upload</button>
					<a class="btn btn-default" href="index.php">Cancel</a>
				</div>


			</div>
		</div>
	</form>




</div>

<script>
	app.controller('MenuAdminImportController', ['$scope', "$controller" , function($scope, $controller) {
		angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));


	}]);


</script>

