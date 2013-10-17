<?php
set_time_limit(120);
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
$url      = ((isset($_REQUEST['url']))      ? $_REQUEST['url']     : '');
$text     = ((isset($_REQUEST['text']))     ? $_REQUEST['text']    : '');
$callback = ((isset($_REQUEST['callback'])) ? $_REQUEST['callback']: null);
$class    = ((isset($_REQUEST['class']))    ? $_REQUEST['class']   : '');
$action   = ((isset($_REQUEST['action']))   ? $_REQUEST['action']  : '');
$api = new API($url,$text,$callback);
// get the remote ip address for quota bypass
$ipaddr = $_SERVER['REMOTE_ADDR'];
if ($action === ''){
	$api->run($ipaddr);
} else {
	switch ($action){
		case 'add' :
			$api->addForTraining($text,$class); 
		break;
	}
}
?>