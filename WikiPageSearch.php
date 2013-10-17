<?php
/**
  * WikiPageSearch
  *
  * Does the business on the WikiPediaSearch
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
class WikiPageSearch extends WikiSearch{
	
/**
  * _buildPageUrl
  *
  * Build the URL up for our wiki page Search
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return  The URL to send to Google..
  * @version 0.1
  *
  */		
	protected function _buildUrl(){
		// build up URL
		$page = urlencode($this->query);		
		$params = array(
			"action"=>"query",
			"prop"=>"revisions",
			"rvprop"=>"content",
			"format"=>"json",
			"redirects"=>1,
			"titles"=>$page
		);
		$url = $this->api_url.http_build_query($params,'','&');
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
		$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_URL, $search);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$results = curl_exec($ch);
		$results = json_decode($results);
		curl_close($ch);
		return $results->query->page;
	}
	
}
?>