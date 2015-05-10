<?PHP
/**
 * @package viringo1.0.2.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Controlador Contruir la conexion con Base de Datos
 * 
 * @package viringo1.0.2.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.2.0  11/05/2012
 * @access public
 */
class Class_Db_Factory
{
    /**
     * @static
     */
   private static $_instance;
    
    
    /**
     * Instancia la clase del Manejador de Base de Datos
     * 
     * 
     * @return object $type
     */
    public static function getConnection($dataBaseManagementSystem, $prefixDb, $userDataBase)
    {
	
//		if(class_exists($type) )
//			return new $type($tempPrefixDb);
       if(!isset(self::$_instance[$prefixDb][$userDataBase])){
           self::$_instance[$prefixDb][$userDataBase] = new $dataBaseManagementSystem($prefixDb);
          
           
       }
       else if (!(self::$_instance[$prefixDb][$userDataBase] instanceof $dataBaseManagementSystem )) {
            self::$_instance[$prefixDb][$userDataBase] = new $dataBaseManagementSystem($prefixDb);
       
       // Class_Debug::pointRun(self::$_instance[$param]);
        
        }
        return self::$_instance[$prefixDb][$userDataBase];
    }
    
    public static function factoryDataBase($dataBaseManagementSystem, $prefixDb)
    {
        
        return new $dataBaseManagementSystem($prefixDb);
        
    }
}
