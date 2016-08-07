<?php

function listMissingParametersInObject($object, $listOfRequiredParameters){
	$listOfMissingParameters = [];
	foreach ($listOfRequiredParameters as $parameter){
		if($object == null || !isset($object[$parameter])){array_push($listOfMissingParameters, $parameter);}
	}
	return $listOfMissingParameters;
}

function hasAllRequiredParameters($object, $listOfRequiredParameters){
	return (count(listMissingParametersInObject($object, $listOfRequiredParameters)) == 0);
}