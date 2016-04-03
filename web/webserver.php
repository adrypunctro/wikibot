<?php
// Build condition
$cond = array();
if(isset($_GET['day'])) {
	if(preg_match("/^([a-z]+)_([0-9]+)$/i", $_GET['day'], $output_array) === 0) {
		die("Same problems with <strong>day</strong> parameter.");
	}
	$cond['day'] = $_GET['day'];
}
if(isset($_GET['year'])) {
	$cond['year'] = (int)$_GET['year'];
}
if(isset($_GET['category'])) {
	$cond['category'] = strtolower($_GET['category']);
}
if(isset($_GET['keywords'])) {
	$cond['$text'] =array('$search' => $_GET['keywords']);
}

// Connect to mongodb
$m = new MongoClient();
$db = $m->selectDB('local');
$collection = new MongoCollection($db, 'articles');

// search
$cursor = $collection->find($cond);
$ret=NULL;
foreach($cursor as $doc) {
	$ret[] = $doc;
}

header('Content-Type: application/json');
echo json_encode(array("results"=>$ret));
?>