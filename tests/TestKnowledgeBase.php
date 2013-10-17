<?php
require_once('/simpletest/autorun.php');
class TestKnowledgeBase extends UnitTestCase {
	protected $kbase;
	public function setUp(){
		$this->kbase = new KnowledgeBase();
	}
	public function tearDown(){
		unset($this->kbase);
	}
	public function testGetKnowledgeBase(){
		try {
			$data = $this->kbase->getKnowledgeBase();
			$this->assertNotNull($data);
		} catch (Exception $e) {
			$this->assertTrue(false);
		}
	}
	public function testSetKnowledge(){
		try {
			$data = $this->kbase->getKnowledgeBase();
			$this->assertNotNull($data);
			$this->kbase->setKnowledgeBase($data);
		} catch (Exception $e) {
			$this->assertTrue(false);
		}
	}
	
	public function testGetDistinctClasses(){
		try {
			$data = $this->kbase->getDistinctClasses();
			$this->assertNotNull($data);
		} catch (Exception $e) {
			$this->assertTrue(false);
		}
	}
}
?>