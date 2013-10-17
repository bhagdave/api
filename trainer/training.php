<?php
// Include path
set_include_path(realpath(__DIR__ . '/../' ) . PATH_SEPARATOR . get_include_path());

//Define Application Path
define('APPLICATION_PATH', realpath(__DIR__ . '/../'));

// Autoloader
function loader($class)
{
    require_once str_replace('\\', '/', $class) . '.php';
}
spl_autoload_register('loader');
$example_array = array(
	0=>array("Play"=>"online games"),
	1=>array("Play"=>"flash games"),
	2=>array("Play"=>"MMO Games"),
	3=>array("Play"=>"MMORPG"),
	4=>array("Play"=>"play free games"),
	5=>array("Get"=>"buy games"),
	6=>array("Get"=>"Download games"),
	7=>array("Get"=>"buy mac games"),
	8=>array("Get"=>"buy pc games"),
	9=>array("Get"=>"buy xbox games"),
	10=>array("Get"=>"buy playstaion games"),	
	11=>array("Love"=>"games reviews"),
	12=>array("Love"=>"Gaming stuff"),
	13=>array("Love"=>"gaming gossip"),
	14=>array("Love"=>"game cheats"),
	15=>array("Love"=>"game news")
);
// create a google search to use man...
$gs = new GoogleSearch('','');
// create a new trainer class
$trainer = new Trainer();
// loop through the example_array and send to the search..
foreach($example_array as $ex){
	foreach($ex as $k => $v){
		$gs->setQuery($v);
		$result = $gs->doSearchForTraining();
		$result = json_decode($result);
		foreach($result->items as $item){
			$trainer->add_example($item->link . $item->title,$k);
		}
	}
}
// okay they are all in memory now lets find the patterns
echo ("Extracting patterns\n");flush();
$trainer->extractPatterns();
//...lets create a KB
$kb = new KnowledgeBase();
echo ("Adding to database\n");flush();
$kb->setKnowledgeBase($trainer->knowledge);
// optimize the database.
echo ("Optimizing database\n");flush();
//$kb->optimize();

?>