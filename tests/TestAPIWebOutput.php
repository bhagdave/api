<?php
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');
class TestAPIWebOutput extends WebTestCase {    
/**
  * testRunReturnsTextWithUrlSetAndNoTextSet
  *
  * Run the test to check if the API returns json when sent a URL
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
	public function testRunReturnsErrorWithUrlSetAndNoTextSet(){
		$url = "http://www.dave-gill.co.uk";
		$this->get("http://local.api/index.php?url=$url");
		$this->assertResponse(200);
		$this->assertMime(array('text/javascript', 'application/x-json'));
		$this->assertPattern('/Not all params set/');
	}
/**
  * testRunReturnsTextWithUrlSetAndTextSet
  *
  * Run the test to check if the API returns json when sent a URL
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
	public function testRunReturnsTextWithUrlSetAndTextSet(){
		$url  = "http://www.dave-gill.co.uk";
		$text = "Monkey";
		$this->get("http://local.api/index.php?url=$url&text=$text");
		$this->assertResponse(200);
		$this->assertMime(array('text/javascript', 'application/x-json'));
		$this->assertPattern('/YAY/');
	}

/**
  * testApiWithAddAction
  *
  * Run the test to check if the API adds to the knowledge base
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
	public function testApiWithAddAction(){
		$url    = "http://www.dave-gill.co.uk";
		$text   = "Monkey";
		$action = 'add';
		$class  = 'GameDev';
		$this->get("http://local.api/index.php?url=$url&text=$text&action=$action&class=$class");
		$this->assertResponse(200);
		$this->assertMime(array('text/javascript', 'application/x-json'));
		$this->assertPattern('/Added to Knowledge Base/');
		
	}
}


?>