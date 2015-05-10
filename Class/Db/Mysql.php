<?PHP
/**
 * @package viringo1.0.2.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */


/**
 * Controlador para Myqsl
 *
 * @package viringo1.0.2.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.2.0  11/05/2012
 * @access public
 */
class Class_Db_Mysql implements Class_Interface_DataBase
{

    protected $_nameDataBase;
    protected $_mysqli;
    protected $_countStoreProcedure;
    private $_prefixDb;
    private $_result;
    private $_numberError;
    private $_messageError;

    static $_mysqliUser;
    static $_user;
	
    public function __construct( $prefixDb ) 
    {
	$this->_prefixDb = $prefixDb;
        $this->_countStoreProcedure = 0;
        
    }

    /**
     * Setea el Prefijo de la Base de Datos
     * 
     * @param string $prefixDb
     * @return void
     */
    public function setPrefixDb($prefixDb)
    {

        if (!empty($prefixDb))
            $this->_prefixDb = $prefixDb;
        else
		Class_Error::messageError('prefixDb Not Found in Class_Db_Mysql');

    }

    /**
     * Conecta con BD Mysql
     * 
     * @param string $typeUser
     * @param string $nameDataBase
     * @param string $urlServer
     * @param string $userDataBase
     * @param string $passwordUserDataBase
     * @param string $portServerDataBase 
     * @return void
     */
    public function connectDataBase($typeUser = null, $nameDataBase = null, $urlServer = null,
        $userDataBase = null, $passwordUserDataBase = null, $portServerDataBase = null)
    {
	 if($portServerDataBase == null) $portServerDataBase = '3326';

//         die($urlServer." ". $userDataBase." ". $passwordUserDataBase." ". $nameDataBase." ". $portServerDataBase);
//           if(!is_resource($this->_mysqli))
                        $this->_mysqli = Class_Db_Mysql_Mysqli::getInstance($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase);
//                	$this->_mysqli = new mysqli($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase);
//            else 
//		 	$this->_mysqli->change_user($userDataBase,$passwordUserDataBase, $nameDataBase);

//           Class_Debug::pointRun($this->_mysqli); 
            
            if ($this->_mysqli === null)
                Class_Error::messageError('Connection Error or Database Error in Class_Mysql');

            $this->_nameDataBase = $nameDataBase;
            
   }
   
   public function getLink()
   {
       return $this->_mysqli;
   }
    
	public function realEscapeString($string)
	{
		return $this->_mysqli->real_escape_string($string);
	}

    /**
     * Retorna todo el arreglo del resultado de la Consulta
     *
     * @return array
     */
    public function exploreAllArraySelect()
	{
	if(isset($this->_result)){
		$row = array();
		while($data = $this->_result->fetch_array()) {
			 $row[] = $data;
			}
		return $row;
		}
	return false;
	}	

    /**
     * Retorna 1 Registro del tipo Array Asociativo
     * 
     * @param object $result
     * @return array
     */
    public function exploreArraySelect($result)
    {
     if(isset($result) && get_class($result) == 'mysqli_result'){
	$tempArray = $result->fetch_array();
        if (empty($tempArray))
            return false;
        return $tempArray;
	}
	return false;
    }
    
    /**
     * Retorna 1 Registro del tipo Array
     * 
     * @param object $result
     * @return array
     */
    public function exploreRowSelect($result)
    {
       if(isset($result) && get_class($result) == 'mysqli_result'){
 		$tempArray = $result->fetch_row();
        if (empty($tempArray))
            return false;
        return $tempArray;
	}
	return false;
    }
    
    /**
     * Retorna 1 Registro del tipo Array Asociativo
     * 
     * @param object $result
     * @return array
     */
    public function exploreAssocSelect($result)
    {
	if(isset($result) && get_class($result) == 'mysqli_result'){

        $tempArray = $result->fetch_assoc();
        if (empty($tempArray))
            return false;
        return $tempArray;
	}
	return false;

    }
   
    /**
     * Ejecuta una Consulta SQL del tipo SELECT
     * 
     * @param string $sql
     * @param integer $namePage
     * @param integer $numberQuery
     * @return mixed array
     */
    public function executeQuerySelect($sql)
    {
	      if ($this->_countStoreProcedure > 0 && $this->_mysqli->more_results()){
                $this->_mysqli->next_result();
            }
            $this->_countStoreProcedure++;


            $this->_result = $this->_mysqli->query($sql);

            if (empty($this->_result))
            {
		
                $numberError = $this->_mysqli->errno;
                $stringError = 'Error Query';
		  $stringError .= '<br/><b>SQL:</b>' . $sql;
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_mysqli->error;
                
                
                if($numberError == '1451' || $numberError == '1452' || $numberError == '1048'){
                    $messageError = Class_Db_Mysql_Language::get($numberError);
                    $this->_setMessageError($messageError);
                    $this->_setNumberError($numberError);
                    Class_Error::messageError($stringError, Class_Error::E_LOG);
                }
                else{
                    Class_Error::messageError($stringError);
                }
            }
            
             return $this->_result;
    }

