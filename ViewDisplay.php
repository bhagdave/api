<?php
/**
  * View class for GRABR
  *
  * Just spits out the results in a nice format for JSON.. Yes.
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
class ViewDisplay{
 /**
  * Constructor...
  *
  * Nothing at the moment...
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * 
  *
  * @version 0.1
  */
	function __construct(){
		// nowt much...
	}
	
 /**
  * setHeaders
  *
  * Gets the headers ready 
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  * @param string $callback  The name of the JS function to use if none sent then JSONP = false.
  * 
  */
	private function _setHeaders(){
		// Specify domains from which requests are allowed
		header('Access-Control-Allow-Origin: *');

		// Specify which request methods are allowed
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

		// Additional headers which may be sent along with the CORS request
		// The X-Requested-With header allows jQuery requests to go through
		header('Access-Control-Allow-Headers: X-Requested-With');
	}
	
 /**
  * displayData
  *
  * Lets put something out there baby... 
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  * @param string $callback  The name of the JS function to use if none sent then JSONP = false.
  * @param string $status    The status to be sent back to the user
  * @param string $message   The message to be sent back to the user
  * @param array  $results   The results to be sent back to the user
  * 
  */
	public function displayData($callback = null,$status='OK',$message='',$results = null){
		if (isset($callback)){
			$JSONP = true;	
		} else {
			$JSONP = false;
		}
		$returnData = Array();
		$returnData["Status"]  = $status;
		$returnData["Message"] = $message;
		if (isset($results) && isset($results['links'])){
			$returnData["Links"] = $results['links'];
		} else {
			$returnData["Links"] = null;
		}
		if (isset($results) && isset($results['wiki'])){
			$returnData["Wiki"] = $results['wiki'];
		} else {
			$returnData["Wiki"] = null;
		}
		if (isset($results) && isset($results['class'])){
			$returnData["Class"] = $results['class'];
		} else {
			$returnData["Class"] = null;
		}
		$this->_setHeaders();
		if ($JSONP){
			header('Content-Type: text/javascript');
		} else {
			header('Content-Type: application/x-json');
		}		
		if (isset($callback)){
    		echo $callback . '(' . json_encode($returnData) . ');';
		} else {
			echo json_encode($returnData);
		}		
	}
}

?>