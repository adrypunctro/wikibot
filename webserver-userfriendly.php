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

// Search in db
$cursor = $collection->find($cond);
$items=array();
foreach ($cursor as $doc) {
	$items[] = $doc;
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
    <h1><?php //echo $_day;?></h1>
    <ul>
        <li>
            <h2><?php //echo ucfirst($_category);?></h2>
            <ul>
            	<?php foreach($items as $item):?>
                <li><?php echo $item['title'];?></li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
</section>
</body>
</html>