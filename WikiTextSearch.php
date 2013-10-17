<?php
/**
  * WikiTextSearch
  *
  * Does the business on the WikiPediaSearch
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
class WikiTextSearch extends WikiSearch{
	
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
		$text = urlencode($this->query);
		$params = array(
			"action"=>"query",
			"list"=>"search",
			"srwhat"=>"text",
			"format"=>"json",
			"srsearch"=>$text
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
		// split the search term up...
		$words = explode(' ',$search);
		$max = 0;
		$select = 0;
		// loop through the search results and see if any are relevant
		for ($i=0;$i<count($results->query->search);$i++){
			$count = 0;
			for($j=0;$j<count($words);$j++){
				if (strpos($results->query->search[$i]->snippet,$words[$j])){
					$count++;
				}
			}
			if ($count >= $max){
				$select = $i;
				$max = $count;
			}
		}
		return $results->query->search[$select]->snippet;
	}
	
}
?>