    /**
     * Ejecuta una Consulta SQL del tipo INSERT, UPDATE o DELETE
     * 
     * @param string $sql
     * @param integer $namePage
     * @param integer $numberQuery
     * @return mixed array
     */
    public function executeQueryUpdate($sql)
    {
            	if ($this->_countStoreProcedure > 0 && $this->_mysqli->more_results()){
                $this->_mysqli->next_result();
            }
            $this->_countStoreProcedure++;


		$this->_result = $this->_mysqli->query($sql);

            if (empty($this->_result))
            {
		
                $numberError = $this->_mysqli->errno;
                $stringError = 'Error Query';
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_mysqli->error;
                $stringError .= '<br/><b>SQL:</b>' . $sql;
                
                if($numberError == '1451' || $numberError == '1452' || $numberError == '1048'){
                    $messageError = Class_Db_Mysql_Language::get($numberError);
                    $this->_setMessageError($messageError);
                    $this->_setNumberError($numberError);
                    Class_Error::messageError($stringError, Class_Error::E_LOG);
                }
                else{
                    Class_Error::messageError($stringError);
                }
            }
            
           
             return $this->_result;
    }

    
    /**
     * Retorna el numero de filas afectadas en un INSERT, UPDATE o DELETE
     * 
     * @return integer
     */
    public function numberRowAffected()
    {
        return $this->_mysqli->affected_rows;
    }
    
    
    /**
     * Retorna el numero de filas obtenidas en un SELECT
     * 
     * @return integer
     */
    public function numberRows()
    {
        	if(is_object($this->_result))
			return $this->_result->num_rows;
		return null;
    }

    /**
     * Retorna el numero de columnas obtenidas en un SELECT
     * 
     * @return integer
     */
    public function numberCols()
    {
        return $this->_result->field_count;
    }
    

