<?php

function runOnPost($functionToRun){
	if(isPost()){
		$functionToRun();
	}
}

function isPost(){
	return !empty($_POST);
}

function runOnPostWithAllRequiredParameters($functionToRun, $listOfRequiredPostParameters=[]){
	if(isPost() && allRequiredPostParametersPresent($listOfRequiredPostParameters)){
		$functionToRun();
	}
}

function runOnPostWithAllRequiredParametersWithErrorReroute($functionToRun, $listOfRequiredPostParameters=[]){
	global $serverPath;
	require_once $serverPath."utils/redirectUtilities.php";
	if(isPost()) {
		$missingPostParameters = findMissingPostParameters($listOfRequiredPostParameters);
		if (count($missingPostParameters) == 0) {
			$functionToRun();
		} else {
			displayErrorNotAllRequiredDataPresentInPost($missingPostParameters);
		}
	}
}

function findMissingPostParameters($listOfRequiredPostParameters){
	$missingPostParameters = [];
	foreach ($listOfRequiredPostParameters as $parameter){
		if(!isset($_POST[$parameter])){array_push($missingPostParameters, $parameter);}
	}
	return $missingPostParameters;
}

function allRequiredPostParametersPresent($listOfRequiredPostParameters){
	return (count(findMissingPostParameters($listOfRequiredPostParameters))== 0);
}
