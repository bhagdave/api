<?php
abstract class WikiSearch extends SearchTool{
	
 /**
  * Constructor...
  *
  * Takes the URL and query for the request and adds the api_url
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $query    The query to search for...
  * @param string $url      The url we want to search for...
  *
  * @version 0.1
  */
	function __construct($query,$url){
		parent::__construct($query,$url);
//		$this->api_url = "http://en.wikipedia.org/w/api.php?";
		$this->api_url = "http://www.wikia.com/api.php?";
		
	}
		
}
?>