<?php
/**
  * GoogleSearch
  *
  * Does the business on the GoogleSearch
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
class GoogleSearch extends SearchTool{
	private $api_key  = "AIzaSyD4mu59bdoC0KLvGJVIrj2Bj7da8AKnYsU";
	private $cx       = "008363509140805977024:x14pjtayhn8";
	private $clientIP;
	
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
		$this->api_url = "https://www.googleapis.com/customsearch/v1?";
	}

/**
  * getIPs
  *
  * Get the IP that they are searching from
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return  string IP we are using...
  * @version 0.1
  */
	public function getIP(){
		return $this->clientIP;
	}	

 /**
  * setIPs
  *
  * Set the IP that they are searching from
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param  string IP we are using...
  * @version 0.1
  */
	public function setIP($ip){
		$this->clientIP = $ip;
	}	
	

/**
  * _buildUrl
  *
  * Build the URL up for our Google Search
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return  The URL to send to Google..
  * @version 0.1
  *
  */		
	protected function _buildUrl(){
		// build up URL
		$url = $this->api_url . 'key=' . $this->api_key . '&cx=' . $this->cx . '&q=' . urlencode($this->query) . '&alt=json';
		// add the user ip
		$url .= "&userIp=$this->clientIP";
		// add the search type  of images only..
		$url .= '&searchType=image';
		// add the URL to the search too..
		$url .= '&hq=' . $this->url;
		return $url;
	}

/**
  * doSearch
  *
  * Do the search....
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
	public function doSearch(){
		$search = $this->_buildUrl();
		$results = file_get_contents($search);
		return $results;		
	}

	
/**
  * doSearchForTraining
  *
  * Do the search for Training the Knowledge Base
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @version 0.1
  *
  */		
	public function doSearchForTraining(){
		// build up URL
		$url = $this->api_url . 'key=' . $this->api_key . '&cx=' . $this->cx . '&q=' . urlencode($this->query) . '&alt=json';
		// add the user ip
		$url .= "&userIp=$this->clientIP";
		$results = file_get_contents($url);
		return $results;		
	}

}
?>