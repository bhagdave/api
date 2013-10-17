<?php
require_once('/simpletest/autorun.php');
class TestClassifier extends UnitTestCase {
	protected $class;
	public function setUp(){
		$this->class = new Classifier();
	}
	public function tearDown(){
		unset($this->class);
	}
	public function testGetProbableClass(){
		$result = $this->class->getProbableClass('Monkey');
		$this->assertNotNull($result);
		echo($result);
	}
}
?>