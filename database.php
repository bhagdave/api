<?php
/**
  * Database Class for GRABR
  *
  * The class has a static instance for the db connection and static call to get the
  * instance.
  *
  *  
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  *
  */

class Database
{
    private static $_instance;
    protected $_connection;
    protected $_config = array(
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '', 
        'dbname'    => 'GRABR',
    );
    
 /**
  * Constructor...
  *
  * Creates the connection to the database
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  * 
  */
    private function __construct()
    {
        $this->_connection = $this->_setupConnection();
    }
    
    
 /**
  * getInstance
  *
  * Returns the instance for the database class
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  * @return a copy of the new dbClass
  */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            $className = __CLASS__;
            self::$_instance = new $className;
        }
        return self::$_instance;
    }
    
 /**
  * getConnection
  *
  * Returns the instance for the db connection
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  * @return a copy of the db connection
  */
    public function getConnection()
    {
        return $this->_connection;
    }
    
 /**
  * _setupConnection
  *
  * Creates the Db Connection
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  */
    protected function _setupConnection()
    {
        try {
            $dsn = "mysql:dbname={$this->_config['dbname']};host={$this->_config['host']}";
            return new \PDO($dsn, $this->_config['username'], $this->_config['password']);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

 /**
  * __Clone
  *
  * Just stop cloning of the db class
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  */
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

 /**
  * __wakeup
  *
  * Dont allow serailzing... Because of the connection
  *
  * @author  Dave Gill <dave_gill@blueyonder.co.uk>
  *
  * @version 0.1
  */
    public function __wakeup()
    {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
}

?>