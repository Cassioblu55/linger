<?php
// connects to database
function connect() {
	global $dbHost;
	global $dbUser;
	global $dbPassword;
	global $dbName;
	
	return connectSpecific ( $dbHost, $dbUser, $dbPassword, $dbName);
}

function connectSpecific($dbHost, $dbUser, $dbPassword, $dbName) {
	try {
		$db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
	} catch ( Exception $e ) {
		die('Connection failed: ' . $e->getMessage ());
	}
	return $db;
}

function cutString($string, $n){return substr ( $string, 0, strlen ( $string ) - $n );}

function getCleanValue($value){
	$cleanValue = getValueString(str_replace("'","\'",$value));
	return $cleanValue;
	
}

//will take array of string and return comma seperated string of all values
function arrayToString($array){
	$string = "";
	foreach($array as $item){
		$string.=$item.", ";
	}
	return substr($string, 0,strlen($string)-2);
}

function runQuery($query){
	$db = connect();
	$results = [];
	$result = $db->query ( $query );
	if (!$result) {
		echo 'Could not run query: ' .$query;
		exit;
	}
	while ( $row = $result->fetch_assoc () ) {
		array_push($results,$row);
	}
	$db->close();
	return $results;
}

function getColumnQuote($column){
	return '`'.$column.'`';
}


//will return all column data for a given table
function getColumns($table){
	$query = "SHOW COLUMNS FROM ".getTableQuote($table);
	return runQuery($query);
}

//Will return list of column names for given table, without id
function getColumnNames($table){
	$result = getColumns($table);
	$columns = [];
	foreach ($result as $row){
		if($row['Field'] != 'id'){
			array_push($columns,$row['Field']);
		}
	}
	return $columns;
}

function getColumnNamesWithTable($table){
	$c = getColumnNames($table);
	$t = getTableQuote($table);
	$columns = [];
	foreach ($c as $row){
		$r = $t.".".$row;
		array_push($columns, $r);
	}
	return $columns;
}


// function dieOnMissingRequired($array){
// 	foreach ($array as $key){
// 		$name = ($array[$key] || $key);
// 		if(empty($_POST[$key])){
// 			die("Please enter $name");
// 		}
// 	}
	
// }

function getRequiredColumns($table){
	$result = getColumns($table);
	$columns = [];
	foreach ($result as $row){
		if($row['Field'] != 'id' && $row['Null']=='NO'){
			array_push($columns,$row['Field']);
		}
	}
	return $columns;
}

//Will take a table name and will add an error whenever a required column is not present
function validateRequired($table){
	if (! empty ( $_POST )) {
		$errors = [];
		$required = getRequiredColumns($table);
		foreach ($required as $column){
			if (empty ( $_POST [$column] )) {
				 array_push($errors, "Please enter ".$column);
			}
		}
		if(count($errors) >0){
			foreach ($errors as $error){
				echo $error;
			}
			die("Missing required columns");
		}
		
	}
}

//Adds correct quotes to table name for mysql
function getTableQuote($table){return "`".$table."`";}

//Will add quotes to string values and not to integer values
function getValueString($value){
	return (gettype($value)=="string")  ? "'".$value."'" : $value;
}

function valuesToString($table){
	if(!empty($_POST)){
		$columns = getColumnNames($table);
		$string = "(";
		foreach ($columns as $column){
			$string .= getValueString($_POST[$column]).", ";
		}
		return substr($string, 0,strlen($string)-2).")";
	}
}

//Will return list of columns as string with ()
function columnsToString($table){
	$columns = getColumnNames($table);
	$string = "(";
	foreach ($columns as $column){
		$string.=$column.", ";
	}
	return substr($string, 0,strlen($string)-2).")";
}

function getConstraints($constraints){
	return "WHERE ". getConstraintBody($constraints);
}

function getConstraintBody($constraints){
	$constraint = "";
	foreach ($constraints as $columnName => $value){
		$constraint .= $columnName ."=".getValueString($value)." AND ";
	}
	return (strlen($constraint) == 0) ? "" : cutString($constraint, 5);
}


function getJoinOn($table1, $table2, $joinOn){
	$t_1 = getTableQuote($table1);
	$t_2 = getTableQuote($table2);
	$s ="";
	foreach ($joinOn as $t1Value => $t2Value){
		$s .= $t_1.".".$t1Value."=".$t_2.".".$t2Value.", ";
	}
	return cutString($s, 2); 
}

function getConstraintsWithTables($tables){
	$con = "WHERE ";
	foreach ($tables as $table => $constraints){
		if(count($constraints) >0){
			$con .= getConstraintsWithTable($table, $constraints)." AND ";
		}
	}
	return cutString($con, 5);
}

function getConstraintsWithTable($table, $constraints){
	$q_table = getTableQuote($table);
	foreach ($constraints as $columnName => $value){
		$constraints[$q_table.".".$columnName] = $value;
		unset($constraints[$columnName]);
	}
	return getConstraintBody($constraints);
}


?>