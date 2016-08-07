<?php

function addSuccessMessageToUrl($urlBase, $successMessage){
	$paramList = [];
	$paramList[successMessage] = $successMessage;
	$newUrl = addUrlParams($urlBase, $paramList);
	return $newUrl;
}

function addErrorMessageToUrl($urlBase, $errorMessage){
	$paramList = [];
	$paramList[errorMessage] = $errorMessage;
	$newUrl = addUrlParams($urlBase, $paramList);
	return $newUrl;
}

function addUrlParams($urlBase, $paramList){
	$firstParameter = true;
	$newUrl = $urlBase;
	foreach ($paramList as $param =>$value){
		$combineCharacter = ($firstParameter) ? "?" : "&";
		$newUrl .= $combineCharacter.$param."=".$value;
		$firstParameter = false;
	}
	return $newUrl;
}

function displayErrorNotAllRequiredDataPresentInPost($missingPostParameters){
	$currentLocation = getCurrentLocation();
	$errorMessage = "Not all required data present missing: ". implode(",", $missingPostParameters);
	$url = addErrorMessageToUrl($currentLocation, $errorMessage);

	header ( "Location: $url");
	die ( "Redirecting to: $currentLocation not all required data present");
}

function getCurrentLocation(){
	return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}