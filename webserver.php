<?php
// Get parameters
if(!isset($_GET['year']) || !isset($_GET['day']) || !isset($_GET['category'])) {
	die("Please specify the parameters. Sample: ?year=2005&day=March_13&category=births");
}
// I received what I expect?
$_year = (int)$_GET['year'];
if(preg_match("/^([a-z]+)_([0-9]+)$/i", $_GET['day'], $output_array) === 0) {
	die("Same problems with <strong>day</strong> parameter.");
}
$_day = $_GET['day'];
$_category = strtolower($_GET['category']);

// It's ok. Proceed script.

// Connect to mongodb
$m = new MongoClient();
$db = $m->selectDB('local');
$collection = new MongoCollection($db, 'articles');

// search
$cursor = $collection->find(array('day' => $_day,'year' => $_year));
$ret=NULL;
foreach($cursor as $doc) {
	if($doc[$_category]) {
		foreach($doc[$_category] as $title) {
			$ret[] = array(
				'title'=>$title,
				'year'=>$_year,
				'day'=>$_day,
				'category'=>$_category,
			);
		}
	}
}

header('Content-Type: application/json');
echo json_encode(array("results"=>$ret));
?>