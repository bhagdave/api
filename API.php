<?php
/**
  * API Class for GRABR
  *
  * The API takes the args for the call and does the searching, filtering
  * and categorisation of the request
  *
  * The API just needs to be initialised with the params of the call.
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */

class API{
	private $url;
	private $text;
	private $callback;
	private $trainer;
	private $data = Array();
	private $ipAddr;

 /**
  * Constructor...
  *
  * Takes the URL and Text for the request
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $url      The page the link is coming from... 
  * @param string $text     The text to go with the search
  * @param string $callback The Callback function name for JSONP
  *
  * @version 0.1
  * @version 0.2
  * DG - Added callback param to the constructor so we know if JSONP or not
  * @version 0.3
  * DG - Added the new trainer class.
  */
	function __construct($url,$text,$callback = null){
		$this->url      = $url;
		$this->text     = $text;
		$this->callback = $callback;
		$this->trainer  = new Trainer();
	}

 /**
  * getUrl
  *
  * Get the URL that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  */
	public function getURL(){
		return $this->url;
	}

/**
  * setUrl
  *
  * set the URL that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  * @param string $url  The page the link is coming from... 
  */
	public function setURL($url){
		$this->url = $url;
	}

/**
  * setText
  *
  * set the text that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param string $text The text to go with the search
  *
  * @version 0.1
  */
	public function setText($text){
		$this->text = $text;
	}
	
 /**
  * getText
  *
  * Get the TEXT that we are searching for
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @return  string Text we are searching for
  * @version 0.1
  */
	public function getText(){
		return $this->text;
	}
	
 /**
  * AddForTraining
  *
  * Trains the Knowledge Base
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param  string $text  The text to train on
  * @param  string $class The class to attach the text to.
  * @return boolean       Success or Failure
  * @api
  *
  * @version 0.1
  *   
  */
	public function addForTraining($text,$class){
		$view = new ViewDisplay();
		try {
			// get previous learning
			$kb = new KnowledgeBase();
			// set the previous learning
			$previous = $kb->getKnowledgeBase();
			$previous = Parser::extractPreviousLearning($previous);
			$this->trainer->setPreviousLearn($previous);
			// add to the trainer
			$this->trainer->add_example($text,$class);
			$this->trainer->extractPatterns();
			// save the training
			$kb->setKnowledgeBase($this->trainer->knowledge);
			// optimize the database.
			$kb->optimize();
			$view->displayData($this->callback,'OK','Added to Knowledge Base',null);
		} catch (Exception $e){
			$view->displayData($this->callback,'ERR','Failed to add to Knowledge Base',null);
		}
	}		
	
 /**
  * Run
  *
  * Does the business in terms of creating the response back
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param  string $ipaddr Address being run from
  * @return mixed  The data being sent back....
  * @api
  *
  * @version 0.1
  * 
  * @version 0.2
  * DG - Call the google search and then just display the data
  * @version 0.3
  * Added the ipaddr parameter to get round the google quota limit
  * @version 0.4
  * Add the display to send the data out there...
  * @version 0.5
  * Added code to split the URL up.
  */
	public function run($ipaddr){
		$this->ipAddr = $ipaddr;
		$view = new ViewDisplay();
		// check we have both params... else bug out
		if ($this->text != '' && $this->url != ''){
			$this->CallMethods();
			$view->displayData($this->callback,'OK','YAY',$this->data);
		} else {
			$view->displayData($this->callback,'ERR','Not all params set..');
		}
	}

 /**
  * _getDomain
  *
  * Split the URL into hostname
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param  string $url The url sent to us.
  * @return string the domain name 
  */	
	private function _getDomain($url){
		return parse_url($url,PHP_URL_HOST);
	}
	
 /**
  * _getFunctions
  *
  * Get a list of functions for a given domain
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param  string $url The url sent to us.
  * @return array functions to call or Null is none. 
  */	
	private function _getFunctions($url){
		$host       = $this->_getDomain($url);
		$exclusions = new Exclusions();
		$functions  = $exclusions->getFunctions($host);
		return $functions;
	}

 /**
  * GoogleSearch
  *
  * Do the GoogleSearch
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  */	
	private function GoogleSearch(){
		$google = new GoogleSearch($this->text,$this->url);
		$google->setIP($this->ipAddr);
		$result = $google->doSearch();
		$this->data['links'] = Parser::getGoogleLinks($result);
	}
 /**
  * WikiSearch
  *
  * Do the WikiSearch
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  */	
	private function WikiSearch(){
		$wiki = new WikiUrlSearch($this->text,$this->url);
		$this->data['wiki']  = $wiki->doSearch();
	}
	
 /**
  * Classifier
  *
  * Do the Classification
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  */	
	private function Classifier(){
		$classifier = new Classifier();		
		$this->data['class'] = $classifier->getProbableClass($this->text . $this->url);
	}
	
 /**
  * Call the required methods.
  *
  * Call the methods specified in the database
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  */	
	private function CallMethods(){
		// check the url and get functions
		// create an array for the functions to go in
 		$functions = array('GoogleSearch','WikiSearch','Classifier');
		// Get the functions from the database
		$fList = $this->_getFunctions($this->url);
		// check if it comes back with an array or not...
		if (is_array($fList)){
			foreach($fList as $function){
				$functions[] = $function['function'];
			}
		} else {
			if ($fList === 'NONE'){
				$view->displayData($this->callback,'ERR','No functions set for this domain,');
				die;
			} 
		}
		// Call each method...
		foreach($functions as $method){
			try {
				echo ($this->$method());	
			} catch (Exception $e) {
				$view->displayData($this->callback,'ERR',"Exception when calling:$method");
				die;
			}
		}
	}
	
	
}

?>