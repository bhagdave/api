<?php 
/**
  * WikiURLSearch
  *
  * Does the business on the WikiPediaSearch
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
class WikiUrlSearch extends WikiSearch{
	
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
		$query = str_replace('http://','',$this->url);
		$query = str_replace('https://','',$query);
		$query = urlencode($query);
		$params = array(
			"action"=>"query",
			"list"=>"exturlusage",
			"euquery"=>$query,
			"eulimit"=>"30",
			"format"=>"json",
			"eunamespace"=>"0"
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
		curl_close($ch);
		$results = json_decode($results);
		return $results;
	}
	
}
?>