<?php
require_once('/simpletest/autorun.php');
 /**
  * TESTSearchTools Class for GRABR
  *
  * Does automated testing of the Searchtools classes via simpletest
  * inherits from UnitTestCase
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
	class TestSearchTools extends UnitTestCase{
		private $google;
		private $wiki;
		private $parser;
 /**
  * setUp
  *
  * Setup the framework to run the tests used by simpletest automated testing
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function setUp(){
			$this->google = new GoogleSearch("Monkey","http://runescape.com");
			$this->wiki   = new WikiSearch("Monkey","http://runescape.com");
			$this->parser = new Parser();
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
			unset($this->google);
			unset($this->wiki);
			unset($this->parser);
		}
		
 /**
  * testGoogleSetGetIp
  *
  * Test to see if the getting and setting of IP address works
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function testGoogleSetGetIP(){
			$ip = "192.168.1.1";
			$this->google->setIP($ip);
			$this->assertTrue($this->google->getIP() === $ip);
		}
 /**
  * testGoogleSearch
  *
  * Test to see if the google search returns results
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function testGoogleSearch(){
			$ip = "192.168.1.1";
			$this->google->setIP($ip);
			$this->assertTrue($this->google->doSearch());
		}
		
 /**
  * testParser
  *
  * Test to see if the parser works
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function testGoogleParser(){
			$ip = "192.168.1.1";
			$this->google->setIP($ip);
			$data = $this->google->doSearch();
			$this->assertTrue(strpos(json_encode($this->parser->getGoogleLinks($data)),'http') >= 0);
		}
		/**
  * testWikiSearch
  *
  * Test to see if the getting and setting of text search works
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
		public function testWikiSearch(){
			$this->assertTrue($this->wiki->doSearch());
		}
	}
?>