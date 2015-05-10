<?PHP
/**
 * @package viringo1.0.3.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */


/**
 * Controlador para Myqsl
 *
 * @package viringo1.0.3.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.3.0  24/08/2012
 * @access public
 */

class Class_Db_Mssql implements Class_Interface_DataBase{

	
        
        protected $_nameDataBase;
        protected $_mssql;
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
    
    public function setPrefixDb($prefixDb)
    {

        if (!empty($prefixDb))
            $this->_prefixDb = $prefixDb;
        else
		Class_Error::messageError('prefixDb Not Found in Class_Db_Mssql');

    }
        
  public function connectDataBase($typeUser = null, $nameDataBase = null, $urlServer = null,
        $userDataBase = null, $passwordUserDataBase = null, $portServerDataBase = null)
  {
      
      if($portServerDataBase == null) $portServerDataBase = '1433';
      
	$this->_mssql = Class_Db_Mssql_Mssql::getInstance($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase);
        
        if ($this->_mssql === null)
                Class_Error::messageError('Connection Error or Database Error in Class_Mysql');

        $this->_nameDataBase = $nameDataBase;

  }
####################################################	
 public function getIdConnect()
  {
  	return $this->_mssql;
  }

 ####################################################
 public function executeQuerySelect($sql)
 {
 	if(is_resource($this->_result)) mssql_free_result($this->_result);
	$this->_result = @mssql_query($sql,$this->_mssql);
	
	if(empty($this->_result))
	{
		$stringError.='<br/><b>Error Message: </b>'.mssql_get_last_message();
		$stringError.='<br/><b>SQL: </b>'.$sql;
		Class_Error::messageError($stringError);
	}
		return $this->_result;
	
 }
 ####################################################
 public function exploreArraySelect($result)
 {
 	if(is_resource($result)){
		$tempArray=mssql_fetch_array($result);
		if(isset($tempArray)) return $tempArray;
		}
	return false;
 }
  ####################################################
 public function exploreRowSelect($result)
 {
 	if(is_resource($result)){

		$tempArray=mssql_fetch_row($result);
		if(isset($tempArray)) return $tempArray;
			}
	return false;
 }
 
 ####################################################
  public function executeQueryUpdate($sql)
 {
      if(is_resource($this->_result)) mssql_free_result($this->_result);
	$this->_result  = @mssql_query($sql,$this->_mssql);
	if(empty($result))
	{
		$stringError.='<br/><b>NumberQuery: </b>'.mssql_get_last_message();
		$stringError.='<br/><b>SQL: </b>'.$sql;
		Class_Error::messageError($stringError);
	}
	
		return $this->_result ;
	
 }
  ##########################################
 public function numberRowAffected()
 {
	return 1;

 	if(!empty($this->_mssql))	return mssql_rows_affected($this->_mssql);
	else return 0;

 }
 ##########################################
 public function executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable = NULL, $arrayValueVariable = NULL,  $arrayTypeDataVariable = NULL, $arraySizeDataVariable = NULL, $debugger = FALSE, $die = TRUE)
 {
 	
		//if(is_resource($this->_result)) mssql_free_result($this->_result);

		$stmt = @mssql_init($this->_prefixDb . '_' .$nameStoreProcedure, $this->_mssql); 
		if($stmt)
		{
			if(isset($arraySetVariable) and isset($arrayValueVariable))
			{
				if($debugger == true){
						var_dump($arraySetVariable);
						echo "<br />";
						var_dump($arrayValueVariable);
						echo "<br />";
						var_dump($arrayTypeDataVariable);
						echo "<br />";
						var_dump($arraySizeDataVariable);
						echo "<br />";
					}

				foreach($arraySetVariable as $k => $v)
				{
					//if(!isset($arrayValueVariable[$k])) $arrayValueVariable[$k] = 'null';
					//if(!isset($arraySizeDataVariable[$k])) $arraySizeDataVariable[$k] = 'null';

                                   //echo "mssql_bind($stmt, $v, $arrayValueVariable[$k] , $arrayTypeDataVariable[$k], false, false, $arraySizeDataVariable[$k]);";
					//var_dump($arrayValueVariable[$k]);
					//var_dump($arrayTypeDataVariable[$k]);
					
					

					mssql_bind($stmt, $v, $arrayValueVariable[$k] , $arrayTypeDataVariable[$k], false, false, $arraySizeDataVariable[$k]);	
					
				}
			}
			
				
           		 if($debugger == true){
               		 if ($die == true) die('not execute sp '.$nameStoreProcedure);
				 else echo $nameStoreProcedure.' executed ';
		  		}
	
			$this->_result = @mssql_execute($stmt);
                        mssql_free_statement($stmt);
			return $this->_result;
			}
		else Class_Error::messageError('Do not run stored procedure '.$nameStoreProcedure);
	
 }
 
 ##########################################
 public function executeUpdateStoreProcedure($nameStoreProcedure, $arraySetVariable = NULL, $arrayValueVariable = NULL,  $arrayTypeDataVariable = NULL, $arraySizeDataVariable = NULL, $debugger = FALSE, $die = TRUE)
 {
 		//if(is_resource($this->_result)) mssql_free_result($this->_result);
		
		$stmt = mssql_init($this->_prefixDb . '_' .$nameStoreProcedure, $this->_mssql); 
		if($stmt)
		{
			if(isset($arraySetVariable) and isset($arrayValueVariable))
			{
					if($debugger == true){
						var_dump($arraySetVariable);
						echo "<br />";
						var_dump($arrayValueVariable);
						echo "<br />";
						var_dump($arrayTypeDataVariable);
						echo "<br />";
						var_dump($arraySizeDataVariable);
						echo "<br />";

					}

				foreach($arraySetVariable as $k => $v)
				{
					//if(!isset($arrayValueVariable[$k])) $arrayValueVariable[$k] = 'null';
					//if(!isset($arraySizeDataVariable[$k])) $arraySizeDataVariable[$k] = 'null';

					mssql_bind($stmt, $v, $arrayValueVariable[$k] , $arrayTypeDataVariable[$k], false, false, $arraySizeDataVariable[$k]);	
					
				}
			}
					

			if($debugger == true){
               		 if ($die == true) die('not execute sp '.$nameStoreProcedure);
				 else echo $nameStoreProcedure.' executed ';
		  		}

			$this->_result = mssql_execute($stmt);
			mssql_free_statement($stmt);
			return $this->_result;
		}
		else Class_Error::messageError('Do not run stored procedure '.$nameStoreProcedure);
		
	
 }

######################################################
public function disconnectDataBase()
{
	mssql_close($this->_mssql);
}
 
public function exploreAllArraySelect()
{
    
    	if(is_resource($this->_result)){

	$row = array();
	while($data = @mssql_fetch_array($this->_result)) {
			 $row[] = $data;
		}
	return $row;
	}
	return null;
}

public function exploreAssocSelect($result)
{
    if(is_resource($result)){
	$tempArray=mssql_fetch_assoc($result);
	if(isset($tempArray)) return $tempArray;
   }
	return false;
}

public function numberRows()
{
    if(is_resource($this->_result))
	    return mssql_num_rows($this->_result);
    return null;
}

public function numberCols()
{
   if(is_resource($this->_result))
		 return  mssql_num_fields($this->_result);
	return null;

}

public function getNumberError()
{
	return 0;
}

public function getMessageError()
{
	$msg = mssql_get_last_message();
	if(empty($msg)) $msg = 'Error no determinado';
	return $msg;
}

}

