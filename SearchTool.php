<?php
/**
  * SearchTool - Abstract
  *
  * Abstract class to be used by all of the search tools we use.. This wasy we can extend
  * to use other search methods. All concrete inherited classes must implement _buildUrl and
  * doSearch
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
abstract class SearchTool{
	protected $api_url;
	protected $query;
	protected $url;
	
 /**
  * Constructor...
  *
  * Takes the API URL and query for the request
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $query    The query to search for...
  * @param string $url      The url we want to search for...
  *
  * @version 0.1
  */
	function __construct($query,$url){
		$this->query   = $query;
		$this->url     = $url;
	}
 /**
  * setApiUrl
  *
  * Set the API that we are searching on
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $url      The api to search  
  *
  * @version 0.1
  */
	public function setApiUrl($url){
		$this->api_url = $url;		
	}
 /**
  * getApiUrl
  *
  * Get the API that we are searching on
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return string The api we are calling...
  * @version 0.1
  */
	public function getApiUrl(){
		return $this->api_url;
	}
 /**
  * setUrl
  *
  * Set the URL that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $url      The url we want to search for...
  *
  * @version 0.1
  */
	public function setUrl($url){
		$this->url = $url;		
	}
 /**
  * getUrl
  *
  * Get the URL that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return string The url we want to search for
  * @version 0.1
  */
	public function getUrl(){
		return $this->url;
	}
 /**
  * setQuery
  *
  * Set the Query that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $query    The query to search for...
  *
  * @version 0.1
  */
	public function setQuery($query){
		$this->query = $query;
	}
 /**
  * getQuery
  *
  * Get the Query that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return string The query we are looking for..
  * @version 0.1
  */
	public function getQuery(){
		return $this->query;
	}
	abstract protected function _buildUrl();
	abstract public function doSearch();
}

?>