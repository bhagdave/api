<?php
/**
  * Parsing class for GRABR
  *
  * Takes the raw output and puts into something readable.... The class is
  * just used for its functions so uses statics.. 
  * 
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */
	class Parser{
 /**
  * getGoogleLinks
  *
  * Returns the google data in an array of links
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param   mixed $data Raw JSON array from Google...
  * @return  An array of links
  * @version 0.1
  */
		public static function getGoogleLinks($data){
			// decode to an object..
			$decodedData = json_decode($data);
			// extract the links...
			foreach ($decodedData->items as $item){
				$links[] = $item->link;
			}
			return $links;
		}

 /**
  * extractPreviousLearning
  *
  * Returns the knowledge base as an array ready for the trainer
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  * @param   mixed $data Raw JSON array from Google...
  * @return  An array of links
  * @version 0.1
  */
		public static function extractPreviousLearning($data){
			$previousLearn = array();
			foreach ($data as $row){
    			$previousLearn[$row['belongs']][$row['ngram']] = $row['repite'];
			}
			return $previousLearn;
		} 
	}
?>
