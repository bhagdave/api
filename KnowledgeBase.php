<?php

class KnowledgeBase 
{
    protected $_connection;
    /**
     *    Constructor 
     *    
     *    Sets the connection to the DB instance
     *    @access public 
     */
    public function __construct() 
    {
        $this->_connection   = Database::getInstance()->getConnection();
    }
    
    /**
     *    getKnowledgBase
     *    
     *    Returns the entire knowledge base from the db 
     *    
     *    @access public 
     *    @return The knowledg base
     */
    public function getKnowledgeBase()
    {
        $sql = 'SELECT * FROM knowledge_base';
        $result = $this->_connection->query($sql);
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
		return $data;
    }
    
    /**
     *    getDistinctClasses
     *    
     *    Returns a list of classes from the database 
     *    
     *    @access public 
     *    @return Array of the classes in the database
     */
    public function getDistinctClasses(){
    	$sql    = "select distinct belongs from knowledge_base;";
    	$result = $this->_connection->query($sql);
    	$r      = $result->fetchAll(\PDO::FETCH_ASSOC);
  		return $r;
    }
    
    /**
     *    Updates the knowledge base in the database 
     *    
     *    @param $knowledge The memory held knowledge base
     *    @access public 
     */
    public function setKnowledgeBase($knowledge){
    	foreach ($knowledge as $tipo => $v) {
    		foreach($v as $k => $y) {
    			$k = addslashes($k);
        		$sql = "replace knowledge_base values('$k','$tipo','".$y['count']."','".$y['bayesian']."')";
        		$this->_connection->query($sql);
        	}
		}	
    }
    
    /**
     *    Returns the ngrams used in the database 
     *    
     *    @param $ngrams The ngrams we need.
     *    @param $type The class to look for
     *    @access public 
     *    @return the ngrams
     */
    public function getNgrams($ngrams,$type){
    	$info   = array_keys($ngrams);
   	    $sql    = "select ngram,percent from knowledge_base where belongs = '$type' && ngram in ('".implode("','",$info)."')";
   	    $result = $this->_connection->query($sql);
    	$r      = $result->fetchAll(\PDO::FETCH_ASSOC);
    	$t      = null;
    	foreach($r as $row){
        	$t[ $row['ngram'] ]  = $row['percent'];     
    	}
    	return $t;    	
    }
    /**
     *    optimize
     *    
     *    Attempt to rremove the dross from the database 
     *    
     *    @access public 
     */
    public function optimize(){
		$sql = "create temporary table opttable as select ngram, count(*) total, min(percent) as nmin, max(percent) as nmax
				from knowledge_base group by ngram having count(ngram) > 1";
        $this->_connection->query($sql);
		$sql = "delete from knowledge_base where ngram in (select ngram from opttable where (nmax-nmin) < 0.30)"; 
        $this->_connection->query($sql);
    }
}