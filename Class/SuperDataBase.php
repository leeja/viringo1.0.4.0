<?PHP
/**
 * @package viringo1.0.2.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones de Base de Datos
 *
 * @package viringo1.0.2.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.2.0  11/05/2012
 * @access public
 */
class Class_SuperDataBase
{

    /**
     * Objeto Base de Datos
     * @var object
     */
    private $_dataBase;

    /**
     * Nombre de la Base de Datos
     * @var string
     */
    private $_nameDataBase;


    /**
     * Método Constructor, inicializa variables.
     * 
     * @param integer $typeUser (Class_Interface_DataBase::ROOT , Class_Interface_DataBase::SELECT, Class_Interface_DataBase::INSERT, Class_Interface_DataBase::UPDATE, Class_Interface_DataBase::DELETE )
     * @param string $nameDataBase Nombre de la Base de dAtos
     * @param string $urlServer Host del Server
     * @param string $userDataBase Usuario de Conexión
     * @param string $passwordUserDataBase Password del Usuario de Conexión
     * @return void
     */
    public function __construct($typeUser = null, $nameDataBase = null, $urlServer = null,
        $userDataBase = null, $passwordUserDataBase = null, $portServerDataBase = null, $typeDataBase = null)
    {
        
	if($typeUser === null) $typeUser = Class_Interface_DataBase::USERROOT;
        if($nameDataBase === null) $nameDataBase = Class_Config::get('prefixDb'). '_db';
        if($urlServer === null)  $urlServer = Class_Config::get('urlServerDataBase');
        if($portServerDataBase == null)  $portServerDataBase = Class_Config::get('portServerDataBase');
        if($typeDataBase === null) $typeDataBase = Class_Config::get('typeDataBase');
        
        $tempClass = 'Class_Db_' . $typeDataBase;
        $this->_nameDataBase = $nameDataBase;
        $tempPrefixDb = Class_Config::get('prefixDb');
//die($tempPrefixDb );
        
              
        if (Class_Config::get('multipleUserDataBase') && $userDataBase == null &&  $passwordUserDataBase == null)
            {
                switch ($typeUser)
                {
                    case Class_Interface_DataBase::USERROOT:
                        if(!Class_Config::exists('userRootDataBase'))  $userDataBase = $tempPrefixDb . '_r';
                        else $userDataBase = Class_Config::exists('userRootDataBase');
                        $passwordUserDataBase = Class_Config::get('passwordUserDataBase');
                        break;
                    case Class_Interface_DataBase::USERSELECT:
                       if(!Class_Config::exists('userSelectDataBase'))  $userDataBase = $tempPrefixDb . '_s';
                        else $userDataBase = Class_Config::exists('userSelectDataBase');
                        $passwordUserDataBase = Class_Config::get('passSelectDataBase');
                        break;
                    case Class_Interface_DataBase::USERINSERT:
                        if(!Class_Config::exists('userInsertDataBase'))  $userDataBase = $tempPrefixDb . '_i';
                        else $userDataBase = Class_Config::exists('userInsertDataBase');
                        $passwordUserDataBase = Class_Config::get('passInsertDataBase');
                        break;
                    case Class_Interface_DataBase::USERUPDATE:
                        if(!Class_Config::exists('userUpdateDataBase'))  $userDataBase = $tempPrefixDb . '_u';
                        else $userDataBase = Class_Config::exists('userUpdateDataBase');
                        $passwordUserDataBase = Class_Config::get('passUpdateDataBase');
                        break;
                    case Class_Interface_DataBase::USERDELETE:
                        if(!Class_Config::exists('userDeleteDataBase'))  $userDataBase = $tempPrefixDb . '_d';
                        else $userDataBase = Class_Config::exists('userDeleteDataBase');
                        $passwordUserDataBase = Class_Config::get('passDeleteDataBase');
                        break;
                    default:
                        Class_Error::messageError('No exits User Data Base in Class_Mysql');
                }
            } 
            else{
            	 if($userDataBase === null){
			
                     if(!Class_Config::exists('userRootDataBase')) $userDataBase = $tempPrefixDb.'_r';
                     elseif( Class_Config::get('userRootDataBase') == '') $userDataBase = $tempPrefixDb.'_r';
			else $userDataBase = Class_Config::get('userRootDataBase');
                 }
		 if($passwordUserDataBase === null){
                     $passwordUserDataBase = Class_Config::get('passwordUserDataBase');
                 }
            }
	//echo($typeUser." ".$nameDataBase." ".$urlServer." ".$userDataBase." ".$passwordUserDataBase." ".$portServerDataBase." ".$typeDataBase."<br />");

       $this->_dataBase = Class_Db_Factory::getConnection($tempClass, $this->_nameDataBase, $userDataBase);
       $this->setPrefixDb($tempPrefixDb);
//       $this->_dataBase = Class_Db_Factory::factoryDataBase($tempClass, $tempPrefixDb);   

       $this->_dataBase->connectDataBase($typeUser, $this->_nameDataBase, $urlServer, $userDataBase,
                    $passwordUserDataBase, $portServerDataBase );

            
    }
    
