<?php
include_once $serverPath . 'utils/connect.php';

function update($table, $data) {
	$update = makeBaseUpdate($table, $data)." WHERE id=".$_GET['id'].";";
	//echo $update;
	runInsert($update);
}

function updateFromPost($table){
	update($table, createDataFromPost($table));
}

function updateWithConstratints($table, $data, $constraints){
	$update = makeBaseUpdate($table, $data)." ";
	foreach ($constraints as $columnName => $value){
		$update .= "WHERE ".getColumnQuote($columnName)."='".$value."' AND ";
	}
	$update = cutString($update, 4).";";
	runInsert($update);
}

function makeBaseUpdate($table, $data){
	$update = "UPDATE " . getTableQuote($table)." SET ";
	foreach ( $data as $columnName => $value ) {
		$update .= getColumnQuote($columnName)."=".getCleanValue($value) . ", ";
	}
	return cutString($update, 2);
}

function insertAndReturnId($table, $data){
	$insert = getInsertStatement($table,$data);
	//echo $insert;
	return runInsertWithIdReturn($insert);
}

function runInsertWithIdReturn($insert){
	$db = runInsertWithDBReturn($insert);
	$inserted = $db->insert_id;
	$db->close();
	return $inserted;
}

function getInsertStatement($table,$data){
	$columns = " (";
	$values = " (";
	foreach ( $data as $columnName => $value ) {
		$columns .= $columnName . ", ";
		$values .= "".getCleanValue($value) . ", ";
	}
	$columns = cutString($columns, 2).")";
	$values = cutString($values, 2).")";
	
	return "INSERT INTO " . getTableQuote($table) . $columns . " VALUES " . $values . ";";
}


function insert($table, $data) {
	runInsert (getInsertStatement($table,$data));
}

function runInsert($insert) {
	echo $insert;
	$db = connect ();
	try {
		$db->query ($insert );
	} catch ( Execption $e ) {
		echo "Could not complete request: " . $insert;
		echo $e;
		die ( "Could not complete request: " . $insert );
	}
	$db->close ();
}

function createInsertFromPost($table){
	return getInsertStatement($table,createDataFromPost($table));
}

function createDataFromPost($table){
	$columns = getColumnNames($table);
	$data = [];
	foreach ($columns as $column){
		$data[$column] =$_POST[$column];
	}
	return $data;
}


function insertFromPost($table){
	runInsert(createInsertFromPost($table));
}

function insertFromPostWithIdReturn($table){
	return runInsertWithIdReturn(createInsertFromPost($table));
}

function deleteFrom($table, $id){
	$insert = "DELETE FROM ".getTableQuote($table)." WHERE id=".$id.";";
	runInsert($insert);
}

function runInsertWithDBReturn($insert){
	//echo $insert;
	$db = connect();
	try {		
		$db->query ($insert );
		return $db;
	} catch ( Execption $e ) {
		echo "Could not complete request: ".$insert;
		echo $e;
		$db->close();
		die ( "Could not complete request: ".$insert);
	}
}

?>