    /**
     * Ejecuta un Procedimiento Almacenado del tipo SELECT
     * 
     * @param string $nameStoreProcedure
     * @param mixed $arraySetVariable
     * @param mixed $arrayValueVariable
     * @param mixed $arrayTypeDataVariable
     * @param mixed $arraySizeDataVariable
     * @param bool $debugger
     * @param bool $die
     * @return mixed array
     */
    public function executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable = null, $arrayValueVariable = null, $arrayTypeDataVariable = null, $arraySizeDataVariable = null, $debugger = false, $die = true)
    {
	
            $sql = 'CALL ' . $this->_nameDataBase . '.' . $this->_prefixDb . '_' . $nameStoreProcedure .
                '(';
	     $sqlTemp = $sql;
		
            if (isset($arrayValueVariable))
            {

                foreach ($arrayValueVariable as $k => $v)
                {
                    if ($arrayTypeDataVariable[$k] === Class_Object::DATA_STRING or $arrayTypeDataVariable[$k] === Class_Object::DATA_DATE
                            or $arrayTypeDataVariable[$k] === Class_Object::DATA_EMAIL or $arrayTypeDataVariable[$k] === Class_Object::DATA_NAME){
                            if(isset($v)) $sql .= "'" . $v . "',";
                            else $sql .= "NULL,";
                        }
                    else{
				if(!isset($v)) $v = 'null';
				$sql .= $v . ',';
			   }
                }
		  
		  $lenTemp = strlen($sqlTemp);
		  if(strlen($sql) > strlen($sqlTemp))
                	$sql = substr($sql, 0, (strlen($sql) - 1));
            }

            $sql .= ')';
		
            if ($debugger == true)
            {
                if ($die == true) die($sql);
		  else echo $sql;
            }
//            Class_Debug::pointRun($this->_countStoreProcedure);
//            Class_Debug::pointRun($sql);

            if ($this->_countStoreProcedure > 0 && $this->_mysqli->more_results()){
                $this->_mysqli->next_result();
            }
            $this->_countStoreProcedure++;
            
            $this->_result = $this->_mysqli->query($sql);
            
            if (empty($this->_result))
            {
                $stringError = '<br/>Error Query in Class Mysql';
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_mysqli->error;
                $stringError .= '<br/><b>SQL:</b>' . $sql;
                Class_Error::messageError($stringError);
                
                $numberError = $this->_mysqli->errno;
                $stringError = 'Error Query';
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_mysqli->error;
                $stringError .= '<br/><b>SQL:</b>' . $sql;
                
                if($numberError == '1451' || $numberError == '1452' || $numberError == '1048'){
                    $messageError = Class_Db_Mysql_Language::get($numberError);
                    $this->_setMessageError($messageError);
                    $this->_setNumberError($numberError);
                    Class_Error::messageError($stringError, Class_Error::E_LOG);
                }
                else{
                    Class_Error::messageError($stringError);
                }
                
            }

            return $this->_result;

    }
    
    
    /**
     * Ejecuta un Procedimiento Almacenado del tipo INSERT, UPDATE o DELETE
     * 
     * @param string $nameStoreProcedure
     * @param mixed $arraySetVariable
     * @param mixed $arrayValueVariable
     * @param mixed $arrayTypeDataVariable
     * @param mixed $arraySizeDataVariable
     * @param bool $debugger
     * @param bool $die
     * @return mixed array
     */
    public function executeUpdateStoreProcedure($nameStoreProcedure, $arraySetVariable = null,
        $arrayValueVariable = null, $arrayTypeDataVariable = null, $arraySizeDataVariable = null,
        $debugger = false, $die = true)
    {
       
            $sql = 'CALL ' . $this->_nameDataBase . '.' . $this->_prefixDb . '_' . $nameStoreProcedure .
                '(';
	     $sqlTemp = $sql;
            if (isset($arrayValueVariable))
            {

                foreach ($arrayValueVariable as $k => $v)
                {

                    //$v = Class_App::aUtf8($v);

                    if ($arrayTypeDataVariable[$k] === Class_Object::DATA_STRING or $arrayTypeDataVariable[$k] === Class_Object::DATA_DATE 
                            or $arrayTypeDataVariable[$k] === Class_Object::DATA_EMAIL or $arrayTypeDataVariable[$k] === Class_Object::DATA_NAME){

                            if(isset($v)) $sql .= "'" . $v . "',";
                            else $sql .= "NULL,";
				//real_scape_string
                            }
                        
                    else{
			     if(!isset($v)) $v = 'null';
			     $sql .= $v . ',';
			   }


                }
		  $lenTemp = strlen($sqlTemp);
                  $lenSql  = strlen($sql);
		  if($lenSql > $lenTemp)
                	$sql = substr($sql, 0, ($lenSql - 1)); //para quitarle la ultima coma
            }

            $sql .= ')';

            if ($debugger == true)
            {
                if ($die == true)
                {
                    die($sql);
                    exit(0);
                } else
                    echo $sql;
            }

	   
		// echo $this->_countStoreProcedure;
            if ($this->_countStoreProcedure > 0 && $this->_mysqli->more_results()){
                $this->_mysqli->next_result();
            }
            $this->_countStoreProcedure++;
                    
            $this->_result = $this->_mysqli->query($sql); 
            
//            Class_Debug::pointRun($this->_result);
			
            if (empty($this->_result))
            {
		
                $numberError = $this->_mysqli->errno;
                $stringError = 'Error Query';
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_mysqli->error;
                $stringError .= '<br/><b>SQL:</b>' . $sql;
                
                if($numberError == '1451' || $numberError == '1452' || $numberError == '1048'){
                    $messageError = Class_Db_Mysql_Language::get($numberError);
                    $this->_setMessageError($messageError);
                    $this->_setNumberError($numberError);
                    Class_Error::messageError($stringError, Class_Error::E_LOG);
                }
                else{
                    Class_Error::messageError($stringError);
                }
            }
            return $this->_result;
        


    }

    /**
     * Retorna el Numero de Error de la petición
     * 
     * @return string 
     */
    public function getNumberError()
    {
        return $this->_numberError;
    }
    
    /**
     * Retorna el Message de Error de la petición
     *  
     * @return string
     */
    public function getMessageError()
    {
        return $this->_messageError;
    }
    
    
    private function _setNumberError($numberError)
    {
        $this->_numberError = $numberError;
    }
    
    private function _setMessageError($messageError)
    {
        $this->_messageError = $messageError;
    }
    
    /**
     * Desconecta del Mysql
     * 
     * @return void
     */
    public function disconnectDataBase()
    {
        if ($this->_mysqli != null)
            $this->_mysqli->close();
    }

}