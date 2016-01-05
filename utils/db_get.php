<?php 
include_once $serverPath.'utils/connect.php';
//Will run query and return results as array
function getAllData($table){
	$query = "SELECT * FROM ".getTableQuote($table).";";
	return runQuery($query);
}

function findById($table, $id){
	$query = "SELECT * FROM ".getTableQuote($table)." WHERE id=".$id;
	$result = runQuery($query);
	if($result[0]){
		return $result[0];
	}else{
		return null;
	}
}

function getSpecificData($table, $columns){
	$columnsString = "id, ".arrayToString($columns)."";
	$query = "SELECT ".$columnsString." FROM ".getTableQuote($table).";";
	return runQuery($query);
}

function getSpecificDataNoId($table, $columns){
	$columnsString = arrayToString($columns)."";
	$query = "SELECT ".$columnsString." FROM ".getTableQuote($table).";";
	return runQuery($query);
}

function getRandomId($table){
	$query = "SELECT id FROM ".getTableQuote($table)." ORDER BY RAND() LIMIT 1;";
	return runQuery($query)[0]['id'];
}

function getSingleColumnData($table, $column){
	$query = "SELECT ".$column." FROM ".getTableQuote($table);
	$results = runQuery($query);
	$data = [];
	foreach ($results as $row){
		array_push($data, $row[$column]);
	}
	return $data;
	
}


function getJoin($table1, $table2, $joinOn, $t1_constraints, $t2_constraints){
	$t1_q = getTableQuote($table1);
	$t2_q = getTableQuote($table2);
	$jo = getJoinOn($table1, $table2, $joinOn);
	
	$tables = [];
	$tables[$table1] = $t1_constraints;
	$tables[$table2] = $t2_constraints;
	
	$con = getConstraintsWithTables($tables);
	$t2_columns = arrayToString(getColumnNamesWithTable($table2));
	$query = "SELECT ".$t1_q.".*, ".$t2_columns." FROM ".$t1_q." INNER JOIN ".$t2_q." ON ".$jo." ".$con.";";
	return $query;
}

?>