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
$items=array();
foreach ($cursor as $doc) {
	$items = $doc[$_category];
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WikiPyBot - Web Server</title>
<style>
body {padding:20px;font-size:0.875em;font-family:sans-serif;color:#252525}
ul {padding:0;margin:0;}
.wkpb-content > h1 {font-size:1.9em;line-height:1.3;margin-bottom:0.25em;margin-top:0;padding:0 0 5px 0;border-bottom:1px solid #999;font-weight:normal;}
.wkpb-content > ul {}
.wkpb-content > ul > li {margin:0 30px;}
.wkpb-content > ul > li > h2 {margin-bottom:10px;}
</style>
</head>

<body>
<section class="wkpb-content">
    <h1><?php echo $_day;?></h1>
    <ul>
        <li>
            <h2><?php echo ucfirst($_category);?></h2>
            <ul>
            	<?php foreach($items as $item):?>
                <li><?php echo $item;?></li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
</section>
</body>
</html>