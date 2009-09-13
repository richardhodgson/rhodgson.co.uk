<?php

class Database extends Debug {
	
	var $connection = false;
	
	
	var $host = "";
	var $database = "";
	var $username = "";
	var $password = "";
	
	var $result = "";
	var $lastQuery = "";
	
	var $traceAllSql = false;
	
	
	function getConnectionSettings() {
		
		require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/conf/configuration.class.php');
			
		$configuration = new Configuration();
		
		extract($configuration->getDatabaseConnectionSettings());
		
		$this->host = $host;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
	}
	
	function connect() {
		
		if (!$this->connection) {
		
			$this->getConnectionSettings();
			
			if ($this->connection = @mysql_connect($this->host, $this->username, $this->password)) {
				
				if(@mysql_selectdb($this->database, $this->connection)) {
					
					return true;
				} else {
					
					$this->trace("Could not find database: ('$this->database')");
					
					return false;
				}
			} else {
				
				$this->trace("Could not connect to '$this->host' with username '$this->username'");
				
				return false;
			}
		} else {
			
			return true;
		}
		
	}
	
	function changeSettingsSet($newSettingsSet) {
		
		if ($this->connection) {
			
			//mysql_close($this->connection);
		}
		
		$this->settingsSet = $newSettingsSet;
	}

	function traceError() {

		$this->trace(mysql_error($this->connection));
		
		//$this->trace(mysql_errno($this->connection));
		
		$this->trace($this->lastQuery);
	}

	function prepare($value) {
		
		if (is_array($value)) {
						
			foreach ($value as $item) {
				
				return $this->prepare($item);
			}
			
		} else {
			
			if (get_magic_quotes_gpc()) {
				
				$value = stripslashes($value);
			}
			
			if (!is_numeric($value)) {
				
				$this->connect();
				
				$value = "'" . @mysql_real_escape_string($value, $this->connection) . "'";
			}
			
			return $value;
			
		}
		
	}
	
	
	function q($value) {
		
		if ($this->connect()) {

			$this->lastQuery = $value;

			if ($this->traceAllSql) {

				$this->trace($value);
			}

			if ($this->result = @mysql_query($value, $this->connection)) {

				return true;
			} else {

				$this->traceError();

				return false;
			}

		} else {

			return false;
		}
	}
	
	function fetchRow() {
		
		return @mysql_fetch_assoc($this->result);
	}
	
	function returnedRows() {
		
		//$this->trace(mysql_num_rows($this->result));
		
		//$this->trace($this->result);
		
		if (@mysql_num_rows($this->result)) {
			
			return true;
		} else {
			
			return false;
		}
	}
	
	function affectedRows() {
		
		if (@mysql_affected_rows($this->connection)) {
			
			return true;
		} else {
			
			return false;
		}
	}
	
	function NumberOfRowsInResultSet() {
		
		return @mysql_numrows($this->result);
	}
	
	/*
	Constructs MySQL Insert statement
		
		$valueHash 	- array of values, keys are column names
						e.g  array ("name" => "john")
		$table 		- string of the table name
		
	Automatically adds current datetime stamp to column called `insertedAt`.
	*/
	function insert($valueHash, $table) {
		
		if (is_array($valueHash)) {
			
			$values = $this->prepareValues($valueHash);
			
			$columns = $this->prepareColumns(array_keys($valueHash));
			
			//Date & time stamp
			$columns .= ', `insertedAt`';
			$values .= ', NOW()';
			
			if($this->q("INSERT INTO `$table` ($columns) VALUES ($values)")) {
				
				return true;
			} else {
				
				return false;
			}
			
		} else {
			
			$this->trace("'$valueHash' is not an array.");
			
			return false;
		}
	}
	
	/*
	Constructs MySQL Update statement
	
		$valueHash 	- array of values, keys are column names
						e.g  array ("name" => "jane")
		$table 		- string of table name
		$where		- if array, where clause is generated via keys and values
					  if string where clause is simply added and is NOT
	*/
	function update($valueHash, $table, $where = null) {
		
		$set = $this->prepareSet($valueHash);
		
		$set .= ', `updatedAt` = NOW()';
		
		$sql = "UPDATE `$table` SET $set";
		
		if ($where) {
			
			$whereClause = $this->prepareWhere($where);
			
			$sql .= " WHERE " . $whereClause;
		}
		
		$this->traceAllSql = true;
		
		if ($this->q($sql)) {
			
			return true;
		} else {
			
			return false;
		}
		
	}
	
	function select($columns, $table, $where = null, $orderBy = null, $orderDirection = null, $limit = null, $specialistWhereCondition = false) {
		
		$columns = $this->prepareColumns($columns);
		
		$sql = "SELECT $columns FROM `$table`";
		
		if ($where) {
			
			$whereClause = $this->prepareWhere($where);
			
			$sql .= " WHERE $whereClause";
		}
		
		if ($specialistWhereCondition) {
			
			if ($where) {
				
				$sql .= " " . $specialistWhereCondition;
			} else {
				
				$sql .= " WHERE " . $specialistWhereCondition;
			}
			
			
		}
		
		if ($orderBy) {
			
			$orderByClause = $this->prepareColumns($orderBy);
			
			$sql .= " ORDER BY $orderByClause";
			
			if ($orderDirection) {
				
				$sql .= ' ' . $orderDirection;
			}
		}
		
		if ($limit) {
			
			$limitValue = $this->prepare($limit);
			
			$sql .= " LIMIT $limitValue";
		}
		
		if ($this->q($sql)) {
			
			return true;
		} else {
			
			return false;
		}
	}
	
	function selectAll($table, $where = null, $orderBy = null, $orderDirection = null, $limit = null) {
		
		if ($this->select('*', $table, $where, $orderBy, $orderDirection, $limit)) {
			
			return true;
		} else {
			
			return false;
		}
	}
	
	function prepareValues($array) {
		
		$preparedValues = array();
			
		foreach ($array as $value) {
			
			$preparedValues []= $this->prepare($value);
		}
		
		$values = implode(', ', $preparedValues);
		
		return $values;
		
	}
	
	function prepareColumns($array) {
		
		if ($array == '*') {
			
			return '*';
		
		} elseif (is_array($array)) {
			
			$columns = implode('`, `', $array);
		
			return '`' . $columns . '`';
			
		} else {
			
			if (strtolower($array) == 'rand()') {
				
				return $array;
			} else {
				
				return '`' . $array . '`';
			}
		}
		
	}
	
	
	//Plain text simply returned, key arrays get treated and constructed to sql SET `column` =  'value' combinations
	function prepareSet($array) {
		
		if ($array) {
			
			if (is_array($array)) {
				
				$preparedValues = array();
				
				foreach ($array as $column => $value) {
					
					$preparedValues []= '`' . $column . '` = ' . $this->prepare($value);
				}
				
				return implode(", ", $preparedValues);
				
			} else {
				
				return $array;
			}
			
			
		} else {
			
			$this->trace('No values passed to database::prepareSet()');
		}
	}
	
	function prepareWhere($array) {
		
		if ($array) {
			
			if (is_array($array)) {
				
				$preparedValues = array();
					
				foreach ($array as $key => $value) {
					
					$preparedValues []= '`' . $key . '` = ' . $this->prepare($value);
				}
				
				$values = implode(', ', $preparedValues);
				
				return $values;
				
			} else {
				
				return $array;
			}
			
		} else {
			
			$this->trace('No values passed to database::prepareWhere()');
			
			return false;
		}
	}

	
	
}

?>