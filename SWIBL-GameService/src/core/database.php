<?php
namespace swibl\core;

use Exception;
use swibl\core\exception\RecordNotFoundException;

/**
 * 
 * @author Admin
 *
 */
class Database {
	
	var $_connection = null;
	var $_selecteddb = null;
	var $_sql = null;
	var $_offset = 0;
	var $_limit = 0;
	var $_cursor = null;
	var $_prefix = "fs";
	
	function __construct( $options )
	{
		$host		= array_key_exists('host', $options)	? $options['host']		: 'localhost';
		$user		= array_key_exists('user', $options)	? $options['user']		: 'root';
		$password	= array_key_exists('password',$options)	? $options['password']	: '';
		$database	= array_key_exists('database',$options)	? $options['database']	: '';
		$select		= array_key_exists('select', $options)	? $options['select']	: true;
	
		// perform a number of fatality checks, then return gracefully
		if (!function_exists( 'mysqli_connect' )) {
			throw new Exception('The MySQL adapter "mysqli" is not available.');
		}

		// Establish connection and select the database
		$this->connect($host, $database, $user, $password);
	}
	
	
	/**
	 * This funciton return an instance of the database object based on the connection parameters
	 * @param unknown $parms
	 * @return unknown
	 */
	function getInstance($options = array()) {
		
		static $instances;

		if (!isset( $instances )) {
			$instances = array();
		}
	
		$signature = serialize( $options );

		if (empty($instance[$signature])) {
			$instance = new Database($options);
			$instances[$signature] = $instance;
		}
		return $instances[$signature];
	}
	
	/**
	 * this function will establish the connection resource to the database and select the database
	 * @param String $host
	 * @param String $database
	 * @param String $user
	 * @param String $pwd
	 * @throws Exception
	 */
	private function connect($host, $database, $user, $password) {
		try {
			// Establish the connection
		//	if (!($this->_connection = @mysqli_connect($host, $user, $password, NULL, $port, $socket))) {
			if (!($this->_connection = @mysqli_connect($host, $user, $password, null))) {
				echo "CONNECT ERROR: " . mysqli_connect_error();
				throw new Exception("Cound not connect to the MySQL database");
			}			
			// Select the database
			if ( !mysqli_select_db($this->_connection, $database)) {
				throw new Exception(mysqli_error( $this->_connection ));
			}
		} catch (Exception $e) {
			throw $e;		
		}	
	}

	/**
	 * Database object destructor
	 *
	 * @return boolean
	 */
	function __destruct()
	{
		$return = false;
		if (is_resource($this->_connection)) {
			try {
				$return = mysqli_close($this->_connection);
			} catch (Exception $e) {
				throw new Exception(mysqli_error( $this->_connection ));
			}
		}
		return $return;
	}
	
	
	public function setQuery($sql, $offset = 0, $limit = 0) {
		$this->setSql($sql, $offset, $limit);
	}

	/**
	 * This function will set the SQL.
	 */
	public function setSql($sql, $offset = 0, $limit = 0) {
		$this->_sql = $sql;
		$this->_offset = $offset;
		$this->_limit = $limit;
		if ($limit > 0 || $offset > 0) {
			$this->_sql .= ' LIMIT '.$offset.', '.$limit;
		}
	}

	/**
	 * Returns the query string
	 */
	public function getSql() {
		return $this->_sql;
	}
	/**
	 * returns the database cursor
	 * 
	 * @throws Exception
	 * @return unknown
	 */
	public function query($sql = null) {

		if ($sql != null) {
			$this->_sql = $sql;
		}
// 		$this->_sql = str_replace("#_", $this->_prefix,$this->_sql);

		$cur = mysqli_query( $this->_connection, $this->_sql );
		if (!$cur) {
			throw new Exception(mysqli_error( $this->_connection ));
		}
		$this->_cursor = $cur;
		return $this->_cursor;
	}
	
	/**
	 * The the first object of a query
	 *
	 * @access public
	 * @return object
	 */
	function loadObject( )
	{
		try {
			$cur = $this->query();
		} catch (Exception $e) {
			throw $e;
		}		
		$ret = null;
		if ($object = mysqli_fetch_object( $cur )) {
			$ret = $object;
		} else {
            throw new RecordNotFoundException();    
		}
		mysqli_free_result( $cur );
		return $ret;
	}

	function loadRowList() {
		throw new Exception("No mysqli_fetch_row functionality implemented");
		//mysqli_fetch_row
	}
	
	/**
	 * Load a list of database objects
	 *
	 * If <var>key</var> is not empty then the returned array is indexed by the value
	 * the database key.  Returns <var>null</var> if the query fails.
	 *
	 * @access public
	 * @param string The field name of a primary key
	 * @return array If <var>key</var> is empty as sequential list of returned records.
	 */
	function loadObjectList( $idx='' )
	{
		try {
			$cur = $this->query();
		} catch (Exception $e) {
			throw $e;
		}
			
		$array = array();
		while ($row = mysqli_fetch_object( $cur )) {
			if ($idx) {
				$array[$row->$idx] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysqli_free_result( $cur );
		if (count($array) > 0) {
		  return $array;
		} else {
		  throw new RecordNotFoundException();    
		}
		
	}
	
	
	/**
	 * return the id of the last inserted row
	 * @return int
	 */
	function insertid()
	{
		return mysqli_insert_id( $this->_connection );
	}
		
	/**
	 * Returns the number of affected rows
	 */
	function getAffectedRows()
	{
		return mysqli_affected_rows( $this->_connection );
	}
	
	/**
	 * This function will return the number of rows from the most recent query
	 *
	 * @return int 
	 */
	function getNumRows($cursor = null)
	{
		if (!$cursor) {
			return mysqli_num_rows($this->_cursor );
		} else {
			return mysqli_num_rows($cursor );
		}
	}
	
	function setPrefix($prefix) {
		$this->_prefix = $prefix;
	}
	
	function getErrorNum() {
		return (int) $this->_connection->errorno;
	}
	function getErrorMsg() {
		return (string) $this->_connection->error;
//		return (string) mysql_error($this->_connection) . ' SQL=' . $query;
	}
		
}