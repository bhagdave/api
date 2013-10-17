<?php
class Exclusions{
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
     *    getFunctions
     *    
     *    Get a list of functions 
     *    @access public
     *    @return A result object if a list of functions found
     *            or ALL if no limitations found
     *            or NONE if domain found and no functions 
     */
    public function getFunctions($host){
    	$host = $this->_connection->quote($host);
        $sql  = "SELECT `id` FROM `exclusions` WHERE `domain` = $host";
        $result = $this->_connection->query($sql);
        if ($result){
        	// we have an id lets get all of the functions for it
        	$data   = $result->fetch(\PDO::FETCH_OBJ);
        	if ($data){
				$id     = $data->id;
				$sql    = "SELECT `functions` FROM `functions` WHERE `exclusion_id` = $id";
        		$result = $this->_connection->query($sql);
        		if ($result){
					return $result; 	
        		} else {
        			return "NONE";
        		}
        	} else {
        		return "ALL";
        	}
        } else {
        	return 'ALL';
        }
    }
	
}