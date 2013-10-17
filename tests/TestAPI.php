<?php
require_once('/simpletest/autorun.php');
 /**
  * TESTAPI Class for GRABR
  *
  * Does automated testing of the API class via simpletest
  * inherits from UnitTestCase
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
	class TestAPI extends UnitTestCase {
		private $API;
 /**
  * setUp
  *
  * Setup the frameowrk to run the tests used by simpletest automated testing
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function setUp(){
			$this->API = new API('http://www.dave-gill.co.uk','Flowers');
		}		
		
 /**
  * tearDown
  *
  * Clean up after our tests...
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function tearDown(){
			unset($this->API);
		}
		
 /**
  * testGetSetofUrl
  *
  * Run the test to see if get/set url works
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */	
		public function testGetSetUrl(){
			$url = 'http://www.dave-gill.co.uk';
			$this->API->setUrl($url);
			$this->assertTrue($url === $this->API->getUrl());
		}
 /**
  * testGetSetofText
  *
  * Run the test to see if get/set text works
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function testGetSetText(){
			$text = 'Monkey Games Development';
			$this->API->setText($text);
			$this->assertTrue($text === $this->API->getText());
		}
	}	
?>
