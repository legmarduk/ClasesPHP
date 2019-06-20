<?php

class DB {
    public $con;
	public $lastQuery;
	private $_debug;
	private $_HOST	 = '31.220.52.124';
	private $_USER	 = 'ctrlmat_dev';
	private $_PASS	 = '5a7a592d';
	private $_DB	 = 'ctrlmat_dev';

    /**
     * The purpose of this method is to hide sensitive data from stack traces.
     *
     * @return array
     */
    public function __debugInfo()
    {
		$properties = get_object_vars($this);
		unset($properties['_HOST']);		
		unset($properties['_USER']);
		unset($properties['_PASS']);
		unset($properties['_DB']);
        return $properties;
    }
	
	public function __construct() {		
	}
	
	private function connect(){
		$this->con = mysqli_connect($this->_HOST, $this->_USER, $this->_PASS, $this->_DB);

		if (!$this->con) {
			throw new Exception("DB CONECTION ERROR ".mysqli_connect_error(), 0);	
			return false;
		}
		mysqli_set_charset($this->con, 'utf8');  // linea a eliminar en caso de cambiar a otra solucion para insertar
		return true;
	}
	
	public function setDebug($newDebug){
		$this->_debug = ($newDebug===true)?true:false;
	}
	
	


	public function close(){
		mysqli_close($this->con);
	}

	public function select($query){
		//Sanitizar query
		$this->connect();
		$this->lastQuery = $query;
		
		$ret = [];
		if ($result=mysqli_query($this->con,$this->lastQuery)){			
			while ($obj=mysqli_fetch_object($result)){
				$ret[] = $obj;
			}
			mysqli_free_result($result);
			$this->close();
		}else{
			if($this->_debug){
				throw new Exception("SELECT ERROR: ".$this->con->error, 0);			
			}else{
				return [];
			}			
		}
		return $ret;
	}
	
	public function update($table,$fields,$where){
		// como esta en comillas dobles se generan errores de insercion cuando se cargan archivos que contienen texto con doble comilla

		$query =  "UPDATE `{$table}` SET ";
		foreach($fields as $k=>$v){
			$query .= "`{$k}` = '{$v}',";
		}
		$query = substr($query,0,-1);
		$query .= " WHERE {$where}";
		
		$this->lastQuery = $query;
		$this->connect();
		if ($result=mysqli_query($this->con,$this->lastQuery)){
			// Free result set
			$afectedRows = mysqli_affected_rows($this->con);			
			$this->close();
			return $afectedRows;
		}else{
			if($this->_debug){
				throw new Exception("SELECT ERROR: ".$this->con->error, 0);			
			}else{
				return 0;
			}
		}
		return 0;
	}
	
	public function insert($table,$fields){
		$query =  "INSERT INTO `{$table}` ";
		
		$fieldsName = [];
		$values = [];
		foreach($fields as $k=>$v){
			$fieldsName[] = $k;
			$values[] = $v;
		}
		$query .= "(";
		foreach($fieldsName as $k=>$v){			
			$query .= "`{$v}`,";		
		}
		$query = substr($query,0,-1);
		$query .= ") VALUES (";
		foreach($values as $k=>$v){			
			$query .= ( is_null($v) )?"NULL,":"\"{$v}\",";
		}
		$query = substr($query,0,-1);
		$query .= ");";

		$this->lastQuery = $query;
		$this->connect();
		if ($result=mysqli_query($this->con,$this->lastQuery)){
			$lastID = mysqli_insert_id($this->con);
			$this->close();
			return $lastID;
		}else{
			echo "error description:".mysqli_error($this->con);
			if($this->_debug){
				throw new Exception("SELECT ERROR: ".$this->con->error, 0);			
			}else{
				return 0;
			}
		}
		return 0;
	}

/**************** REVISAR  ********************/
	public function delete($table, $where){
		$query = "DELETE FROM `{$table}`WHERE {$where}";
		$this->lastQuery = $query;
		$this->connect();
		if ($result=mysqli_query($this->con,$this->lastQuery)){
			$lastID = mysqli_insert_id($this->con);
			$this->close();
			return $lastID;
		}else{
			echo "error description:".mysqli_error($this->con);
			if($this->_debug){
				throw new Exception("SELECT ERROR: ".$this->con->error, 0);			
			}else{
				return 0;
			}
		}
		return 0;
	}
}

?>