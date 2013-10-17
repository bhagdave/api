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
//$testClass  = new TestClassifier();
//$testAPI    = new TestAPI();
//$testGoogle = new TestSearchTools();
//$testWeb    = new TestAPIWebOutput();
$testKB     = new TestKnowledgeBase();
?>