    public function getLink()
    {
        return $this->_dataBase->getLink();
    }
    
    public function realEscapeString($string)
	{

	return $this->_dataBase->realEscapeString($string);

	}

    
    public function setPrefixDb($prefixDb)
    {
        return $this->_dataBase->setPrefixDb($prefixDb);
    }
    
    /**
     * Ejecuta Procedimientos Almacenados para Consultas.
     * 
     * @param string $nameStoreProcedure Nombre Procedimientos Almacenados
     * @param array $arraySetVariable Arreglo de variables
     * @param array $arrayValueVariable Arreglo de valores de las variables 
     * @param array $arrayTypeDataVariable Arreglo del tipo de datos de las variables
     * @param array $arraySizeDataVariable Arreglo del tamaño de datos de las variables
     * @param bool $debugger true = no ejecuta el Procedimiento, lo muestra en pantalla
     * @param bool $die true = mata el aplicativo si $debugger es true
     * @return array
     */
    public function executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable = null,
        $arrayValueVariable = null, $arrayTypeDataVariable = null, $arraySizeDataVariable = null,
        $debugger = false, $die = true)
    {
        return $this->_dataBase->executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable, $debugger,
            $die);

    }
    
    /**
     * Ejecuta Procedimientos Almacenados para Actualizaciones.
     * 
     * @param string $nameStoreProcedure Nombre Procedimientos Almacenados
     * @param array $arraySetVariable Arreglo de variables
     * @param array $arrayValueVariable Arreglo de valores de las variables 
     * @param array $arrayTypeDataVariable Arreglo del tipo de datos de las variables
     * @param array $arraySizeDataVariable Arreglo del tamaño de datos de las variables
     * @param bool $debugger true = no ejecuta el Procedimiento, lo muestra en pantalla
     * @param bool $die true = mata el aplicativo si $debugger es true
     * @return bool
     */
    public function executeUpdateStoreProcedure($nameStoreProcedure, $arraySetVariable = null,
        $arrayValueVariable = null, $arrayTypeDataVariable = null, $arraySizeDataVariable = null,
        $debugger = false, $die = true)
    {
        return $this->_dataBase->executeUpdateStoreProcedure($nameStoreProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable, $debugger,
            $die);

    }
    
    /**
     * Ejecuta SQL para consultas.
     * 
     * @param string $sql
     * @return array
     */
    public function executeQuerySelect($sql)
    {
        return $this->_dataBase->executeQuerySelect($sql);
    }
    
    
    /**
     * Explora Array de resultados.
     * 
     * @param array $result
     * @return array
     */
    public function exploreArraySelect($result)
    {
        return $this->_dataBase->exploreArraySelect($result);
    }
    
    /**
    * Retorna todo un Array de Resultados
    *
    * @return array
    */
   public function exploreAllArraySelect()
    {
        return $this->_dataBase->exploreAllArraySelect();
    }
	

    /**
     * Explora Array de resultados.
     * 
     * @param array $result
     * @return array asociativo
     */
    public function exploreAssocSelect($result)
    {
        return $this->_dataBase->exploreAssocSelect($result);
    }
    
     /**
     * Explora Array de resultados.
     * 
     * @param array $result
     * @return array por indice
     */
    public function exploreRowSelect($result)
    {
        return $this->_dataBase->exploreRowSelect($result);
    }
    
    
    /**
     * Retorna el nombre de la Base de datos.
     * 
     * @return string
     */
    public function getNameDataBase()
    {
            return $this->_nameDataBase;
    }
    
    /**
     * Ejecuta SQL para actualizaciones.
     * 
     * @param string $sql
     * @return integer
     */
    public function executeQueryUpdate($sql)
    {
        return $this->_dataBase->executeQueryUpdate($sql);
    }
    
    /**
     * Obtiene el número de filas afectadas en una actualización
     * 
     * @return integer
     */
    public function numberRowAffected()
    {
        return $this->_dataBase->numberRowAffected();
    }
    
    
    /**
     * Obtiene el número de filas de un select
     * 
     * @return integer
     */
    public function numberRows()
    {
        return $this->_dataBase->numberRows();
    }

	/**
     * Obtiene el número de columnas de un select
     * 
     * @return integer
     */
    public function numberCols()
    {
        return $this->_dataBase->numberCols();
    }
    

    /**
     * Desconecta de la Base de datos
     * 
     * @return void
     */
    public function disconnectDataBase()
    {
//        $this->_dataBase->disconnectDataBase();
    }

    
    /**
     * Convierte un nombre de variable a nombre de parametro para Base de Datos
     * 
     * @param string $name
     * @return string InName
     */
    public function getVarSQL($name)
    {

        $temp = "@In" . ucfirst($name);
        return $temp;
    }
    
    /**
     * Retorna el Message de Error de la petición
     *  
     * @return string
     */
    public function getMessageError()
    {
        return $this->_dataBase->getMessageError();
    }
    
    /**
     * Retorna el Numero de Error de la petición
     * 
     * @return string 
     */
    public function getNumberError()
    {
        return $this->_dataBase->getNumberError();
    }
}